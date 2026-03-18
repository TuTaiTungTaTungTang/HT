<?php
require __DIR__ . '/src/bootstrap.php';

$rows = $PDO->query("SELECT pd_id, pd_name FROM products WHERE pd_image LIKE 'clothes-%' ORDER BY pd_id DESC")->fetchAll(PDO::FETCH_ASSOC);

$hasNumericSuffix = 0;
foreach ($rows as $r) {
    if (preg_match('/\s\d+$/u', (string) $r['pd_name'])) {
        $hasNumericSuffix++;
    }
}

echo 'Total clothes products: ' . count($rows) . PHP_EOL;
echo 'Names ending with number: ' . $hasNumericSuffix . PHP_EOL;
