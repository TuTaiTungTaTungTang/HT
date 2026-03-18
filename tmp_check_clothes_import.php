<?php
require __DIR__ . '/src/bootstrap.php';

echo "== Count by category ==\n";
$sql = "SELECT cat_id, COUNT(*) AS total FROM products WHERE pd_image LIKE 'clothes-%' GROUP BY cat_id ORDER BY cat_id";
foreach ($PDO->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo $r['cat_id'] . ': ' . $r['total'] . PHP_EOL;
}

echo "\n== Newest 15 imported ==\n";
$sql2 = "SELECT pd_id, pd_name, pd_image, pd_price, cat_id FROM products WHERE pd_image LIKE 'clothes-%' ORDER BY pd_id DESC LIMIT 15";
foreach ($PDO->query($sql2)->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo $r['pd_id'] . ' | ' . $r['pd_name'] . ' | ' . $r['pd_image'] . ' | ' . $r['pd_price'] . ' | cat=' . $r['cat_id'] . PHP_EOL;
}
