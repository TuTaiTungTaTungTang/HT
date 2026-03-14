<?php
require __DIR__ . '/src/bootstrap.php';

$stmt = $PDO->query('SELECT pd_collection, COUNT(*) as cnt FROM products GROUP BY pd_collection ORDER BY pd_collection');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo var_export($r['pd_collection'], true) . ' => ' . $r['cnt'] . PHP_EOL;
}
