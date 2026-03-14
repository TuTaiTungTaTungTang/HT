<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT27502\Project\Product;
use CT27502\Project\Category;

$product = new Product($PDO);
$allProducts = $product->all();

$category = new Category($PDO);
$categories = $category->all();
$collectionTabCategories = array_slice($categories, 0, 6);

$bstCollectionDefs = [
    ['code' => 'clair-de-spring', 'label' => 'CLAIR DE SPRING', 'path' => '/onlinestore/public/clair_de_spring.php'],
    ['code' => 'xuan-nhien',      'label' => 'XUÂN NHIÊN',       'path' => '/onlinestore/public/xuan_nhien.php'],
    ['code' => 'night-out',       'label' => 'NIGHT OUT',        'path' => '/onlinestore/public/night_out.php'],
    ['code' => 'city-hours',      'label' => 'CITY HOURS',       'path' => '/onlinestore/public/city_hours.php'],
    ['code' => 'classmate-notes', 'label' => 'CLASSMATE NOTES',  'path' => '/onlinestore/public/classmate_notes.php'],
    ['code' => 'after-class',     'label' => 'AFTER CLASS',      'path' => '/onlinestore/public/after_class.php'],
];
$bstTabProducts = [];
foreach ($bstCollectionDefs as $bstDef) {
    $bstTabProducts[$bstDef['code']] = $product->getByCollection($bstDef['code'], 4);
}


include_once __DIR__ .'/../src/partials/header.php'

?>
<body>
    
    <?php include_once __DIR__ .'/../src/partials/navbar.php'?>

    <div class="slider container-fluid px-0 pb-0">
        <div id="carouselExampleInterval" class="carousel slide hero-card" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="3200">
                    <img src="./images/banner1.jpg" class="d-block w-100 img-carousel" alt="Summer collection">
                </div>
                <div class="carousel-item" data-bs-interval="3200">
                    <img src="./images/banner2.png" class="d-block w-100 img-carousel" alt="New arrivals">
                </div>
                <div class="carousel-item" data-bs-interval="3200">
                    <img src="./images/banner3.png" class="d-block w-100 img-carousel" alt="Daily outfit">
                </div>
            </div>

            <div class="hero-content">
                <p>New Drop 2026</p>
                <h1>Soft Tailoring<br>For Your Day</h1>
                <a href="product.php" class="hero-btn">Kham pha ngay</a>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="main-content">
        <div class="container my-4">
            <section class="container-fluid category-hot">
                <div class="section-head">
                    <h2 class="title">KHUYẾN MÃI TUẦN NÀY</h2>
                    <p class="section-divider">___ /// ___</p>
                </div>

                <div class="flash-countdown">
                    Kết thúc trong:
                    <span class="countdown-pill">00</span>
                    <span class="countdown-pill">00</span>
                    <span class="countdown-pill">00</span>
                    <span class="countdown-pill">00</span>
                </div>

                <div class="row hot-product-list home-product-grid">
                    <?php
                    $promoProducts = array_slice($allProducts, 0, 4);
                    foreach ($promoProducts as $promoProduct) :
                    ?>
                    <div
                        class="col-xl-2 col-lg-3 col-md-4 col-6 home-product-card"
                        data-product-id="<?= $promoProduct->getID() ?>"
                        data-product-name="<?= html_escape($promoProduct->pd_name) ?>"
                        data-product-price="<?= number_format(html_escape($promoProduct->pd_price)) . '₫' ?>"
                        data-product-image="<?= './uploads/' . html_escape($promoProduct->pd_image) ?>"
                        data-product-link="detail_product.php?id=<?= $promoProduct->getID() ?>"
                    >
                        <div class="home-product-media">
                            <button type="button" class="favorite-btn" aria-label="Thêm vào yêu thích">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <a href="detail_product.php?id=<?= $promoProduct->getID() ?>" class="product_a">
                                <img src="<?= './uploads/' . html_escape($promoProduct->pd_image) ?>" class="home-product-image" alt="...">
                            </a>
                            <div class="home-hover-actions">
                                <button type="button" class="home-action-btn quick-add-btn">Thêm vào giỏ</button>
                                <button
                                    type="button"
                                    class="home-action-btn quick-view-trigger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#homeQuickViewModal"
                                    data-id="<?= $promoProduct->getID() ?>"
                                    data-name="<?= html_escape($promoProduct->pd_name) ?>"
                                    data-price="<?= number_format(html_escape($promoProduct->pd_price)) . '₫' ?>"
                                    data-image="<?= './uploads/' . html_escape($promoProduct->pd_image) ?>"
                                    data-sizes="<?= html_escape($promoProduct->pd_sizes ?? '') ?>"
                                    data-link="detail_product.php?id=<?= $promoProduct->getID() ?>"
                                >Xem nhanh</button>
                            </div>
                        </div>
                        <a href="detail_product.php?id=<?= $promoProduct->getID() ?>" class="product_a">
                            <div class="card-title-wrap">
                                <h6 class="home-product-title"><?= html_escape($promoProduct->pd_name) ?></h6>
                            </div>
                        </a>
                        <p class="home-product-price"><?= number_format(html_escape($promoProduct->pd_price)) . '₫'?></p>
                    </div>
                    <?php endforeach ?>
                </div>
            </section>

            <section class="container-fluid home-banner-grid home-banner-pair">
                <div class="row g-0">
                    <div class="col-md-6">
                        <img src="./images/home_1.png" alt="Home banner 1">
                    </div>
                    <div class="col-md-6">
                        <img src="./images/home_2.png" alt="Home banner 2">
                    </div>
                </div>
            </section>

            <section class="container-fluid category-hot">
                <div class="section-head">
                    <h2 class="title">SẢN PHẨM BÁN CHẠY</h2>
                    <p class="section-divider">___ /// ___</p>
                    <p class="section-sub">Top trending tuần này</p>
                </div>
                <div class="row hot-product-list home-product-grid">
                    <?php
                    $bestSellerProducts = array_slice($allProducts, 4, 4);
                    foreach ($bestSellerProducts as $bestProduct) :
                    ?>
                    <div
                        class="col-xl-2 col-lg-3 col-md-4 col-6 home-product-card"
                        data-product-id="<?= $bestProduct->getID() ?>"
                        data-product-name="<?= html_escape($bestProduct->pd_name) ?>"
                        data-product-price="<?= number_format(html_escape($bestProduct->pd_price)) . '₫' ?>"
                        data-product-image="<?= './uploads/' . html_escape($bestProduct->pd_image) ?>"
                        data-product-link="detail_product.php?id=<?= $bestProduct->getID() ?>"
                    >
                        <div class="home-product-media">
                            <button type="button" class="favorite-btn" aria-label="Thêm vào yêu thích">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <a href="detail_product.php?id=<?= $bestProduct->getID() ?>" class="product_a">
                                <img src="<?= './uploads/' . html_escape($bestProduct->pd_image) ?>" class="home-product-image" alt="...">
                            </a>
                            <div class="home-hover-actions">
                                <button type="button" class="home-action-btn quick-add-btn">Thêm vào giỏ</button>
                                <button
                                    type="button"
                                    class="home-action-btn quick-view-trigger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#homeQuickViewModal"
                                    data-id="<?= $bestProduct->getID() ?>"
                                    data-name="<?= html_escape($bestProduct->pd_name) ?>"
                                    data-price="<?= number_format(html_escape($bestProduct->pd_price)) . '₫' ?>"
                                    data-image="<?= './uploads/' . html_escape($bestProduct->pd_image) ?>"
                                    data-sizes="<?= html_escape($bestProduct->pd_sizes ?? '') ?>"
                                    data-link="detail_product.php?id=<?= $bestProduct->getID() ?>"
                                >Xem nhanh</button>
                            </div>
                        </div>
                        <a href="detail_product.php?id=<?= $bestProduct->getID() ?>" class="product_a">
                            <div class="card-title-wrap">
                                <h6 class="home-product-title"><?= html_escape($bestProduct->pd_name) ?></h6>
                            </div>
                        </a>
                        <p class="home-product-price"><?= number_format(html_escape($bestProduct->pd_price)) . '₫'?></p>
                    </div>
                    <?php endforeach ?>
                </div>
            </section>

            <section class="container-fluid bst-middle-strip">
                <div class="row g-0">
                    <div class="col-6 col-lg-3"><img src="./images/bst1.png" alt="Bo suu tap 1"></div>
                    <div class="col-6 col-lg-3"><img src="./images/bst2.png" alt="Bo suu tap 2"></div>
                    <div class="col-6 col-lg-3"><img src="./images/bst3.png" alt="Bo suu tap 3"></div>
                    <div class="col-6 col-lg-3"><img src="./images/bst4.png" alt="Bo suu tap 4"></div>
                </div>
            </section>

            <section class="container-fluid category-hot" id="bo-suu-tap">
                <div class="section-head">
                    <h2 class="title">BỘ SƯU TẬP</h2>
                </div>

                <div class="collection-tabs">
                    <?php foreach ($bstCollectionDefs as $bstIdx => $bstDef) : ?>
                        <button type="button" class="tab-pill <?= $bstIdx === 0 ? 'active' : '' ?>" data-target="bst-panel-<?= html_escape($bstDef['code']) ?>"><?= html_escape($bstDef['label']) ?></button>
                    <?php endforeach ?>
                </div>

                <?php foreach ($bstCollectionDefs as $bstIdx => $bstDef) : ?>
                    <div class="collection-panel <?= $bstIdx === 0 ? 'active' : '' ?>" id="bst-panel-<?= html_escape($bstDef['code']) ?>">
                        <div class="row hot-product-list home-product-grid">
                            <?php foreach ($bstTabProducts[$bstDef['code']] as $hotProduct) : ?>
                            <div
                                class="col-xl-2 col-lg-3 col-md-4 col-6 home-product-card"
                                data-product-id="<?= $hotProduct->getID() ?>"
                                data-product-name="<?= html_escape($hotProduct->pd_name) ?>"
                                data-product-price="<?= number_format(html_escape($hotProduct->pd_price)) . '₫' ?>"
                                data-product-image="<?= './uploads/' . html_escape($hotProduct->pd_image) ?>"
                                data-product-link="detail_product.php?id=<?= $hotProduct->getID() ?>"
                            >
                                <div class="home-product-media">
                                    <button type="button" class="favorite-btn" aria-label="Thêm vào yêu thích">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                    <a href="detail_product.php?id=<?= $hotProduct->getID() ?>" class="product_a">
                                        <img src="<?= './uploads/' . html_escape($hotProduct->pd_image) ?>" class="home-product-image" alt="<?= html_escape($hotProduct->pd_name) ?>">
                                    </a>
                                    <div class="home-hover-actions">
                                        <button type="button" class="home-action-btn quick-add-btn">Thêm vào giỏ</button>
                                        <button
                                            type="button"
                                            class="home-action-btn quick-view-trigger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#homeQuickViewModal"
                                            data-id="<?= $hotProduct->getID() ?>"
                                            data-name="<?= html_escape($hotProduct->pd_name) ?>"
                                            data-price="<?= number_format(html_escape($hotProduct->pd_price)) . '₫' ?>"
                                            data-image="<?= './uploads/' . html_escape($hotProduct->pd_image) ?>"
                                            data-sizes="<?= html_escape($hotProduct->pd_sizes ?? '') ?>"
                                            data-link="detail_product.php?id=<?= $hotProduct->getID() ?>"
                                        >Xem nhanh</button>
                                    </div>
                                </div>
                                <a href="detail_product.php?id=<?= $hotProduct->getID() ?>" class="product_a">
                                    <div class="card-title-wrap">
                                        <h6 class="home-product-title"><?= html_escape($hotProduct->pd_name) ?></h6>
                                    </div>
                                </a>
                                <p class="home-product-price"><?= number_format(html_escape($hotProduct->pd_price)) . '₫'?></p>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="<?= html_escape($bstDef['path']) ?>">
                                <button class="btn-all_product">
                                    Xem toàn bộ <b><?= html_escape($bstDef['label']) ?></b>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            </section>

            <section class="container-fluid category-hot">
                <div class="section-head">
                    <h2 class="title">TIN TỨC MỚI</h2>
                    <p class="section-divider">___ /// ___</p>
                </div>
                <div class="row g-3 news-row">
                    <div class="col-lg-3 col-md-6">
                        <article class="news-card">
                            <img src="./images/new1.jpg" alt="Tin tuc 1">
                            <div class="news-content">
                                <h3>CHẬM LẠI THEO NHỊP THỞ ĐẦU THU</h3>
                                <span class="news-date">14/09/2025</span>
                                <p>Mùa thu luôn đến rất khẽ, không ồn ào mà dịu dàng như ánh nắng đầu ngày.</p>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <article class="news-card">
                            <img src="./images/new2.jpg" alt="Tin tuc 2">
                            <div class="news-content">
                                <h3>AFTER CLASS | TÌM KIẾM NGUỒN CẢM HỨNG</h3>
                                <span class="news-date">31/08/2025</span>
                                <p>Tựu trường không chỉ là lúc quay lại lớp học mà còn là khoảng thời gian rất nhiều cảm xúc.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="container-fluid category-hot insta-strip">
                <div class="section-head">
                    <h2 class="title">@ FOLLOW US ON INSTAGRAM</h2>
                </div>
                <div class="row g-0">
                    <div class="col-6 col-lg"><img src="./images/ins1.jpeg" alt="Instagram 1"></div>
                    <div class="col-6 col-lg"><img src="./images/ins2.jpeg" alt="Instagram 2"></div>
                    <div class="col-6 col-lg"><img src="./images/ins3.jpeg" alt="Instagram 3"></div>
                    <div class="col-6 col-lg"><img src="./images/ins4.jpeg" alt="Instagram 4"></div>
                    <div class="col-6 col-lg"><img src="./images/ins5.jpeg" alt="Instagram 5"></div>
                </div>
            </section>

        </div>
    </div>

    <div class="modal fade" id="homeQuickViewModal" tabindex="-1" aria-labelledby="homeQuickViewTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content quickview-modal-content">
                <div class="modal-body quickview-modal-body">
                    <button type="button" class="btn-close quickview-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row g-4 align-items-start quickview-layout">
                        <div class="col-lg-6">
                            <img id="quickViewImage" src="" alt="Quick view" class="quickview-image">
                        </div>
                        <div class="col-lg-6 quickview-info-col">
                            <h3 id="homeQuickViewTitle" class="quickview-title"></h3>
                            <p class="quickview-sku">SKU: <span id="quickViewSku">-</span> <span id="quickViewStatusText">Còn hàng</span></p>
                            <p id="quickViewPrice" class="quickview-price"></p>
                            <div class="quickview-size-wrap">
                                <p class="quickview-color">Kích thước: <span id="quickViewSelectedSize">-</span></p>
                                <div id="quickViewSizeOptions" class="quickview-size-options"></div>
                            </div>

                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user' && isset($_SESSION['id'])) : ?>
                                <form id="quickViewCartForm" method="post" action="cart_add.php">
                                    <input type="hidden" name="idsanpham" id="quickViewProductId" value="">
                                    <input type="hidden" name="iduser" value="<?= (int) $_SESSION['id'] ?>">
                                    <input type="hidden" name="pd_size" id="quickViewSizeInput" value="">

                                    <div class="quickview-qty-row">
                                        <button type="button" class="quickview-qty-btn" id="quickViewMinus" aria-label="Giảm">&#8722;</button>
                                        <input type="number" id="quickViewQty" class="quickview-qty-input" name="quantity" min="1" max="99" value="1" readonly>
                                        <button type="button" class="quickview-qty-btn" id="quickViewPlus" aria-label="Tăng">&#43;</button>
                                        <button type="submit" name="themgiohang" id="quickViewSubmit" class="quickview-buy-btn">Thêm vào giỏ</button>
                                    </div>
                                </form>
                            <?php else : ?>
                                <div class="quickview-qty-row">
                                    <button type="button" class="quickview-qty-btn" disabled>&#8722;</button>
                                    <input type="number" class="quickview-qty-input" value="1" readonly disabled>
                                    <button type="button" class="quickview-qty-btn" disabled>&#43;</button>
                                    <a href="/onlinestore/public/login.php" class="quickview-buy-btn is-link">Đăng nhập để mua</a>
                                </div>
                            <?php endif ?>

                            <a id="quickViewDetailLink" class="quickview-detail-link" href="#">Xem chi tiết »</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCartSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered add-cart-success-dialog">
            <div class="modal-content add-cart-success-content">
                <div class="modal-body add-cart-success-body">
                    <button type="button" class="btn-close add-cart-success-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="add-cart-success-check">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <p class="add-cart-success-title">Thêm vào giỏ thành công</p>
                    <div class="add-cart-success-product">
                        <span id="addCartSuccessQty" class="add-cart-success-qty">1</span>
                        <img id="addCartSuccessImage" src="" alt="Sản phẩm" class="add-cart-success-image">
                        <div>
                            <p id="addCartSuccessName" class="add-cart-success-name"></p>
                            <p id="addCartSuccessPrice" class="add-cart-success-price"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var modal = document.getElementById('homeQuickViewModal');
            var successModalEl = document.getElementById('addCartSuccessModal');
            var successModal = successModalEl && window.bootstrap ? new bootstrap.Modal(successModalEl) : null;
            var favoriteStorageKey = 'morning_favorites';
            var isUserLoggedIn = <?= (isset($_SESSION['role']) && $_SESSION['role'] === 'user' && isset($_SESSION['id'])) ? 'true' : 'false' ?>;
            var currentUserId = <?= isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0 ?>;

            function readFavorites() {
                try {
                    var raw = localStorage.getItem(favoriteStorageKey);
                    return raw ? JSON.parse(raw) : {};
                } catch (e) {
                    return {};
                }
            }

            function writeFavorites(data) {
                localStorage.setItem(favoriteStorageKey, JSON.stringify(data));
                window.dispatchEvent(new Event('favorites:changed'));
            }

            function setHeartVisual(button, active) {
                if (!button) {
                    return;
                }
                var icon = button.querySelector('i');
                button.classList.toggle('is-active', active);
                button.setAttribute('aria-pressed', active ? 'true' : 'false');
                if (icon) {
                    icon.className = active ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                }
            }

            function initFavorites() {
                var favorites = readFavorites();
                document.querySelectorAll('.home-product-card').forEach(function(card) {
                    var id = card.getAttribute('data-product-id');
                    var button = card.querySelector('.favorite-btn');
                    if (!id || !button) {
                        return;
                    }

                    setHeartVisual(button, Boolean(favorites[id]));
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        var currentFavorites = readFavorites();
                        if (currentFavorites[id]) {
                            delete currentFavorites[id];
                            writeFavorites(currentFavorites);
                            setHeartVisual(button, false);
                        } else {
                            currentFavorites[id] = {
                                id: id,
                                name: card.getAttribute('data-product-name') || '',
                                price: card.getAttribute('data-product-price') || '',
                                image: card.getAttribute('data-product-image') || '',
                                link: card.getAttribute('data-product-link') || '#'
                            };
                            writeFavorites(currentFavorites);
                            setHeartVisual(button, true);
                        }

                        var finalFavorites = readFavorites();
                        document.querySelectorAll('.home-product-card[data-product-id="' + id + '"] .favorite-btn').forEach(function(syncBtn) {
                            setHeartVisual(syncBtn, Boolean(finalFavorites[id]));
                        });
                    });
                });

            }

            function initCollectionTabs() {
                var tabButtons = document.querySelectorAll('.collection-tabs .tab-pill');
                var panels = document.querySelectorAll('.collection-panel');

                if (!tabButtons.length || !panels.length) {
                    return;
                }

                tabButtons.forEach(function(tabBtn) {
                    tabBtn.addEventListener('click', function() {
                        var targetId = tabBtn.getAttribute('data-target');
                        if (!targetId) {
                            return;
                        }

                        tabButtons.forEach(function(btn) {
                            btn.classList.remove('active');
                        });

                        panels.forEach(function(panel) {
                            panel.classList.remove('active');
                        });

                        tabBtn.classList.add('active');
                        var targetPanel = document.getElementById(targetId);
                        if (targetPanel) {
                            targetPanel.classList.add('active');
                        }
                    });
                });
            }

            async function quickAddToCart(productId, quantity) {
                var data = new URLSearchParams();
                data.set('themgiohang', '1');
                data.set('idsanpham', String(productId));
                data.set('iduser', String(currentUserId));
                data.set('quantity', String(quantity || 1));

                var response = await fetch('/onlinestore/public/cart_add.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: data.toString()
                });

                var text = await response.text();
                return text.trim() === 'success';
            }

            function showAddCartSuccess(payload) {
                if (!successModalEl || !successModal) {
                    return;
                }

                var qtyEl = successModalEl.querySelector('#addCartSuccessQty');
                var imgEl = successModalEl.querySelector('#addCartSuccessImage');
                var nameEl = successModalEl.querySelector('#addCartSuccessName');
                var priceEl = successModalEl.querySelector('#addCartSuccessPrice');

                if (qtyEl) qtyEl.textContent = String(payload.quantity || 1);
                if (imgEl) imgEl.src = payload.image || '';
                if (nameEl) nameEl.textContent = payload.name || '';
                if (priceEl) priceEl.textContent = payload.priceText || '';

                successModal.show();
            }

            function updateMiniCart(payload) {
                var badge = document.querySelector('.cart-count-badge');
                if (badge) {
                    var curr = parseInt(badge.textContent || '0', 10);
                    badge.textContent = String(curr + (payload.quantity || 1));
                }

                var miniCartList = document.getElementById('miniCartList');
                if (!miniCartList) {
                    return payload.quantity || 1;
                }

                var id = payload.id || '';
                var name = payload.name || '';
                var image = payload.image || '';
                var price = parseInt(String(payload.price || 0), 10);
                var quantity = payload.quantity || 1;
                var finalQty = quantity;

                var existed = miniCartList.querySelector('.mini-cart-item[data-pd-id="' + id + '"]');
                if (existed) {
                    var qtyInput = existed.querySelector('.mini-cart-qty');
                    var linePriceEl = existed.querySelector('.mini-cart-line-price');
                    if (qtyInput) {
                        finalQty = parseInt(qtyInput.value || '1', 10) + quantity;
                        qtyInput.value = String(finalQty);
                    }
                    if (linePriceEl) {
                        linePriceEl.textContent = (price * finalQty).toLocaleString('vi-VN') + '₫';
                    }
                } else {
                    var empty = miniCartList.querySelector('#miniCartEmpty');
                    if (empty) {
                        empty.remove();
                    }

                    var item = document.createElement('div');
                    item.className = 'mini-cart-item';
                    item.setAttribute('data-pd-id', id || '');
                    item.setAttribute('data-price', String(price));
                    item.innerHTML = '' +
                        '<img src="' + image + '" alt="' + name.replace(/"/g, '&quot;') + '" class="mini-cart-thumb">' +
                        '<div class="mini-cart-info">' +
                            '<p class="mini-cart-name">' + name + '</p>' +
                            '<div class="mini-cart-qty-wrap">' +
                                '<button type="button" class="mini-cart-qty-btn decrement">&#8722;</button>' +
                                '<input type="number" class="mini-cart-qty" value="' + quantity + '" min="1" max="99" readonly>' +
                                '<button type="button" class="mini-cart-qty-btn increment">&#43;</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="mini-cart-right">' +
                            '<button type="button" class="mini-cart-remove" aria-label="Xóa">&times;</button>' +
                            '<p class="mini-cart-line-price">' + (price * quantity).toLocaleString('vi-VN') + '₫</p>' +
                        '</div>';
                    miniCartList.insertBefore(item, miniCartList.firstChild);
                }

                var totalEl = document.getElementById('miniCartTotal');
                if (totalEl) {
                    var currTotal = parseInt((totalEl.textContent || '0').replace(/[^\d]/g, ''), 10);
                    totalEl.textContent = (currTotal + price * quantity).toLocaleString('vi-VN') + '₫';
                }

                return finalQty;
            }

            function initQuickAddButtons() {
                document.querySelectorAll('.quick-add-btn').forEach(function(button) {
                    button.addEventListener('click', async function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (!isUserLoggedIn) {
                            window.location.href = '/onlinestore/public/login.php';
                            return;
                        }

                        var card = button.closest('.home-product-card');
                        if (!card) {
                            return;
                        }

                        var productId = card.getAttribute('data-product-id');
                        if (!productId) {
                            return;
                        }

                        button.disabled = true;
                        var oldText = button.textContent;
                        button.textContent = 'Đang thêm...';

                        try {
                            var ok = await quickAddToCart(productId, 1);
                            if (ok) {
                                var rawPrice = (card.getAttribute('data-product-price') || '').replace(/[^\d]/g, '');
                                var payload = {
                                    id: productId,
                                    name: card.getAttribute('data-product-name') || '',
                                    image: card.getAttribute('data-product-image') || '',
                                    price: parseInt(rawPrice || '0', 10),
                                    priceText: card.getAttribute('data-product-price') || '',
                                    quantity: 1
                                };
                                var finalQty = updateMiniCart(payload);
                                showAddCartSuccess({
                                    name: payload.name,
                                    image: payload.image,
                                    priceText: payload.priceText,
                                    quantity: finalQty
                                });
                                button.textContent = 'Đã thêm';
                                setTimeout(function() {
                                    button.textContent = oldText;
                                }, 900);
                            } else {
                                button.textContent = 'Lỗi thêm giỏ';
                                setTimeout(function() {
                                    button.textContent = oldText;
                                }, 900);
                            }
                        } catch (err) {
                            button.textContent = 'Lỗi thêm giỏ';
                            setTimeout(function() {
                                button.textContent = oldText;
                            }, 900);
                        } finally {
                            button.disabled = false;
                        }
                    });
                });
            }

            if (!modal) {
                initFavorites();
                initCollectionTabs();
                return;
            }

            modal.addEventListener('show.bs.modal', function(event) {
                var trigger = event.relatedTarget;
                if (!trigger) {
                    return;
                }

                var productId = trigger.getAttribute('data-id') || '';
                var name = trigger.getAttribute('data-name') || '';
                var price = trigger.getAttribute('data-price') || '';
                var image = trigger.getAttribute('data-image') || '';
                var sizes = trigger.getAttribute('data-sizes') || '';
                var link = trigger.getAttribute('data-link') || '#';

                var titleEl = modal.querySelector('#homeQuickViewTitle');
                var priceEl = modal.querySelector('#quickViewPrice');
                var imageEl = modal.querySelector('#quickViewImage');
                var linkEl = modal.querySelector('#quickViewDetailLink');
                var skuEl = modal.querySelector('#quickViewSku');
                var productIdEl = modal.querySelector('#quickViewProductId');
                var sizeInputEl = modal.querySelector('#quickViewSizeInput');
                var selectedSizeEl = modal.querySelector('#quickViewSelectedSize');
                var sizeOptionsEl = modal.querySelector('#quickViewSizeOptions');
                var qtyEl = modal.querySelector('#quickViewQty');

                if (titleEl) titleEl.textContent = name;
                if (priceEl) priceEl.textContent = price;
                if (imageEl) imageEl.src = image;
                if (linkEl) linkEl.href = link;
                if (skuEl) skuEl.textContent = 'SP' + productId;
                if (productIdEl) productIdEl.value = productId;
                if (qtyEl) qtyEl.value = 1;

                if (sizeOptionsEl) {
                    sizeOptionsEl.innerHTML = '';
                    var parsedSizes = sizes.split(',').map(function(s) {
                        return s.trim();
                    }).filter(Boolean);

                    if (!parsedSizes.length) {
                        parsedSizes = ['Freezie'];
                    }

                    parsedSizes.forEach(function(size, index) {
                        var btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'quickview-size-btn' + (index === 0 ? ' active' : '');
                        btn.textContent = size;
                        btn.setAttribute('data-size', size);
                        sizeOptionsEl.appendChild(btn);
                    });

                    var firstSize = parsedSizes[0] || '';
                    if (sizeInputEl) sizeInputEl.value = firstSize;
                    if (selectedSizeEl) selectedSizeEl.textContent = firstSize || '-';
                }
            });

            modal.addEventListener('click', function(event) {
                var target = event.target;
                var sizeOptionsEl = modal.querySelector('#quickViewSizeOptions');
                var sizeInputEl = modal.querySelector('#quickViewSizeInput');
                var selectedSizeEl = modal.querySelector('#quickViewSelectedSize');
                var qtyEl = modal.querySelector('#quickViewQty');

                if (target && target.classList.contains('quickview-size-btn')) {
                    var wasActive = target.classList.contains('active');
                    modal.querySelectorAll('.quickview-size-btn').forEach(function(btn) {
                        btn.classList.remove('active');
                    });

                    if (!wasActive) {
                        target.classList.add('active');
                        if (sizeInputEl) sizeInputEl.value = target.getAttribute('data-size') || '';
                        if (selectedSizeEl) selectedSizeEl.textContent = target.getAttribute('data-size') || '-';
                    } else {
                        if (sizeInputEl) sizeInputEl.value = '';
                        if (selectedSizeEl) selectedSizeEl.textContent = '-';
                    }
                    return;
                }

                if (target && target.id === 'quickViewPlus' && qtyEl) {
                    var current = parseInt(qtyEl.value || '1', 10);
                    if (current < 99) qtyEl.value = current + 1;
                    return;
                }

                if (target && target.id === 'quickViewMinus' && qtyEl) {
                    var current = parseInt(qtyEl.value || '1', 10);
                    if (current > 1) qtyEl.value = current - 1;
                    return;
                }
            });

            var quickViewForm = modal.querySelector('#quickViewCartForm');
            if (quickViewForm) {
                quickViewForm.addEventListener('submit', async function(e) {
                    var sizeInputEl = modal.querySelector('#quickViewSizeInput');
                    if (sizeInputEl && sizeInputEl.value === '') {
                        e.preventDefault();
                        window.alert('Vui lòng chọn kích thước trước khi thêm vào giỏ.');
                        return;
                    }

                    e.preventDefault();
                    if (!isUserLoggedIn) {
                        window.location.href = '/onlinestore/public/login.php';
                        return;
                    }

                    var productIdEl = modal.querySelector('#quickViewProductId');
                    var nameEl = modal.querySelector('#homeQuickViewTitle');
                    var imageEl = modal.querySelector('#quickViewImage');
                    var priceEl = modal.querySelector('#quickViewPrice');
                    var qtyEl = modal.querySelector('#quickViewQty');

                    var productId = productIdEl ? productIdEl.value : '';
                    var qty = qtyEl ? parseInt(qtyEl.value || '1', 10) : 1;
                    if (!productId) {
                        return;
                    }

                    var submitBtn = quickViewForm.querySelector('#quickViewSubmit');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                    }

                    try {
                        var ok = await quickAddToCart(productId, qty);
                        if (ok) {
                            var priceNum = parseInt((priceEl ? priceEl.textContent : '0').replace(/[^\d]/g, ''), 10) || 0;
                            var finalQty = updateMiniCart({
                                id: productId,
                                name: nameEl ? nameEl.textContent : '',
                                image: imageEl ? imageEl.src : '',
                                price: priceNum,
                                priceText: priceEl ? priceEl.textContent : '',
                                quantity: qty
                            });

                            showAddCartSuccess({
                                name: nameEl ? nameEl.textContent : '',
                                image: imageEl ? imageEl.src : '',
                                priceText: priceEl ? priceEl.textContent : '',
                                quantity: finalQty
                            });

                            var quickViewInstance = bootstrap.Modal.getInstance(modal);
                            if (quickViewInstance) {
                                quickViewInstance.hide();
                            }
                        } else {
                            window.alert('Không thể thêm vào giỏ. Vui lòng thử lại.');
                        }
                    } catch (err) {
                        window.alert('Không thể thêm vào giỏ. Vui lòng thử lại.');
                    } finally {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                        }
                    }
                });
            }

            initFavorites();
            initCollectionTabs();
            initQuickAddButtons();
        })();
    </script>

    <?php include_once __DIR__ .'/../src/partials/footer.php'?>
    
</body>

</html>

