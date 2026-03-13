<?php
require __DIR__ . '/src/bootstrap.php';
$rows = $PDO->query('SELECT cat_id, cat_name FROM categories ORDER BY cat_id')->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    echo $row['cat_id'] . ':' . $row['cat_name'] . PHP_EOL;
}
