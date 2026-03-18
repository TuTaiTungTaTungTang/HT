<?php
require __DIR__ . '/src/bootstrap.php';

$sourceRoot = __DIR__ . '/public/images/clothes';

function clean_display_name(string $name): string
{
    $name = preg_replace('/\.[a-zA-Z0-9]+$/u', '', $name);
    $name = str_replace(['_', '-'], ' ', $name);
    $name = preg_replace('/\b(background|backgroun|backgrou|gemini generated image)\b/iu', '', $name);
    $name = preg_replace('/\s+/u', ' ', (string) $name);
    $name = trim((string) $name);

    // Remove pure numeric suffixes/prefixes that look like indexing.
    $name = preg_replace('/^\d+\s*/u', '', $name);
    $name = preg_replace('/\s*\d+$/u', '', $name);
    $name = trim((string) $name);

    if ($name === '') {
        $name = 'San pham thoi trang';
    }

    return mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
}

function detect_image_ext_from_file(string $path): ?string
{
    $ext = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'avif'], true)) {
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

$folders = array_filter(scandir($sourceRoot) ?: [], static fn($f) => $f !== '.' && $f !== '..');
$mapByFolder = [];

foreach ($folders as $folder) {
    $folderPath = $sourceRoot . DIRECTORY_SEPARATOR . $folder;
    if (!is_dir($folderPath)) {
        continue;
    }

    $files = array_filter(scandir($folderPath) ?: [], static function ($f) use ($folderPath) {
        if ($f === '.' || $f === '..') {
            return false;
        }
        $p = $folderPath . DIRECTORY_SEPARATOR . $f;
        if (!is_file($p)) {
            return false;
        }
        return detect_image_ext_from_file($p) !== null;
    });

    if (empty($files)) {
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

    $baseName = pathinfo($preferred, PATHINFO_FILENAME);
    $mapByFolder[(string) $folder] = clean_display_name($baseName);
}

$rows = $PDO->query("SELECT pd_id, pd_image FROM products WHERE pd_image LIKE 'clothes-%' ORDER BY pd_id ASC")->fetchAll(PDO::FETCH_ASSOC);
$update = $PDO->prepare('UPDATE products SET pd_name = :name WHERE pd_id = :id');

$updated = 0;
foreach ($rows as $row) {
    if (!preg_match('/^clothes-(\d+)-/i', (string) $row['pd_image'], $m)) {
        continue;
    }

    $folder = (string) (int) $m[1];
    if (!isset($mapByFolder[$folder])) {
        continue;
    }

    $name = $mapByFolder[$folder];
    if ($name === '') {
        continue;
    }

    if ($update->execute([':name' => $name, ':id' => (int) $row['pd_id']])) {
        $updated++;
    }
}

echo "Renamed from source filenames: $updated\n";
$preview = $PDO->query("SELECT pd_id, pd_name, pd_image FROM products WHERE pd_image LIKE 'clothes-%' ORDER BY pd_id DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
foreach ($preview as $r) {
    echo $r['pd_id'] . ' | ' . $r['pd_name'] . ' | ' . $r['pd_image'] . PHP_EOL;
}
