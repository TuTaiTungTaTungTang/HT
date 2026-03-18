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