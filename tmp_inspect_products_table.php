<?php
require __DIR__ . '/src/bootstrap.php';

$create = $PDO->query("SHOW CREATE TABLE products")->fetch(PDO::FETCH_ASSOC);
echo $create['Create Table'] . PHP_EOL;
