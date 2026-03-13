<?php
require __DIR__ . '/src/bootstrap.php';
$cats = $PDO->query('SELECT cat_id, cat_name FROM categories ORDER BY cat_id')->fetchAll(PDO::FETCH_ASSOC);
foreach ($cats as $row) {
    echo 'CAT ' . $row['cat_id'] . ':' . $row['cat_name'] . PHP_EOL;
}
$count = $PDO->query('SELECT COUNT(*) AS c FROM products')->fetch(PDO::FETCH_ASSOC);
echo 'PRODUCT_COUNT:' . $count['c'] . PHP_EOL;
$sample = $PDO->query('SELECT pd_id, pd_name FROM products ORDER BY pd_id LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
foreach ($sample as $row) {
    echo 'PD ' . $row['pd_id'] . ':' . $row['pd_name'] . PHP_EOL;
}
