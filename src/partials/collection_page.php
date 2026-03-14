<?php
require_once __DIR__ . '/../bootstrap.php';

use CT27502\Project\Paginator;
use CT27502\Project\Product;

$collectionDefinitions = require __DIR__ . '/../collection_definitions.php';
$collectionSlug = isset($collectionSlug) ? (string) $collectionSlug : 'tat-ca-san-pham';
$currentCollection = $collectionDefinitions[$collectionSlug] ?? $collectionDefinitions['tat-ca-san-pham'];
$currentPagePath = $currentCollection['path'];
$currentPageFile = basename($currentPagePath);

$productModel = new Product($PDO);

$limit = (isset($_GET['limit']) && is_numeric($_GET['limit'])) ? (int) $_GET['limit'] : 30;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int) $_GET['page'] : 1;
$allowedSort = ['newest', 'name_asc', 'name_desc', 'price_asc', 'price_desc'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowedSort, true)
    ? $_GET['sort']
    : ($currentCollection['defaultSort'] ?? 'newest');

$priceRangeMap = [
    'under_200' => [null, 200000],
    '200_300' => [200000, 300000],
    '300_350' => [300000, 350000],
    '350_400' => [350000, 400000],
    'over_400' => [400000, null],
];

$priceKey = (isset($_GET['price']) && isset($priceRangeMap[$_GET['price']])) ? $_GET['price'] : '';
$priceMin = $priceKey !== '' ? $priceRangeMap[$priceKey][0] : null;
$priceMax = $priceKey !== '' ? $priceRangeMap[$priceKey][1] : null;

$selectedCategory = $currentCollection['categoryId'] ?? -1;
$keywordTerms = $currentCollection['keywords'] ?? [];
$isNewOnly = !empty($currentCollection['isNew']);
$sizeOptions = ['XS', 'M', 'L', 'Freezie'];
$pageTitle = $currentCollection['title'];

$totalRecords = $productModel->count($selectedCategory, $priceMin, $priceMax, $keywordTerms, $isNewOnly);
$paginator = new Paginator(
    totalRecords: $totalRecords,
    recordsPerPage: $limit,
    currentPage: $page
);

$products = $productModel->paginate(
    $paginator->recordOffset,
    $paginator->recordsPerPage,
    $selectedCategory,
    $sort,
    $priceMin,
    $priceMax,
    $keywordTerms,
    $isNewOnly
);
$pages = $paginator->getPages(length: 3);

$baseParams = ['sort' => $sort, 'limit' => $limit];
if ($priceKey !== '') {
    $baseParams['price'] = $priceKey;
}

$sidebarCollections = array_filter(
    $collectionDefinitions,
    static fn(array $definition): bool => !empty($definition['showInSidebar'])
);

include_once __DIR__ . '/header.php'
?>

<body>
    <?php include_once __DIR__ . '/navbar.php' ?>

    <div class="container catalog-page-v2">
        <div class="catalog-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chủ</a> / <?= html_escape($pageTitle) ?>
        </div>

        <?php if (!empty($currentCollection['banner'])) : ?>
            <section class="collection-hero <?= ($currentCollection['banner']['mode'] ?? '') === 'image-only' ? 'is-image-only' : '' ?>">
                <?php if (($currentCollection['banner']['mode'] ?? '') === 'image-only') : ?>
                    <img src="<?= html_escape($currentCollection['banner']['image'] ?? '') ?>" alt="<?= html_escape($pageTitle) ?>" class="collection-hero-image">
                <?php else : ?>
                    <div class="collection-hero-copy">
                        <p class="collection-hero-eyebrow"><?= html_escape($currentCollection['banner']['eyebrow'] ?? '') ?></p>
                        <h2 class="collection-hero-subtitle"><?= html_escape($currentCollection['banner']['subtitle'] ?? '') ?></h2>
                        <h1 class="collection-hero-title"><?= html_escape($currentCollection['banner']['title'] ?? $pageTitle) ?></h1>
                        <p class="collection-hero-description"><?= html_escape($currentCollection['banner']['description'] ?? '') ?></p>
                    </div>
                    <div class="collection-hero-media">
                        <img src="<?= html_escape($currentCollection['banner']['image'] ?? '') ?>" alt="<?= html_escape($pageTitle) ?>" class="collection-hero-image">
                    </div>
                <?php endif ?>
            </section>
        <?php endif ?>

        <div class="row g-4 catalog-layout">
            <div class="col-xl-3 col-lg-4">
                <aside class="catalog-sidebar">
                    <details class="catalog-filter-group" open>
                        <summary>
                            <h3>Danh mục sản phẩm</h3>
                            <span class="toggle-sign">-</span>
                        </summary>
                        <ul class="catalog-filter-list collection-list-scroll">
                            <?php foreach ($sidebarCollections as $sidebarSlug => $sidebarCollection) : ?>
                                <?php
                                $collectionCount = $productModel->count(
                                    $sidebarCollection['categoryId'] ?? -1,
                                    null,
                                    null,
                                    $sidebarCollection['keywords'] ?? [],
                                    !empty($sidebarCollection['isNew'])
                                );
                                $isActiveCollection = $sidebarSlug === $collectionSlug;
                                $collectionLink = $sidebarCollection['path'];
                                ?>
                                <li>
                                    <a class="filter-option collection-option-link <?= $isActiveCollection ? 'active' : '' ?>" href="<?= html_escape($collectionLink) ?>">
                                        <span class="left-part">
                                            <span class="collection-check <?= $isActiveCollection ? 'checked' : '' ?>" aria-hidden="true"></span>
                                            <span><?= html_escape($sidebarCollection['title']) ?></span>
                                        </span>
                                        <span class="count">(<?= $collectionCount ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </details>

                    <form method="get" action="<?= html_escape($currentPageFile) ?>" class="catalog-filter-form" id="catalogFilterForm">
                        <input type="hidden" name="sort" value="<?= html_escape($sort) ?>">
                        <input type="hidden" name="limit" value="<?= $limit ?>">

                        <details class="catalog-filter-group" open>
                            <summary>
                                <h4>Mức giá</h4>
                                <span class="toggle-sign">-</span>
                            </summary>
                            <ul class="catalog-filter-list compact">
                                <li>
                                    <label class="filter-option <?= $priceKey === 'under_200' ? 'active' : '' ?>">
                                        <span class="left-part">
                                            <input type="radio" name="price" value="under_200" <?= $priceKey === 'under_200' ? 'checked' : '' ?>>
                                            <span>Dưới 200.000đ</span>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="filter-option <?= $priceKey === '200_300' ? 'active' : '' ?>">
                                        <span class="left-part">
                                            <input type="radio" name="price" value="200_300" <?= $priceKey === '200_300' ? 'checked' : '' ?>>
                                            <span>200.000đ - 300.000đ</span>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="filter-option <?= $priceKey === '300_350' ? 'active' : '' ?>">
                                        <span class="left-part">
                                            <input type="radio" name="price" value="300_350" <?= $priceKey === '300_350' ? 'checked' : '' ?>>
                                            <span>300.000đ - 350.000đ</span>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="filter-option <?= $priceKey === '350_400' ? 'active' : '' ?>">
                                        <span class="left-part">
                                            <input type="radio" name="price" value="350_400" <?= $priceKey === '350_400' ? 'checked' : '' ?>>
                                            <span>350.000đ - 400.000đ</span>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="filter-option <?= $priceKey === 'over_400' ? 'active' : '' ?>">
                                        <span class="left-part">
                                            <input type="radio" name="price" value="over_400" <?= $priceKey === 'over_400' ? 'checked' : '' ?>>
                                            <span>Trên 400.000đ</span>
                                        </span>
                                    </label>
                                </li>
                            </ul>
                        </details>

                        <details class="catalog-filter-group" open>
                            <summary>
                                <h4>Kích thước</h4>
                                <span class="toggle-sign">-</span>
                            </summary>
                            <ul class="catalog-filter-list compact">
                                <?php foreach ($sizeOptions as $sizeLabel) : ?>
                                    <li>
                                        <label class="filter-option">
                                            <span class="left-part">
                                                <input type="checkbox" disabled>
                                                <span><?= $sizeLabel ?></span>
                                            </span>
                                        </label>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </details>
                    </form>
                </aside>
            </div>

            <div class="col-xl-9 col-lg-8">
                <div class="catalog-main-head">
                    <h1><?= html_escape($pageTitle) ?></h1>
                    <form class="catalog-sort-form" method="get" action="<?= html_escape($currentPageFile) ?>">
                        <?php if ($priceKey !== '') : ?>
                            <input type="hidden" name="price" value="<?= html_escape($priceKey) ?>">
                        <?php endif ?>
                        <input type="hidden" name="limit" value="<?= $limit ?>">
                        <label for="sort">Sắp xếp:</label>
                        <select id="sort" name="sort" onchange="this.form.submit()">
                            <option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Tên: A-Z</option>
                            <option value="name_desc" <?= $sort === 'name_desc' ? 'selected' : '' ?>>Tên: Z-A</option>
                            <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Giá: Thấp đến cao</option>
                            <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Giá: Cao đến thấp</option>
                            <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                        </select>
                    </form>
                </div>

                <?php if (empty($products)) : ?>
                    <p class="favorite-empty">Hiện chưa có sản phẩm cho mục này.</p>
                <?php else : ?>
                    <div class="row catalog-product-grid">
                        <?php foreach ($products as $product) : ?>
                            <div class="col-xl-3 col-md-4 col-6">
                                <article
                                    class="catalog-card"
                                    data-product-id="<?= $product->getID() ?>"
                                    data-product-name="<?= html_escape($product->pd_name) ?>"
                                    data-product-price="<?= number_format((float) $product->pd_price) ?>d"
                                    data-product-image="<?= './uploads/' . html_escape($product->pd_image) ?>"
                                    data-product-link="detail_product.php?id=<?= $product->getID() ?>"
                                >
                                    <a href="detail_product.php?id=<?= $product->getID() ?>" class="catalog-card-link">
                                        <div class="catalog-thumb-wrap">
                                            <img src="<?= './uploads/' . html_escape($product->pd_image) ?>" alt="<?= html_escape($product->pd_name) ?>">
                                            <button type="button" class="wishlist-btn" aria-label="Thêm vào yêu thích" aria-pressed="false">
                                                <i class="fa-regular fa-heart"></i>
                                            </button>
                                        </div>
                                        <h3 class="catalog-card-title"><?= html_escape($product->pd_name) ?></h3>
                                        <p class="catalog-card-price"><?= number_format((float) $product->pd_price) ?>d</p>
                                        <div class="catalog-color-dots" aria-hidden="true">
                                            <span></span><span></span><span></span><span></span>
                                        </div>
                                    </a>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>

                <nav class="d-flex justify-content-center mt-4">
                    <ul class="pagination">
                        <li class="page-item <?= $paginator->getPrevPage() ? '' : ' disabled' ?>">
                            <a role="button" href="<?= html_escape($currentPageFile) . '?' . http_build_query(array_merge($baseParams, ['page' => $paginator->getPrevPage()])) ?>" class="page-link">
                                <span>&laquo;</span>
                            </a>
                        </li>
                        <?php foreach ($pages as $pageNumber) : ?>
                            <li class="page-item <?= $paginator->currentPage === $pageNumber ? ' active' : '' ?>">
                                <a role="button" href="<?= html_escape($currentPageFile) . '?' . http_build_query(array_merge($baseParams, ['page' => $pageNumber])) ?>" class="page-link">
                                    <?= $pageNumber ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                        <li class="page-item <?= $paginator->getNextPage() ? '' : ' disabled' ?>">
                            <a role="button" href="<?= html_escape($currentPageFile) . '?' . http_build_query(array_merge($baseParams, ['page' => $paginator->getNextPage()])) ?>" class="page-link">
                                <span>&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/footer.php' ?>

    <script>
        (function() {
            var filterForm = document.getElementById('catalogFilterForm');
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
                window.dispatchEvent(new Event('favorites:changed'));
            }

            function setHeartVisual(button, active) {
                if (!button) {
                    return;
                }
                button.classList.toggle('is-active', active);
                button.setAttribute('aria-pressed', active ? 'true' : 'false');
                var icon = button.querySelector('i');
                if (icon) {
                    icon.className = active ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                }
            }

            function initWishlistButtons() {
                var favorites = readFavorites();
                document.querySelectorAll('.catalog-card').forEach(function(card) {
                    var id = card.getAttribute('data-product-id');
                    var button = card.querySelector('.wishlist-btn');
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
                        } else {
                            currentFavorites[id] = {
                                id: id,
                                name: card.getAttribute('data-product-name') || '',
                                price: card.getAttribute('data-product-price') || '',
                                image: card.getAttribute('data-product-image') || '',
                                link: card.getAttribute('data-product-link') || '#'
                            };
                        }

                        writeFavorites(currentFavorites);
                        setHeartVisual(button, Boolean(currentFavorites[id]));
                    });
                });
            }

            if (!filterForm) {
                initWishlistButtons();
                return;
            }

            filterForm.querySelectorAll('input[type="radio"]').forEach(function(radio) {
                radio.addEventListener('mousedown', function() {
                    radio.dataset.wasChecked = radio.checked ? 'true' : 'false';
                });

                radio.addEventListener('click', function(e) {
                    if (radio.dataset.wasChecked === 'true') {
                        e.preventDefault();
                        radio.checked = false;
                        filterForm.submit();
                    }
                });
            });

            filterForm.addEventListener('change', function() {
                filterForm.submit();
            });

            initWishlistButtons();
        })();
    </script>
</body>

</html>
