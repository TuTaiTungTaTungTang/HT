<?php
require __DIR__ . '/src/bootstrap.php';

// Ảnh đang dùng bởi sản phẩm CŨ (pd_collection = '')
$stmt = $PDO->query("SELECT pd_image, COUNT(*) as cnt FROM products WHERE pd_collection = '' GROUP BY pd_image ORDER BY cnt DESC");
echo "=== ẢNH SẢN PHẨM CŨ ===\n";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo $r['pd_image'] . ' (' . $r['cnt'] . ')\n';
}

// Ảnh đang dùng bởi BST
$stmt2 = $PDO->query("SELECT pd_image, pd_collection, pd_name FROM products WHERE pd_collection <> '' ORDER BY pd_collection");
echo "\n=== ẢNH BST ===\n";
foreach ($stmt2->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo '[' . $r['pd_collection'] . '] ' . $r['pd_name'] . ' => ' . $r['pd_image'] . "\n";
}
