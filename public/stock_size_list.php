<?php
session_start();

require_once __DIR__ . '/../src/bootstrap.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    redirect('/');
}

use CT27502\Project\Category;
use CT27502\Project\Product;

$productModel = new Product($PDO);
$products = $productModel->all();
$categoryModel = new Category($PDO);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
    $productId = isset($_POST['pd_id']) ? (int) $_POST['pd_id'] : 0;
    $stockInput = isset($_POST['stock']) && is_array($_POST['stock']) ? $_POST['stock'] : [];

    if ($productId > 0 && $productModel->saveSizeStockForProduct($productId, $stockInput)) {
        $_SESSION['flash_message'] = 'Cập nhật tồn kho theo size thành công.';
    } else {
        $_SESSION['flash_message'] = 'Không thể cập nhật tồn kho, vui lòng thử lại.';
    }

    redirect('stock_size_list.php');
}

include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container">
        <?php
        $subtitle = 'QUẢN LÝ TỒN KHO THEO SIZE';
        include_once __DIR__ . '/../src/partials/heading.php';
        ?>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div id="flash_message" class="text-success text-center fw-semibold mb-3">
                <?= html_escape($_SESSION['flash_message']) ?>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr class="text-center">
                        <th style="min-width: 320px;">Sản phẩm</th>
                        <th>Loại</th>
                        <?php foreach (Product::allowedSizes() as $sizeCode): ?>
                            <th><?= html_escape($sizeCode) ?></th>
                        <?php endforeach; ?>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <?php
                        $stockMap = $productModel->getSizeStockMap($product->getID());
                        $productSizes = array_filter(array_map('trim', explode(',', (string) ($product->pd_sizes ?? ''))));
                        ?>
                        <tr>
                            <form method="post" action="stock_size_list.php">
                                <input type="hidden" name="pd_id" value="<?= (int) $product->getID() ?>">

                                <td>
                                    <strong><?= html_escape($product->pd_name) ?></strong>
                                    <div class="text-muted small">ID: <?= (int) $product->getID() ?></div>
                                </td>
                                <td class="text-center"><?= html_escape($categoryModel->getNameByID((int) $product->cat_id)) ?></td>

                                <?php foreach (Product::allowedSizes() as $sizeCode): ?>
                                    <?php $enabled = in_array($sizeCode, $productSizes, true); ?>
                                    <td class="text-center">
                                        <input
                                            type="number"
                                            min="0"
                                            step="1"
                                            class="form-control text-center"
                                            name="stock[<?= html_escape($sizeCode) ?>]"
                                            value="<?= (int) ($stockMap[$sizeCode] ?? 0) ?>"
                                            <?= $enabled ? '' : 'readonly' ?>
                                        >
                                    </td>
                                <?php endforeach; ?>

                                <td class="text-center">
                                    <button type="submit" name="update_stock" class="btn btn-primary">
                                        Cập nhật
                                    </button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>