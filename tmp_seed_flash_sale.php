<?php
require __DIR__ . '/src/bootstrap.php';

$pdo = $PDO;

$columnExists = (int) $pdo->query("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'pd_collection'")->fetchColumn() > 0;
if (!$columnExists) {
    $pdo->exec("ALTER TABLE products ADD COLUMN pd_collection VARCHAR(50) NOT NULL DEFAULT '' AFTER pd_sizes");
}

$flashProducts = [
    ['pd_name' => 'Ao Linen Drift',       'pd_price' => 215000, 'pd_info' => 'Ao linen mong nhe, hop outfit he toi gian.',        'pd_image' => 'fs-1.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
    ['pd_name' => 'Dam Misty Blue',       'pd_price' => 275000, 'pd_info' => 'Dam xanh nhat, dang suong de mac hang ngay.',      'pd_image' => 'fs-2.jpg', 'cat_id' => 4, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
    ['pd_name' => 'Yem Soft Tide',        'pd_price' => 245000, 'pd_info' => 'Yem dang dai, chat lieu mem va thoang.',            'pd_image' => 'fs-3.jpg', 'cat_id' => 5, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
    ['pd_name' => 'Quan Chill Fit',       'pd_price' => 235000, 'pd_info' => 'Quan form rong nhe, de phoi ao co ban.',            'pd_image' => 'fs-4.jpg', 'cat_id' => 7, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
    ['pd_name' => 'Ao Crop Whisper',      'pd_price' => 199000, 'pd_info' => 'Ao crop co gian nhe, tong mau trung tinh.',         'pd_image' => 'fs-5.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
    ['pd_name' => 'Chan Vay Breeze',      'pd_price' => 225000, 'pd_info' => 'Chan vay bay nhe, duong cat thanh lich.',           'pd_image' => 'fs-6.jpg', 'cat_id' => 8, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
    ['pd_name' => 'Ao Polo Dawn',         'pd_price' => 205000, 'pd_info' => 'Ao polo daily wear, form gon de mac.',              'pd_image' => 'fs-7.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
    ['pd_name' => 'Dam Ribbon Light',     'pd_price' => 289000, 'pd_info' => 'Dam co diem nhan no nho, phong cach nu tinh.',      'pd_image' => 'fs-8.jpg', 'cat_id' => 4, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'flash-sale'],
];

$deleteStmt = $pdo->prepare("DELETE FROM products WHERE pd_collection = 'flash-sale' OR pd_name = :pd_name");
foreach ($flashProducts as $p) {
    $deleteStmt->execute([':pd_name' => $p['pd_name']]);
}

$insertStmt = $pdo->prepare(
    "INSERT INTO products (pd_name, pd_price, pd_info, pd_image, cat_id, pd_sizes, pd_collection)
     VALUES (:pd_name, :pd_price, :pd_info, :pd_image, :cat_id, :pd_sizes, :pd_collection)"
);

foreach ($flashProducts as $p) {
    $insertStmt->execute($p);
}

echo "Flash sale seed inserted.\n";
$rows = $pdo->query("SELECT pd_id, pd_name, pd_image FROM products WHERE pd_collection = 'flash-sale' ORDER BY pd_id DESC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo $r['pd_id'] . ' | ' . $r['pd_name'] . ' | ' . $r['pd_image'] . "\n";
}
