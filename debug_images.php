<?php
require 'src/bootstrap.php';
use ct523\Project\Product;

$productModel = new Product($PDO);
$products = $productModel->all();

echo "Attempting to extract folder ID from pd_image:\n\n";
$found = 0;
$notfound = 0;

foreach (array_slice($products, 0, 20) as $p) {
    $id = $p->getID();
    $name = $p->pd_name;
    $img = $p->pd_image;
    
    // Extract number from "clothes-X-..." format
    if (preg_match('/clothes-(\d+)-/', $img, $matches)) {
        $folder_id = $matches[1];
        $clothing_dir = "public/images/clothes/$folder_id";
        
        if (is_dir($clothing_dir)) {
            $files = @scandir($clothing_dir);
            if ($files && count($files) > 2) {
                $file_list = implode(", ", array_slice(array_filter($files, function($f) { 
                    return !in_array($f, ['.', '..']); 
                }), 0, 2));
                echo "✓ ID: $id | Folder: $folder_id | Files: $file_list\n";
                $found++;
            } else {
                echo "✗ ID: $id | Folder: $folder_id | No images\n";
                $notfound++;
            }
        } else {
            echo "✗ ID: $id | Folder: $folder_id | Folder doesn't exist\n";
            $notfound++;
        }
    } else {
        echo "? ID: $id | Image: $img | Can't extract folder number\n";
    }
}

echo "\n\nSummary: Found $found, Not found $notfound\n";
?>


