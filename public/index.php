<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT27502\Project\Product;
use CT27502\Project\Category;

$product = new Product($PDO);
$allProducts = $product->all();

$category = new Category($PDO);
$categories = $category->all();
$collectionTabCategories = array_slice($categories, 0, 6);


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
                        class="col-xl-3 col-lg-3 col-md-4 col-6 home-product-card"
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
                                <button type="button" class="home-action-btn">Thêm vào giỏ</button>
                                <button
                                    type="button"
                                    class="home-action-btn quick-view-trigger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#homeQuickViewModal"
                                    data-name="<?= html_escape($promoProduct->pd_name) ?>"
                                    data-price="<?= number_format(html_escape($promoProduct->pd_price)) . '₫' ?>"
                                    data-image="<?= './uploads/' . html_escape($promoProduct->pd_image) ?>"
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
                        class="col-xl-3 col-lg-3 col-md-4 col-6 home-product-card"
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
                                <button type="button" class="home-action-btn">Thêm vào giỏ</button>
                                <button
                                    type="button"
                                    class="home-action-btn quick-view-trigger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#homeQuickViewModal"
                                    data-name="<?= html_escape($bestProduct->pd_name) ?>"
                                    data-price="<?= number_format(html_escape($bestProduct->pd_price)) . '₫' ?>"
                                    data-image="<?= './uploads/' . html_escape($bestProduct->pd_image) ?>"
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

            <section class="container-fluid category-hot" id="bo-suu-tap">
                <div class="section-head">
                    <h2 class="title">BỘ SƯU TẬP</h2>
                </div>

                <div class="collection-tabs">
                    <?php foreach ($collectionTabCategories as $tabIndex => $tabCategory) : ?>
                        <button type="button" class="tab-pill <?= $tabIndex === 0 ? 'active' : '' ?>" data-target="collection-panel-<?= html_escape($tabCategory->getID()) ?>"><?= html_escape($tabCategory->cat_name) ?></button>
                    <?php endforeach ?>
                </div>

                <?php foreach ($collectionTabCategories as $tabIndex => $tabCategory) : ?>
                    <?php
                    $tabProducts = $product->showHotProducts($tabCategory->getID());
                    if (empty($tabProducts)) {
                        $tabProducts = array_slice($allProducts, 0, 4);
                    }
                    $tabProducts = array_slice($tabProducts, 0, 4);
                    ?>
                    <div class="collection-panel <?= $tabIndex === 0 ? 'active' : '' ?>" id="collection-panel-<?= html_escape($tabCategory->getID()) ?>">
                        <div class="row hot-product-list home-product-grid">
                            <?php foreach ($tabProducts as $hotProduct) : ?>
                            <div
                                class="col-xl-3 col-lg-3 col-md-4 col-6 home-product-card"
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
                                        <img src="<?= './uploads/' . html_escape($hotProduct->pd_image) ?>" class="home-product-image" alt="...">
                                    </a>
                                    <div class="home-hover-actions">
                                        <button type="button" class="home-action-btn">Thêm vào giỏ</button>
                                        <button
                                            type="button"
                                            class="home-action-btn quick-view-trigger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#homeQuickViewModal"
                                            data-name="<?= html_escape($hotProduct->pd_name) ?>"
                                            data-price="<?= number_format(html_escape($hotProduct->pd_price)) . '₫' ?>"
                                            data-image="<?= './uploads/' . html_escape($hotProduct->pd_image) ?>"
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
                        <div class="text-center">
                            <a href="product.php?catID=<?=html_escape($tabCategory->getID())?>">
                                <button class="btn-all_product">
                                    Xem tất cả sản phẩm <b><?= html_escape($tabCategory->cat_name) ?></b>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            </section>

            <section class="container-fluid category-hot favorite-section" id="favoriteSection" hidden>
                <div class="section-head">
                    <h2 class="title">SẢN PHẨM YÊU THÍCH</h2>
                    <p class="section-divider">___ /// ___</p>
                </div>
                <div class="row hot-product-list home-product-grid" id="favoriteList"></div>
            </section>

            <section class="container-fluid category-hot">
                <div class="section-head">
                    <h2 class="title">TIN TỨC MỚI</h2>
                    <p class="section-divider">___ /// ___</p>
                </div>
                <div class="row g-3 news-row">
                    <div class="col-lg-3 col-md-6">
                        <article class="news-card">
                            <img src="./images/banner-3.jpg" alt="Tin tuc 1">
                            <div class="news-content">
                                <h3>CHẬM LẠI THEO NHỊP THỞ ĐẦU THU</h3>
                                <span class="news-date">14/09/2025</span>
                                <p>Mùa thu luôn đến rất khẽ, không ồn ào mà dịu dàng như ánh nắng đầu ngày.</p>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <article class="news-card">
                            <img src="./images/banner-4.jpg" alt="Tin tuc 2">
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
                    <div class="col-6 col-md"><img src="./images/banner-1.jpg" alt="Instagram 1"></div>
                    <div class="col-6 col-md"><img src="./images/banner-2.jpg" alt="Instagram 2"></div>
                    <div class="col-6 col-md"><img src="./images/banner-3.jpg" alt="Instagram 3"></div>
                    <div class="col-6 col-md"><img src="./images/banner-4.jpg" alt="Instagram 4"></div>
                    <div class="col-6 col-md"><img src="./images/banner-5.jpg" alt="Instagram 5"></div>
                </div>
            </section>

        </div>
    </div>

    <div class="modal fade" id="homeQuickViewModal" tabindex="-1" aria-labelledby="homeQuickViewTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content quickview-modal-content">
                <div class="modal-body quickview-modal-body">
                    <button type="button" class="btn-close quickview-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row g-4 align-items-start">
                        <div class="col-lg-5">
                            <img id="quickViewImage" src="" alt="Quick view" class="quickview-image">
                        </div>
                        <div class="col-lg-7">
                            <h3 id="homeQuickViewTitle" class="quickview-title"></h3>
                            <p class="quickview-sku">SKU: SBL25041323 Hết hàng</p>
                            <p id="quickViewPrice" class="quickview-price"></p>
                            <p class="quickview-color">Màu sắc: Trắng</p>
                            <a id="quickViewDetailLink" class="quickview-detail-link" href="#">Xem chi tiết »</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var modal = document.getElementById('homeQuickViewModal');
            var favoriteStorageKey = 'morning_favorites';

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

            function renderFavoriteList() {
                var section = document.getElementById('favoriteSection');
                var list = document.getElementById('favoriteList');
                if (!section || !list) {
                    return;
                }

                var favorites = readFavorites();
                var items = Object.values(favorites);
                if (!items.length) {
                    section.hidden = true;
                    list.innerHTML = '';
                    return;
                }

                section.hidden = false;
                list.innerHTML = items.map(function(item) {
                    return '\n<div class="col-xl-3 col-lg-3 col-md-4 col-6">'
                        + '<a href="' + item.link + '" class="product_a">'
                        + '<div class="home-product-media"><img src="' + item.image + '" class="home-product-image" alt="' + item.name + '"></div>'
                        + '<div class="card-title-wrap"><h6 class="home-product-title">' + item.name + '</h6></div>'
                        + '</a>'
                        + '<p class="home-product-price">' + item.price + '</p>'
                        + '</div>';
                }).join('');
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
                        renderFavoriteList();
                    });
                });

                renderFavoriteList();
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

                var name = trigger.getAttribute('data-name') || '';
                var price = trigger.getAttribute('data-price') || '';
                var image = trigger.getAttribute('data-image') || '';
                var link = trigger.getAttribute('data-link') || '#';

                var titleEl = modal.querySelector('#homeQuickViewTitle');
                var priceEl = modal.querySelector('#quickViewPrice');
                var imageEl = modal.querySelector('#quickViewImage');
                var linkEl = modal.querySelector('#quickViewDetailLink');

                if (titleEl) titleEl.textContent = name;
                if (priceEl) priceEl.textContent = price;
                if (imageEl) imageEl.src = image;
                if (linkEl) linkEl.href = link;
            });

            initFavorites();
            initCollectionTabs();
        })();
    </script>

    <?php include_once __DIR__ .'/../src/partials/footer.php'?>
    
</body>

</html>

