<?php
require_once __DIR__ . '/src/bootstrap.php';

$stmt = $PDO->query('DESCRIBE users');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    echo implode(' | ', $row) . PHP_EOL;
}
