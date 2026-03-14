<?php
require __DIR__ . '/src/bootstrap.php';

$PDO->beginTransaction();

try {
    /* ================================================================
       1. Thêm danh mục mới
       ================================================================ */
    $PDO->exec("INSERT IGNORE INTO categories (cat_id, cat_name) VALUES
        (4, 'Đầm'),
        (5, 'Yếm'),
        (6, 'Quần Shorts'),
        (7, 'Quần ống rộng'),
        (8, 'Chân váy')");

    /* ================================================================
       2. Phân loại lại sản phẩm quần hiện có sang danh mục mới
       ================================================================ */

    // Quần Shorts (cat_id=6)
    $PDO->exec("UPDATE products SET cat_id = 6
        WHERE cat_id = 2
          AND (pd_name LIKE '%short%' OR pd_name LIKE '%Short%')");

    // Quần ống rộng (cat_id=7)
    $PDO->exec("UPDATE products SET cat_id = 7
        WHERE cat_id = 2
          AND (pd_name LIKE '%baggy%' OR pd_name LIKE '%Baggy%'
            OR pd_name LIKE '%culottes%' OR pd_name LIKE '%Culottes%'
            OR pd_name LIKE '%ống suông%' OR pd_name LIKE '%ống rộng%')");

    /* ================================================================
       3. Thêm sản phẩm mẫu cho Đầm, Yếm, Chân váy
       ================================================================ */
    $PDO->exec("INSERT INTO products (pd_name, pd_price, pd_info, pd_image, cat_id) VALUES
        -- Đầm (cat_id=4)
        ('Đầm suông vải linen nữ tính',        '345000', 'Đầm suông chất linen mát, dáng rộng thoải mái mặc mùa hè.',            'dam-suong-linen.jpg',       4),
        ('Đầm xòe hoa nhí dáng midi',          '389000', 'Đầm xòe họa tiết hoa nhí, dáng midi thanh lịch quyến rũ.',            'dam-xoe-hoa-nhi.jpg',       4),
        ('Đầm body ôm dáng cổ vuông',          '275000', 'Đầm body cổ vuông, ôm vóc dáng, phù hợp đi tiệc nhẹ.',               'dam-body-co-vuong.jpg',     4),
        ('Đầm babydoll tay phồng',             '299000', 'Đầm babydoll tay phồng dáng búp bê, trẻ trung và đáng yêu.',          'dam-babydoll.jpg',          4),
        ('Đầm maxi vải voan dự tiệc',          '465000', 'Đầm maxi dài vải voan nhẹ, phù hợp đi tiệc hoặc chụp ảnh ngoại cảnh.','dam-maxi-voan.jpg',        4),

        -- Yếm (cat_id=5)
        ('Yếm jean dáng rộng unisex',          '265000', 'Yếm jean cổ thấp, dáng rộng dễ phối áo thun hoặc áo croptop.',       'yem-jean-rong.jpg',         5),
        ('Yếm vải thô cổ chữ U',              '225000', 'Yếm vải thô mềm, cổ chữ U thanh thoát, mặc mùa hè mát mẻ.',         'yem-vai-tho.jpg',           5),
        ('Yếm trắng phối ren dáng ngắn',       '245000', 'Yếm trắng phối đăng-ten tinh tế, dáng ngắn trẻ trung.',              'yem-trang-ren.jpg',         5),
        ('Yếm kẻ caro vintage',                '255000', 'Yếm kẻ caro phong cách vintage, dễ phối với nhiều kiểu áo.',          'yem-caro-vintage.jpg',      5),

        -- Chân váy (cat_id=8)
        ('Chân váy midi xếp ly thanh lịch',    '315000', 'Chân váy midi xếp ly nhiều tầng, dáng suông nhẹ nhàng duyên dáng.',  'chan-vay-midi-xep-ly.jpg',  8),
        ('Chân váy tennis ngắn trắng',         '285000', 'Chân váy tennis viền đăng-ten, năng động phù hợp nhiều style.',      'chan-vay-tennis.jpg',       8),
        ('Chân váy jean mini dáng A',          '295000', 'Chân váy jean mini dáng chữ A, trẻ trung và dễ mặc.',                'chan-vay-jean-mini.jpg',    8),
        ('Chân váy dài vải chiffon hoa',       '355000', 'Chân váy dài vải chiffon nhẹ, họa tiết hoa đẹp mắt.',               'chan-vay-chiffon-hoa.jpg',  8),
        ('Chân váy bút chì công sở kẻ sọc',   '375000', 'Chân váy bút chì kẻ sọc mảnh, lịch sự cho môi trường văn phòng.',   'chan-vay-but-chi.jpg',      8)");

    $PDO->commit();

    // Hiển thị thống kê
    $rows = $PDO->query("SELECT c.cat_id, c.cat_name, COUNT(p.pd_id) AS total
        FROM categories c LEFT JOIN products p ON p.cat_id = c.cat_id
        GROUP BY c.cat_id ORDER BY c.cat_id")->fetchAll();

    echo "=== Migration hoàn thành ===\n\n";
    echo sprintf("%-6s %-25s %s\n", "cat_id", "Danh mục", "Số sản phẩm");
    echo str_repeat('-', 45) . "\n";
    foreach ($rows as $r) {
        echo sprintf("%-6s %-25s %d\n", $r['cat_id'], $r['cat_name'], $r['total']);
    }
    echo "\nTổng: " . array_sum(array_column($rows, 'total')) . " sản phẩm\n";

} catch (Throwable $e) {
    $PDO->rollBack();
    echo "Migration thất bại: " . $e->getMessage() . "\n";
    exit(1);
}
