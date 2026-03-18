<?php
require __DIR__ . '/src/bootstrap.php';

function make_name(int $catId, int $index): string
{
    $ao = ['Aurora', 'Luna', 'Misty', 'Bloom', 'Ivy', 'Silk', 'Pearl', 'Nora', 'Nova', 'Milan'];
    $dam = ['Rosie', 'Velvet', 'Sunny', 'Noir', 'Cherry', 'Elise', 'Daisy', 'Lily', 'Mira', 'Ruby'];
    $quan = ['Cloud', 'Urban', 'Mono', 'Flow', 'Swift', 'Cove', 'Street', 'Breeze'];
    $yem = ['Daisy', 'Tulip', 'Amber', 'Blush', 'Olive', 'Coral'];
    $shorts = ['Sporty', 'Chill', 'Vibe', 'Move', 'Dash'];
    $rong = ['Metro', 'Daily', 'Classic', 'Skyline', 'Ease'];
    $chanvay = ['Grace', 'Muse', 'Flare', 'Lace', 'Twirl'];

    $pick = static function (array $pool, int $i): string {
        return $pool[$i % count($pool)];
    };

    $suffix = str_pad((string) $index, 2, '0', STR_PAD_LEFT);

    return match ($catId) {
        1 => 'Ao ' . $pick($ao, $index) . ' ' . $suffix,
        2 => 'Quan ' . $pick($quan, $index) . ' ' . $suffix,
        4 => 'Dam ' . $pick($dam, $index) . ' ' . $suffix,
        5 => 'Yem ' . $pick($yem, $index) . ' ' . $suffix,
        6 => 'Quan Shorts ' . $pick($shorts, $index) . ' ' . $suffix,
        7 => 'Quan Ong Rong ' . $pick($rong, $index) . ' ' . $suffix,
        8 => 'Chan Vay ' . $pick($chanvay, $index) . ' ' . $suffix,
        default => 'San Pham Fashion ' . $suffix,
    };
}

$rows = $PDO->query("SELECT pd_id, cat_id, pd_image FROM products WHERE pd_image LIKE 'clothes-%' ORDER BY pd_id ASC")->fetchAll(PDO::FETCH_ASSOC);

$update = $PDO->prepare('UPDATE products SET pd_name = :pd_name WHERE pd_id = :pd_id');
$updated = 0;

foreach ($rows as $row) {
    $image = (string) $row['pd_image'];
    if (!preg_match('/^clothes-(\d+)-/i', $image, $m)) {
        continue;
    }

    $index = (int) $m[1];
    $name = make_name((int) $row['cat_id'], $index);

    $ok = $update->execute([
        ':pd_name' => $name,
        ':pd_id' => (int) $row['pd_id'],
    ]);

    if ($ok) {
        $updated++;
    }
}

echo "Renamed products: $updated\n";
$preview = $PDO->query("SELECT pd_id, pd_name, pd_image, cat_id FROM products WHERE pd_image LIKE 'clothes-%' ORDER BY pd_id DESC LIMIT 12")->fetchAll(PDO::FETCH_ASSOC);
foreach ($preview as $r) {
    echo $r['pd_id'] . ' | ' . $r['pd_name'] . ' | ' . $r['pd_image'] . ' | cat=' . $r['cat_id'] . PHP_EOL;
}
