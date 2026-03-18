<?php
require __DIR__ . '/src/bootstrap.php';

$sourceRoot = __DIR__ . '/public/images/clothes';
$uploadRoot = __DIR__ . '/public/uploads';

if (!is_dir($sourceRoot)) {
    fwrite(STDERR, "Source folder not found: $sourceRoot\n");
    exit(1);
}
if (!is_dir($uploadRoot)) {
    fwrite(STDERR, "Upload folder not found: $uploadRoot\n");
    exit(1);
}

function vn_slug(string $text): string
{
    $text = trim($text);
    $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    if ($ascii !== false) {
        $text = $ascii;
    }
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim((string) $text, '-');
    return $text;
}

function detect_image_ext_from_mime(string $path): ?string
{
    $mime = null;
    if (class_exists('finfo')) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = (string) $finfo->file($path);
    }

    $ext = match ($mime) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/avif' => 'avif',
        default => null,
    };
    if ($ext !== null) {
        return $ext;
    }

    $head = @file_get_contents($path, false, null, 0, 64);
    if ($head === false) {
        return null;
    }
    if (str_starts_with($head, "\xFF\xD8\xFF")) {
        return 'jpg';
    }
    if (str_starts_with($head, "\x89PNG\r\n\x1A\n")) {
        return 'png';
    }
    if (str_contains($head, 'ftypavif')) {
        return 'avif';
    }
    if (str_contains($head, 'WEBP')) {
        return 'webp';
    }

    return null;
}

function detect_category_id(string $name): int
{
    $n = mb_strtolower($name, 'UTF-8');

    if (str_contains($n, 'chân váy') || str_contains($n, 'chan vay')) {
        return 8;
    }
    if (str_contains($n, 'đầm') || str_contains($n, 'dam') || str_contains($n, 'váy') || str_contains($n, 'vay')) {
        return 4;
    }
    if (str_contains($n, 'yếm') || str_contains($n, 'yem')) {
        return 5;
    }
    if ((str_contains($n, 'quần') || str_contains($n, 'quan')) && str_contains($n, 'short')) {
        return 6;
    }
    if ((str_contains($n, 'quần') || str_contains($n, 'quan')) && (str_contains($n, 'ống rộng') || str_contains($n, 'ong rong'))) {
        return 7;
    }
    if (str_contains($n, 'quần') || str_contains($n, 'quan')) {
        return 2;
    }
    if (
        str_contains($n, 'áo') || str_contains($n, 'ao') || str_contains($n, 'khoác') || str_contains($n, 'khoac') ||
        str_contains($n, 'cardigan') || str_contains($n, 'hoodie') || str_contains($n, 'sơ mi') || str_contains($n, 'so mi') || str_contains($n, 'len')
    ) {
        return 1;
    }

    return 1;
}

function suggest_price(int $catId, int $seed): int
{
    [$min, $max] = match ($catId) {
        4 => [320000, 590000],
        5 => [260000, 460000],
        6 => [220000, 390000],
        7 => [260000, 430000],
        8 => [250000, 420000],
        default => [230000, 460000],
    };
    $range = $max - $min + 1;
    return $min + (($seed * 17037) % $range);
}

function category_label(int $catId): string
{
    return match ($catId) {
        1 => 'Ao',
        2 => 'Quan',
        3 => 'Phu Kien',
        4 => 'Dam',
        5 => 'Yem',
        6 => 'Quan Shorts',
        7 => 'Quan Ong Rong',
        8 => 'Chan Vay',
        default => 'San Pham',
    };
}

$folders = array_filter(scandir($sourceRoot) ?: [], static fn($f) => $f !== '.' && $f !== '..');

$insertSql = 'INSERT INTO products (pd_name, pd_price, pd_info, pd_image, cat_id, is_new, pd_sizes, pd_collection)
              VALUES (:pd_name, :pd_price, :pd_info, :pd_image, :cat_id, :is_new, :pd_sizes, :pd_collection)';
$insertStmt = $PDO->prepare($insertSql);
$deleteStmt = $PDO->prepare('DELETE FROM products WHERE pd_image = :pd_image');

// Make script idempotent: wipe all previously imported clothes-* rows before re-insert.
$PDO->exec("DELETE FROM products WHERE pd_image LIKE 'clothes-%'");

$imported = 0;
$skipped = 0;
$skippedFolders = [];

foreach ($folders as $folder) {
    $folderPath = $sourceRoot . DIRECTORY_SEPARATOR . $folder;
    if (!is_dir($folderPath)) {
        continue;
    }

    $files = array_filter(scandir($folderPath) ?: [], static function ($f) use ($folderPath) {
        if ($f === '.' || $f === '..') {
            return false;
        }
        $path = $folderPath . DIRECTORY_SEPARATOR . $f;
        if (!is_file($path)) {
            return false;
        }
        $ext = strtolower((string) pathinfo($f, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'avif', 'webp'], true)) {
            return true;
        }
        if ($ext === '') {
            return detect_image_ext_from_mime($path) !== null;
        }
        return false;
    });

    if (empty($files)) {
        $skipped++;
        $skippedFolders[] = $folder . ' (no image files)';
        continue;
    }

    usort($files, static fn($a, $b) => strcasecmp($a, $b));

    $preferred = null;
    foreach ($files as $f) {
        $lower = mb_strtolower($f, 'UTF-8');
        if (!str_contains($lower, 'background') && !str_contains($lower, 'gemini_generated')) {
            $preferred = $f;
            break;
        }
    }
    if ($preferred === null) {
        $preferred = $files[0];
    }

    $sourceFile = $folderPath . DIRECTORY_SEPARATOR . $preferred;

    $baseName = pathinfo($preferred, PATHINFO_FILENAME);
    $ext = strtolower((string) pathinfo($preferred, PATHINFO_EXTENSION));
    if ($ext === '') {
        $detectedExt = detect_image_ext_from_mime($sourceFile);
        if ($detectedExt === null) {
            $skipped++;
            $skippedFolders[] = $folder . ' (unknown image mime)';
            continue;
        }
        $ext = $detectedExt;
    }
    $slug = vn_slug($baseName);
    if ($slug === '') {
        $slug = 'item-' . vn_slug((string) $folder);
    }

    $targetFileName = 'clothes-' . vn_slug((string) $folder) . '-' . $slug . '.' . $ext;
    $targetPath = $uploadRoot . DIRECTORY_SEPARATOR . $targetFileName;

    if (!@copy($sourceFile, $targetPath)) {
        $skipped++;
        $skippedFolders[] = $folder . ' (copy failed)';
        continue;
    }

    $catId = detect_category_id($preferred . ' ' . $baseName);
    $folderSeed = (int) preg_replace('/\D+/', '', (string) $folder);
    if ($folderSeed <= 0) {
        $folderSeed = $imported + 1;
    }
    $displayName = category_label($catId) . ' Clothes ' . str_pad((string) $folderSeed, 2, '0', STR_PAD_LEFT);
    $price = suggest_price($catId, $folderSeed);

    $deleteStmt->execute([':pd_image' => $targetFileName]);

    $insertStmt->execute([
        ':pd_name' => $displayName,
        ':pd_price' => (string) $price,
        ':pd_info' => 'San pham duoc them tu bo suu tap hinh anh clothes.',
        ':pd_image' => $targetFileName,
        ':cat_id' => $catId,
        ':is_new' => 1,
        ':pd_sizes' => 'XS,M,L,Freezie',
        ':pd_collection' => '',
    ]);

    $imported++;
}

echo "Imported: $imported\n";
echo "Skipped: $skipped\n";
if (!empty($skippedFolders)) {
    echo "Skip detail:\n";
    foreach ($skippedFolders as $msg) {
        echo '- ' . $msg . "\n";
    }
}
$check = $PDO->query("SELECT COUNT(*) FROM products WHERE pd_image LIKE 'clothes-%'")->fetchColumn();
echo "Products with clothes-* images: $check\n";
