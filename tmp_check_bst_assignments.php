<?php
require __DIR__ . '/src/bootstrap.php';

$count = (int) $PDO->query("SELECT COUNT(*) FROM products WHERE pd_collection <> ''")->fetchColumn();
echo $count . PHP_EOL;
