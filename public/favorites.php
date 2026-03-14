<?php
require_once __DIR__ . '/../src/bootstrap.php';

include_once __DIR__ . '/../src/partials/header.php'
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php' ?>

    <div class="container favorite-page-wrap">
        <div class="catalog-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chủ</a> / Sản phẩm yêu thích
        </div>

        <section class="container-fluid category-hot favorite-section favorite-page-section">
            <div class="section-head">
                <h1 class="title">SẢN PHẨM YÊU THÍCH</h1>
                <p class="section-divider">___ /// ___</p>
            </div>

            <p id="favoriteEmptyState" class="favorite-empty" hidden>
                Bạn chưa có sản phẩm yêu thích nào. Hãy bấm tim ở sản phẩm để lưu lại.
            </p>

            <div class="row hot-product-list home-product-grid" id="favoriteList"></div>
        </section>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php' ?>

    <script>
        (function() {
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

            function renderFavoriteList() {
                var list = document.getElementById('favoriteList');
                var emptyState = document.getElementById('favoriteEmptyState');
                if (!list || !emptyState) {
                    return;
                }

                var favorites = readFavorites();
                var items = Object.values(favorites);

                if (!items.length) {
                    list.innerHTML = '';
                    emptyState.hidden = false;
                    return;
                }

                emptyState.hidden = true;
                list.innerHTML = items.map(function(item) {
                    var link = item.link || '#';
                    var image = item.image || '';
                    var name = item.name || '';
                    var price = item.price || '';
                    var id = item.id || '';

                    return '<div class="col-xl-3 col-lg-3 col-md-4 col-6">'
                        + '<div class="favorite-card">'
                        + '<a href="' + link + '" class="product_a">'
                        + '<div class="home-product-media"><img src="' + image + '" class="home-product-image" alt="' + name + '"></div>'
                        + '<div class="card-title-wrap"><h6 class="home-product-title">' + name + '</h6></div>'
                        + '</a>'
                        + '<p class="home-product-price">' + price + '</p>'
                        + '<button type="button" class="favorite-remove-btn" data-remove-id="' + id + '">Xóa khỏi yêu thích</button>'
                        + '</div>'
                        + '</div>';
                }).join('');

                list.querySelectorAll('.favorite-remove-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var removeId = button.getAttribute('data-remove-id');
                        if (!removeId) {
                            return;
                        }
                        var current = readFavorites();
                        if (current[removeId]) {
                            delete current[removeId];
                            writeFavorites(current);
                            renderFavoriteList();
                        }
                    });
                });
            }

            renderFavoriteList();
            window.addEventListener('storage', function(event) {
                if (!event || event.key === favoriteStorageKey) {
                    renderFavoriteList();
                }
            });
        })();
    </script>
</body>

</html>
