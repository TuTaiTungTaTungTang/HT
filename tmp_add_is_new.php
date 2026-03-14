<?php
require __DIR__ . '/src/bootstrap.php';

$PDO->exec('ALTER TABLE products ADD COLUMN IF NOT EXISTS is_new TINYINT(1) NOT NULL DEFAULT 0');
$PDO->exec('UPDATE products SET is_new = 1 WHERE pd_id > 40');
$count = $PDO->query('SELECT COUNT(*) FROM products WHERE is_new = 1')->fetchColumn();
echo "is_new=1: $count san pham\n";
echo "Xong!\n";
