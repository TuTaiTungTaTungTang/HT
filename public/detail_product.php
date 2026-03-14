<?php 
require_once __DIR__ . '/../src/bootstrap.php';

use CT27502\Project\Product;
use CT27502\Project\Category;

$product = new Product($PDO);

$id = isset($_REQUEST['id']) ? filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
if($id<0 || !($product->find($id))) {
    redirect('/');
}

$category = new Category($PDO);

include_once __DIR__ . '/../src/partials/header.php' 
?>

<body>

    <?php include_once __DIR__ . '/../src/partials/navbar.php' ?>


    <div class="container detail-page">
        <div class="row product-detail-wrap">
            <!-- Hình ảnh -->
            <div class="col-md-4 my-5">
                <img class="img_product" src="<?= './uploads/' . html_escape($product->pd_image) ?>" alt="" width="100%">
            </div>
            <div class="col-md-7 offset-lg-1 my-5">
                <!-- Tên sản phẩm -->
                <h3 class="title_product"><?= html_escape($product->pd_name) ?></h3>

                <!-- Tên danh mục sản phẩm -->
                <p class="my-3 product-meta"><b>Danh mục:</b> <?=html_escape($category->getNameByID($product->cat_id)) ?></p>

                <!-- Giá sản phẩm -->
                <p class="price_product my-3"><?= number_format($product->pd_price) . '₫' ?></p>

                <hr class="my-3">

                <?php
                $sizes = !empty($product->pd_sizes)
                    ? array_filter(array_map('trim', explode(',', $product->pd_sizes)))
                    : [];
                ?>

                <!-- Chọn kích thước -->
                <?php if (!empty($sizes)) : ?>
                <div class="pd-size-section mb-4">
                    <p class="pd-section-label">Kích thước: <span class="pd-selected-size-label"></span></p>
                    <div class="pd-size-picker">
                        <?php foreach ($sizes as $sz) : ?>
                            <button type="button" class="pd-size-btn" data-size="<?= html_escape($sz) ?>">
                                <?= html_escape($sz) ?>
                            </button>
                        <?php endforeach ?>
                    </div>
                </div>
                <?php endif ?>

                <!-- Số lượng + thêm giỏ -->
                <?php if(isset($_SESSION['role']) && $_SESSION['role']==='user' && isset($_SESSION['id'])) : ?>
                <form action="cart_add.php" method="post" id="addCartForm">
                    <input type="hidden" name="idsanpham" value="<?= $product->getID() ?>">
                    <input type="hidden" name="iduser" value="<?= (int)$_SESSION['id'] ?>">
                    <input type="hidden" name="pd_size" id="pd_size_input" value="">

                    <div class="pd-qty-row mb-4">
                        <div class="pd-qty-wrap">
                            <button type="button" class="pd-qty-btn decrement_btn" aria-label="Giảm">&#8722;</button>
                            <input type="number" class="pd-qty-input pd_qty" name="quantity" value="1" min="1" max="99" readonly>
                            <button type="button" class="pd-qty-btn increment_btn" aria-label="Tăng">&#43;</button>
                        </div>
                    </div>

                    <div class="pd-action-row">
                        <button type="submit" name="themgiohang" class="pd-btn-cart">Thêm vào giỏ</button>
                        <button type="submit" name="themgiohang" class="pd-btn-buynow" id="buyNowBtn">Mua ngay</button>
                    </div>
                </form>
                <?php else : ?>
                <div class="pd-qty-row mb-4">
                    <div class="pd-qty-wrap">
                        <button type="button" class="pd-qty-btn" disabled>&#8722;</button>
                        <input type="number" class="pd-qty-input" value="1" min="1" max="99" readonly disabled>
                        <button type="button" class="pd-qty-btn" disabled>&#43;</button>
                    </div>
                </div>
                <div class="pd-action-row">
                    <a href="/onlinestore/public/login.php" class="pd-btn-cart">Đăng nhập để mua</a>
                </div>
                <?php endif ?>

                <!-- Thông tin sản phẩm -->
                <div class="my-4 product-info-wrap">
                    <p class="info_product"><?= html_escape($product->pd_info) ?></p>
                </div>
            </div>
        </div>


    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php' ?>

    <script>
        (function () {
            // --- Size selector ---
            var sizeButtons = document.querySelectorAll('.pd-size-btn');
            var sizeInput   = document.getElementById('pd_size_input');
            var sizeLabel   = document.querySelector('.pd-selected-size-label');

            sizeButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var isActive = btn.classList.contains('active');
                    // Bỏ chọn tất cả trước
                    sizeButtons.forEach(function (b) { b.classList.remove('active'); });
                    if (!isActive) {
                        // Chọn cái đã click
                        btn.classList.add('active');
                        if (sizeInput) sizeInput.value = btn.dataset.size;
                        if (sizeLabel) sizeLabel.textContent = btn.dataset.size;
                    } else {
                        // Click lần 2 → bỏ chọn
                        if (sizeInput) sizeInput.value = '';
                        if (sizeLabel) sizeLabel.textContent = '';
                    }
                });
            });

            // --- Quantity +/- ---
            var qtyInput = document.querySelector('.pd_qty');

            document.querySelector('.increment_btn') && document.querySelector('.increment_btn').addEventListener('click', function () {
                var v = parseInt(qtyInput.value, 10);
                if (v < 99) { qtyInput.value = v + 1; }
            });

            document.querySelector('.decrement_btn') && document.querySelector('.decrement_btn').addEventListener('click', function () {
                var v = parseInt(qtyInput.value, 10);
                if (v > 1) { qtyInput.value = v - 1; }
            });
        })();
    </script>

</body>

</html>

