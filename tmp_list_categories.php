<?php
require __DIR__ . '/src/bootstrap.php';

$rows = $PDO->query('SELECT cat_id, cat_name FROM categories ORDER BY cat_id')->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo $r['cat_id'] . '|' . $r['cat_name'] . PHP_EOL;
}
