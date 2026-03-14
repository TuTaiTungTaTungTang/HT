<?php
require __DIR__ . '/src/bootstrap.php';

// 1. Thêm cột pd_sizes
$PDO->exec("ALTER TABLE products ADD COLUMN IF NOT EXISTS pd_sizes VARCHAR(50) NOT NULL DEFAULT ''");

// 2. Gán kích thước mặc định theo danh mục
$PDO->exec("UPDATE products SET pd_sizes = 'XS,M,L,Freezie' WHERE cat_id = 1");  // Áo
$PDO->exec("UPDATE products SET pd_sizes = 'XS,M,L'          WHERE cat_id = 2");  // Quần còn lại
$PDO->exec("UPDATE products SET pd_sizes = 'Freezie'          WHERE cat_id = 3");  // Phụ kiện
$PDO->exec("UPDATE products SET pd_sizes = 'XS,M,L'           WHERE cat_id = 4");  // Đầm
$PDO->exec("UPDATE products SET pd_sizes = 'XS,M,L,Freezie'   WHERE cat_id = 5");  // Yếm
$PDO->exec("UPDATE products SET pd_sizes = 'XS,M,L'           WHERE cat_id = 6");  // Quần Shorts
$PDO->exec("UPDATE products SET pd_sizes = 'XS,M,L,Freezie'   WHERE cat_id = 7");  // Quần ống rộng
$PDO->exec("UPDATE products SET pd_sizes = 'XS,M,L'           WHERE cat_id = 8");  // Chân váy

$rows = $PDO->query("SELECT cat_id, pd_sizes, COUNT(*) as cnt FROM products GROUP BY cat_id, pd_sizes ORDER BY cat_id")->fetchAll();
echo "=== Kích thước đã gán ===\n";
foreach ($rows as $r) {
    echo "cat_id={$r['cat_id']}  sizes={$r['pd_sizes']}  ({$r['cnt']} sp)\n";
}
echo "\nXong!\n";
