<?php 
require_once __DIR__ . '/../src/bootstrap.php';

use CT27502\Project\Product;
use CT27502\Project\Category;

$product = new Product($PDO);

$id = isset($_REQUEST['id']) ? filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
if($id<0 || !($product->find($id))) {
    redirect('/');
}

$relatedProductModel = new Product($PDO);
$relatedProducts = $relatedProductModel->relatedProducts($product->cat_id, $product->getID(), 12);

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
                        <button type="submit" name="themgiohang" class="pd-btn-cart" id="addToCartBtn">Thêm vào giỏ</button>
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

        <?php if (!empty($relatedProducts)) : ?>
            <section class="related-products-section">
                <div class="section-head text-center">
                    <h2 class="title">SẢN PHẨM LIÊN QUAN</h2>
                    <p class="section-divider">___ /// ___</p>
                </div>

                <div class="related-slider-wrap">
                    <button type="button" class="related-slider-btn prev" id="relatedPrevBtn" aria-label="Sản phẩm trước">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <div class="related-slider-viewport" id="relatedSliderViewport">
                        <div class="related-products-row" id="relatedProductsTrack">
                            <?php foreach ($relatedProducts as $relatedProduct) : ?>
                                <div class="related-slide-item">
                                    <article class="related-card">
                                        <a href="detail_product.php?id=<?= $relatedProduct->getID() ?>" class="related-card-image-wrap" aria-label="Xem <?= html_escape($relatedProduct->pd_name) ?>">
                                            <img src="<?= './uploads/' . html_escape($relatedProduct->pd_image) ?>" alt="<?= html_escape($relatedProduct->pd_name) ?>" class="related-card-image">
                                        </a>
                                        <div class="related-card-body">
                                            <a href="detail_product.php?id=<?= $relatedProduct->getID() ?>" class="related-card-title-link">
                                                <h3 class="related-card-title"><?= html_escape($relatedProduct->pd_name) ?></h3>
                                            </a>
                                            <p class="related-card-price"><?= number_format((int) $relatedProduct->pd_price) ?>₫</p>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <button type="button" class="related-slider-btn next" id="relatedNextBtn" aria-label="Sản phẩm tiếp theo">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </section>
        <?php endif ?>


    </div>

    <div class="modal fade" id="detailAddCartSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered add-cart-success-dialog">
            <div class="modal-content add-cart-success-content">
                <div class="modal-body add-cart-success-body">
                    <button type="button" class="btn-close add-cart-success-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="add-cart-success-check">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <p class="add-cart-success-title">Thêm vào giỏ thành công</p>
                    <div class="add-cart-success-product">
                        <span id="detailAddCartSuccessQty" class="add-cart-success-qty">1</span>
                        <img id="detailAddCartSuccessImage" src="" alt="Sản phẩm" class="add-cart-success-image">
                        <div>
                            <p id="detailAddCartSuccessName" class="add-cart-success-name"></p>
                            <p id="detailAddCartSuccessPrice" class="add-cart-success-price"></p>
                        </div>
                    </div>
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
            var addCartForm = document.getElementById('addCartForm');
            var successModalEl = document.getElementById('detailAddCartSuccessModal');
            var successModal = successModalEl && window.bootstrap ? new bootstrap.Modal(successModalEl) : null;

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

            function formatVnd(n) {
                return Number(n || 0).toLocaleString('vi-VN') + '₫';
            }

            function updateMiniCartFromDetail(quantity) {
                var badge = document.querySelector('.cart-count-badge');
                if (badge) {
                    var curr = parseInt(badge.textContent || '0', 10);
                    badge.textContent = String(curr + quantity);
                }

                var miniCartList = document.getElementById('miniCartList');
                if (!miniCartList) {
                    return quantity;
                }

                var productId = addCartForm.querySelector('input[name="idsanpham"]').value;
                var productName = document.querySelector('.title_product') ? document.querySelector('.title_product').textContent.trim() : '';
                var productImage = document.querySelector('.img_product') ? document.querySelector('.img_product').getAttribute('src') : '';
                var productPriceText = document.querySelector('.price_product') ? document.querySelector('.price_product').textContent.trim() : '0₫';
                var productPrice = parseInt(productPriceText.replace(/[^\d]/g, ''), 10) || 0;

                var existed = miniCartList.querySelector('.mini-cart-item[data-pd-id="' + productId + '"]');
                var finalQty = quantity;

                if (existed) {
                    var qtyInputEl = existed.querySelector('.mini-cart-qty');
                    var linePriceEl = existed.querySelector('.mini-cart-line-price');
                    if (qtyInputEl) {
                        finalQty = parseInt(qtyInputEl.value || '1', 10) + quantity;
                        qtyInputEl.value = String(finalQty);
                    }
                    if (linePriceEl) {
                        linePriceEl.textContent = formatVnd(productPrice * finalQty);
                    }
                } else {
                    var emptyEl = miniCartList.querySelector('#miniCartEmpty');
                    if (emptyEl) {
                        emptyEl.remove();
                    }

                    var item = document.createElement('div');
                    item.className = 'mini-cart-item';
                    item.setAttribute('data-pd-id', productId);
                    item.setAttribute('data-price', String(productPrice));
                    item.innerHTML = '' +
                        '<img src="' + productImage + '" alt="' + productName.replace(/"/g, '&quot;') + '" class="mini-cart-thumb">' +
                        '<div class="mini-cart-info">' +
                            '<p class="mini-cart-name">' + productName + '</p>' +
                            '<div class="mini-cart-qty-wrap">' +
                                '<button type="button" class="mini-cart-qty-btn decrement">&#8722;</button>' +
                                '<input type="number" class="mini-cart-qty" value="' + quantity + '" min="1" max="99" readonly>' +
                                '<button type="button" class="mini-cart-qty-btn increment">&#43;</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="mini-cart-right">' +
                            '<button type="button" class="mini-cart-remove" aria-label="Xóa">&times;</button>' +
                            '<p class="mini-cart-line-price">' + formatVnd(productPrice * quantity) + '</p>' +
                        '</div>';
                    miniCartList.insertBefore(item, miniCartList.firstChild);
                }

                var totalEl = document.getElementById('miniCartTotal');
                if (totalEl) {
                    var currTotal = parseInt((totalEl.textContent || '0').replace(/[^\d]/g, ''), 10) || 0;
                    totalEl.textContent = formatVnd(currTotal + productPrice * quantity);
                }

                return finalQty;
            }

            if (addCartForm) {
                addCartForm.addEventListener('submit', async function(e) {
                    var submitter = e.submitter;
                    if (!submitter || submitter.id === 'buyNowBtn') {
                        return;
                    }

                    e.preventDefault();

                    if (sizeButtons.length && sizeInput && !sizeInput.value) {
                        window.alert('Vui lòng chọn kích thước trước khi thêm vào giỏ.');
                        return;
                    }

                    var formData = new FormData(addCartForm);
                    formData.set('themgiohang', '1');
                    var quantity = parseInt((formData.get('quantity') || '1').toString(), 10) || 1;

                    submitter.disabled = true;
                    var originalText = submitter.textContent;
                    submitter.textContent = 'Đang thêm...';

                    try {
                        var response = await fetch('/onlinestore/public/cart_add.php', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });
                        var text = (await response.text()).trim();

                        if (text === 'success') {
                            var finalQty = updateMiniCartFromDetail(quantity);

                            if (successModalEl && successModal) {
                                var nameEl = successModalEl.querySelector('#detailAddCartSuccessName');
                                var priceEl = successModalEl.querySelector('#detailAddCartSuccessPrice');
                                var imageEl = successModalEl.querySelector('#detailAddCartSuccessImage');
                                var qtyEl = successModalEl.querySelector('#detailAddCartSuccessQty');

                                if (nameEl) nameEl.textContent = document.querySelector('.title_product').textContent.trim();
                                if (priceEl) priceEl.textContent = document.querySelector('.price_product').textContent.trim();
                                if (imageEl) imageEl.src = document.querySelector('.img_product').getAttribute('src');
                                if (qtyEl) qtyEl.textContent = String(finalQty);
                                successModal.show();
                            }
                        } else {
                            window.alert('Không thể thêm vào giỏ. Vui lòng thử lại.');
                        }
                    } catch (err) {
                        window.alert('Không thể thêm vào giỏ. Vui lòng thử lại.');
                    } finally {
                        submitter.disabled = false;
                        submitter.textContent = originalText;
                    }
                });
            }

            var relatedViewport = document.getElementById('relatedSliderViewport');
            var relatedTrack = document.getElementById('relatedProductsTrack');
            var relatedPrevBtn = document.getElementById('relatedPrevBtn');
            var relatedNextBtn = document.getElementById('relatedNextBtn');

            function getRelatedStep() {
                if (!relatedTrack) {
                    return 0;
                }
                var firstItem = relatedTrack.querySelector('.related-slide-item');
                if (!firstItem) {
                    return 0;
                }
                return firstItem.getBoundingClientRect().width + 16;
            }

            function syncRelatedButtons() {
                if (!relatedViewport || !relatedPrevBtn || !relatedNextBtn) {
                    return;
                }
                var maxScroll = relatedViewport.scrollWidth - relatedViewport.clientWidth;
                relatedPrevBtn.disabled = relatedViewport.scrollLeft <= 4;
                relatedNextBtn.disabled = relatedViewport.scrollLeft >= maxScroll - 4;
            }

            if (relatedViewport && relatedPrevBtn && relatedNextBtn) {
                relatedPrevBtn.addEventListener('click', function() {
                    relatedViewport.scrollBy({ left: -getRelatedStep() * 2, behavior: 'smooth' });
                });

                relatedNextBtn.addEventListener('click', function() {
                    relatedViewport.scrollBy({ left: getRelatedStep() * 2, behavior: 'smooth' });
                });

                relatedViewport.addEventListener('scroll', syncRelatedButtons, { passive: true });
                window.addEventListener('resize', syncRelatedButtons);
                syncRelatedButtons();
            }
        })();
    </script>

</body>

</html>

