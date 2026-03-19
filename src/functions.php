<?php

function redirect(string $location): void
{
    // Keep legacy calls redirect('/') inside this project instead of localhost/.
    if ($location === '/') {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $scriptDir = rtrim($scriptDir, '/');
        $location = ($scriptDir === '' ? '' : $scriptDir) . '/index.php';
    }

    header('Location: ' . $location, true, 302);
    exit();
}

function ensure_user_avatar_column(PDO $pdo): void
{
    static $checked = false;
    if ($checked) {
        return;
    }

    $checked = true;

    $statement = $pdo->query("SHOW COLUMNS FROM users LIKE 'user_avatar'");
    $column = $statement ? $statement->fetch() : false;
    if (!$column) {
        $pdo->exec("ALTER TABLE users ADD COLUMN user_avatar VARCHAR(255) NOT NULL DEFAULT ''");
    }
}

function ensure_user_profile_columns(PDO $pdo): void
{
    static $checked = false;
    if ($checked) {
        return;
    }

    $checked = true;

    $requiredColumns = [
        "ALTER TABLE users ADD COLUMN user_avatar VARCHAR(255) NOT NULL DEFAULT ''",
        "ALTER TABLE users ADD COLUMN user_birthday DATE NULL",
        "ALTER TABLE users ADD COLUMN user_gender VARCHAR(20) NOT NULL DEFAULT ''",
        "ALTER TABLE users ADD COLUMN user_phone VARCHAR(20) NOT NULL DEFAULT ''",
        "ALTER TABLE users ADD COLUMN user_address VARCHAR(255) NOT NULL DEFAULT ''",
        "ALTER TABLE users ADD COLUMN user_contact_email VARCHAR(255) NOT NULL DEFAULT ''",
        "ALTER TABLE users ADD COLUMN user_website VARCHAR(255) NOT NULL DEFAULT ''",
    ];

    foreach ($requiredColumns as $sql) {
        try {
            $pdo->exec($sql);
        } catch (Throwable $th) {
            // Ignore duplicate-column errors when schema is already up-to-date.
        }
    }
}

// Loại bỏ ký tự đặc biệt
function html_escape(string|null $text): string
{
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8', false);
}

function handle_image_upload(): string | bool
{
    if (!isset($_FILES['image'])) {
        return false;
    }

    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp_name = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];

    if($image_tmp_name=='') {
        return false;
    }
    // Kiểm tra loại file ảnh
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $image_info = getimagesize($image_tmp_name);
    $image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    if (!in_array($image_type, $allowed_types) || !$image_info) {
        return false;
    }

    // Kiểm tra kích thước ảnh dưới 2MB
    if($image_error !== 0 || $image_size > 2000000) {
        return false;
    }
    
    $image_new_name = uniqid() . '_' . $image_name;
    $image_destination = __DIR__ . '/../public/uploads/' . $image_new_name;

    if (!move_uploaded_file($image_tmp_name, $image_destination)) {
        return false;
    }

    return $image_new_name;
}

function remove_image_file(string $filename): bool {
    $file_path = __DIR__ . '/../public/uploads/' . $filename;
    if(file_exists($file_path)) {
        return unlink($file_path);
    }
    
    return false;
}

function ensure_product_size_stock_table(PDO $pdo): void
{
    static $checked = false;
    if ($checked) {
        return;
    }

    $checked = true;

    $pdo->exec('CREATE TABLE IF NOT EXISTS product_size_stock (
        stock_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        pd_id INT(11) UNSIGNED NOT NULL,
        size_code VARCHAR(20) NOT NULL,
        quantity INT(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (stock_id),
        UNIQUE KEY uniq_pd_size (pd_id, size_code),
        CONSTRAINT fk_stock_product FOREIGN KEY (pd_id) REFERENCES products(pd_id) ON DELETE CASCADE
    ) ENGINE=InnoDB');

    $allowedSizes = ['XS', 'M', 'L', 'Freezie'];
    $productRows = $pdo->query('SELECT pd_id, pd_sizes FROM products');
    if (!$productRows) {
        return;
    }

    $insertStatement = $pdo->prepare('INSERT IGNORE INTO product_size_stock (pd_id, size_code, quantity) VALUES (:pd_id, :size_code, 0)');

    while ($row = $productRows->fetch(PDO::FETCH_ASSOC)) {
        $productId = (int) ($row['pd_id'] ?? 0);
        if ($productId <= 0) {
            continue;
        }

        $sizes = array_filter(array_map('trim', explode(',', (string) ($row['pd_sizes'] ?? ''))));
        foreach ($sizes as $sizeCode) {
            if (!in_array($sizeCode, $allowedSizes, true)) {
                continue;
            }

            $insertStatement->execute([
                'pd_id' => $productId,
                'size_code' => $sizeCode,
            ]);
        }
    }
}

function ensure_cart_order_size_columns(PDO $pdo): void
{
    static $checked = false;
    if ($checked) {
        return;
    }

    $checked = true;

    try {
        $pdo->exec("ALTER TABLE carts ADD COLUMN pd_size VARCHAR(20) NOT NULL DEFAULT 'Freezie' AFTER pd_id");
    } catch (Throwable $th) {
        // Ignore duplicate-column errors when schema is already up-to-date.
    }

    try {
        $pdo->exec("ALTER TABLE orders ADD COLUMN pd_size VARCHAR(20) NOT NULL DEFAULT 'Freezie' AFTER pd_id");
    } catch (Throwable $th) {
        // Ignore duplicate-column errors when schema is already up-to-date.
    }

    try {
        $pdo->exec("ALTER TABLE orders ADD COLUMN stock_deducted TINYINT(1) NOT NULL DEFAULT 0 AFTER pd_quantity");
    } catch (Throwable $th) {
        // Ignore duplicate-column errors when schema is already up-to-date.
    }

    try {
        $pdo->exec("ALTER TABLE orders ADD COLUMN stock_returned TINYINT(1) NOT NULL DEFAULT 0 AFTER stock_deducted");
    } catch (Throwable $th) {
        // Ignore duplicate-column errors when schema is already up-to-date.
    }

    $pdo->exec("UPDATE carts SET pd_size = 'Freezie' WHERE pd_size IS NULL OR TRIM(pd_size) = ''");
    $pdo->exec("UPDATE orders SET pd_size = 'Freezie' WHERE pd_size IS NULL OR TRIM(pd_size) = ''");

    $pkColumns = [];
    $pkRows = [];
    $pkStatement = $pdo->query("SHOW INDEX FROM carts WHERE Key_name = 'PRIMARY'");
    if ($pkStatement) {
        while ($row = $pkStatement->fetch(PDO::FETCH_ASSOC)) {
            $pkRows[] = $row;
        }
    }

    usort($pkRows, static function (array $a, array $b): int {
        return ((int) ($a['Seq_in_index'] ?? 0)) <=> ((int) ($b['Seq_in_index'] ?? 0));
    });

    foreach ($pkRows as $pkRow) {
        $pkColumns[] = (string) ($pkRow['Column_name'] ?? '');
    }

    if ($pkColumns !== ['user_id', 'pd_id', 'pd_size']) {
        $pdo->exec('ALTER TABLE carts DROP PRIMARY KEY, ADD PRIMARY KEY (user_id, pd_id, pd_size)');
    }
}