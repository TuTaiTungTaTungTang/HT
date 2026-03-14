<?php
require __DIR__ . '/src/bootstrap.php';

foreach ($PDO->query('SELECT pd_id, pd_name FROM products ORDER BY pd_id') as $row) {
    echo $row['pd_id'] . ' | ' . $row['pd_name'] . PHP_EOL;
}
