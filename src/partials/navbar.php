<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isUserLoggedIn = isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'user';
$isAdminLoggedIn = isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$sessionAvatar = isset($_SESSION['avatar']) ? trim((string) $_SESSION['avatar']) : '';
$miniCartItems = [];
$miniCartTotalQuantity = 0;
$miniCartTotalAmount = 0;
$bstMenuItems = [
    ['label' => 'CLAIR DE SPRING', 'path' => '/onlinestore/public/clair_de_spring.php'],
    ['label' => 'XUÂN NHIÊN', 'path' => '/onlinestore/public/xuan_nhien.php'],
    ['label' => 'NIGHT OUT', 'path' => '/onlinestore/public/night_out.php'],
    ['label' => 'CITY HOURS', 'path' => '/onlinestore/public/city_hours.php'],
    ['label' => 'CLASSMATE NOTES', 'path' => '/onlinestore/public/classmate_notes.php'],
    ['label' => 'AFTER CLASS', 'path' => '/onlinestore/public/after_class.php'],
];

if ($isUserLoggedIn && isset($PDO)) {
    $miniCart = new CT27502\Project\Cart($PDO);
    $miniCart->fillUser($_SESSION);
    $miniCartItems = $miniCart->all();
    foreach ($miniCartItems as $miniCartItem) {
        $miniCartTotalQuantity += (int) $miniCartItem->pd_quantity;
        $miniCartTotalAmount += (int) $miniCartItem->total;
    }
}
?>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid header_wrap secodee-navbar">
            <a class="navbar-brand brand-word" href="/onlinestore/public/index.php" aria-label="Morning">
                <span class="logo-text">m</span>
                <span class="logo-fruit" aria-hidden="true"></span>
                <span class="logo-text">rning</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 secodee-menu">
                    <li class="nav-item mx-4 dropdown">
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a class="nav-link active" aria-current="page" href="category_list.php">QUẢN LÝ DANH MỤC</a>';
                        } else {
                            echo '<a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">THÔNG TIN CHUNG</a>
                                <ul class="dropdown-menu fs-5 text">
                                    <li><a class="dropdown-item" href="/onlinestore/public/gioi_thieu.php">Giới thiệu</a></li>
                                    <li><a class="dropdown-item" href="/onlinestore/public/su_kien.php">Sự kiện</a></li>
                                </ul>';
                        }
                        ?>
                    </li>

                    <li class="nav-item mx-4 dropdown">
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a class="nav-link active" aria-current="page" href="product_list.php">QUẢN LÝ MẶT HÀNG</a>';
                        } else {
                            $collectionDefinitions = require __DIR__ . '/../collection_definitions.php';
                            echo '<div class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">SẢN PHẨM</div>';
                            echo '<ul class="dropdown-menu fs-5 text">';
                            foreach ($collectionDefinitions as $collectionDefinition) {
                                if (empty($collectionDefinition['showInSidebar'])) {
                                    continue;
                                }
                                echo '<li><a class="dropdown-item" href="' . htmlspecialchars($collectionDefinition['path'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($collectionDefinition['title'], ENT_QUOTES, 'UTF-8') . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </li>

                    <li class="nav-item mx-4 dropdown">
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a class="nav-link active" aria-current="page" href="order_list.php">QUẢN LÝ ĐƠN HÀNG</a>';
                        } else {
                            echo '<a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">BST</a>';
                            echo '<ul class="dropdown-menu fs-5 text">';
                            foreach ($bstMenuItems as $bstMenuItem) {
                                echo '<li><a class="dropdown-item" href="' . htmlspecialchars($bstMenuItem['path'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($bstMenuItem['label'], ENT_QUOTES, 'UTF-8') . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                        <li class="nav-item mx-4">
                            <a class="nav-link active" aria-current="page" href="user_list.php">QUẢN LÝ USER</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
                        echo '<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="/onlinestore/public/flash_sale.php">ƯU ĐÃI</a></li>';
                        echo '<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="/onlinestore/public/tuyen_dung.php">TUYỂN DỤNG</a></li>';
                        echo '<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="/onlinestore/public/lien_he.php">LIÊN HỆ</a></li>';
                    }
                    ?>

                    <li class="nav-item mx-4 dropdown d-lg-none">
                        <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            TÀI KHOẢN
                        </a>
                        <ul class="dropdown-menu fs-5 text">
                            <?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                echo '<li><a class="dropdown-item" href="category_list.php">Quản trị</a></li>';
                                echo '<li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>';
                            } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
                                echo '<li><a class="dropdown-item" href="/onlinestore/public/profile.php">Thông tin người dùng</a></li>';
                                echo '<li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>';
                            } else {
                                echo '<li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>';
                                echo '<li><a class="dropdown-item" href="register.php">Đăng ký</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                </ul>

                <div class="nav-actions d-none d-lg-flex">
                    <button type="button" class="action-link search-toggle" aria-label="Tìm kiếm" aria-expanded="false" aria-controls="desktopSearchPanel">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <?php if ($isUserLoggedIn) : ?>
                        <a href="/onlinestore/public/profile.php" class="action-link user-profile-link" aria-label="Thông tin người dùng">
                            <?php if ($sessionAvatar !== '') : ?>
                                <img src="/onlinestore/public/avatar/<?= html_escape($sessionAvatar) ?>" alt="Avatar" class="nav-user-avatar">
                            <?php else : ?>
                                <i class="fa-regular fa-user"></i>
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <div class="dropdown nav-icon-dropdown">
                            <button class="action-link dropdown-toggle user-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Tài khoản">
                                <i class="fa-regular fa-user"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                    echo '<li><a class="dropdown-item" href="category_list.php">Quản trị</a></li>';
                                    echo '<li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>';
                                } else {
                                    echo '<li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>';
                                    echo '<li><a class="dropdown-item" href="register.php">Đăng ký</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (!$isAdminLoggedIn) : ?>
                        <a href="/onlinestore/public/favorites.php" class="action-link favorite-nav-link" aria-label="Yêu thích"><i class="fa-regular fa-heart"></i><span class="count-badge favorite-count-badge">0</span></a>
                        <?php if ($isUserLoggedIn) : ?>
                            <a href="cart.php?id=<?= (int) $_SESSION['id'] ?>" class="action-link js-cart-toggle" aria-label="Giỏ hàng">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="count-badge cart-count-badge"><?= $miniCartTotalQuantity ?></span>
                            </a>
                        <?php else : ?>
                            <a href="login.php" class="action-link" aria-label="Giỏ hàng">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="count-badge cart-count-badge">0</span>
                            </a>
                        <?php endif ?>
                    <?php endif; ?>
                </div>

                <form action="search.php" method="GET" class="d-flex mobile-search" role="search">
                    <input class="form-control me-2 search_input" name="keyword" type="search" required placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    <button class="btn px-0" type="submit"><i class="icon_search fa-solid fa-magnifying-glass"></i></button>
                </form>

                <div id="desktopSearchPanel" class="desktop-search-panel" aria-hidden="true">
                    <h3>TÌM KIẾM</h3>
                    <form action="search.php" method="GET" role="search">
                        <input class="form-control search_input" name="keyword" type="search" required placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>

<?php if ($isUserLoggedIn) : ?>
<div class="modal fade" id="miniCartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mini-cart-dialog">
        <div class="modal-content mini-cart-content" data-user-id="<?= (int) $_SESSION['id'] ?>">
            <div class="modal-body mini-cart-body">
                <button type="button" class="btn-close mini-cart-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="mini-cart-header">GIỎ HÀNG</div>

                <div class="mini-cart-list" id="miniCartList">
                    <?php if (empty($miniCartItems)) : ?>
                        <div class="mini-cart-empty" id="miniCartEmpty">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p>Hiện chưa có sản phẩm</p>
                        </div>
                    <?php else : ?>
                        <?php foreach ($miniCartItems as $miniCartItem) : ?>
                            <div class="mini-cart-item" data-pd-id="<?= (int) $miniCartItem->getIDPro() ?>" data-price="<?= (int) $miniCartItem->pd_price ?>">
                                <img src="/onlinestore/public/uploads/<?= html_escape($miniCartItem->pd_image) ?>" alt="<?= html_escape($miniCartItem->pd_name) ?>" class="mini-cart-thumb">
                                <div class="mini-cart-info">
                                    <p class="mini-cart-name"><?= html_escape($miniCartItem->pd_name) ?></p>
                                    <div class="mini-cart-qty-wrap">
                                        <button type="button" class="mini-cart-qty-btn decrement">&#8722;</button>
                                        <input type="number" class="mini-cart-qty" value="<?= (int) $miniCartItem->pd_quantity ?>" min="1" max="99" readonly>
                                        <button type="button" class="mini-cart-qty-btn increment">&#43;</button>
                                    </div>
                                </div>
                                <div class="mini-cart-right">
                                    <button type="button" class="mini-cart-remove" aria-label="Xóa">&times;</button>
                                    <p class="mini-cart-line-price"><?= number_format((int) $miniCartItem->total) ?>₫</p>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>

                <div class="mini-cart-total-row">
                    <span>TỔNG TIỀN:</span>
                    <strong id="miniCartTotal"><?= number_format($miniCartTotalAmount) ?>₫</strong>
                </div>

                <div class="mini-cart-actions">
                    <a href="cart.php?id=<?= (int) $_SESSION['id'] ?>" class="mini-cart-btn is-primary">XEM GIỎ HÀNG</a>
                    <a href="cart.php?id=<?= (int) $_SESSION['id'] ?>" class="mini-cart-btn">THANH TOÁN</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif ?>

<script>
    $(function() {
        var $toggle = $('.search-toggle');
        var $panel = $('#desktopSearchPanel');
        var favoriteStorageKey = 'morning_favorites';
        var cartModalEl = document.getElementById('miniCartModal');
        var cartModal = cartModalEl && window.bootstrap ? new bootstrap.Modal(cartModalEl) : null;

        function readFavorites() {
            try {
                var raw = localStorage.getItem(favoriteStorageKey);
                return raw ? JSON.parse(raw) : {};
            } catch (e) {
                return {};
            }
        }

        function syncFavoriteBadge() {
            var favorites = readFavorites();
            var count = Object.keys(favorites).length;
            $('.favorite-count-badge').text(count);
        }

        syncFavoriteBadge();
        window.addEventListener('favorites:changed', syncFavoriteBadge);
        window.addEventListener('storage', function(event) {
            if (!event || event.key === favoriteStorageKey) {
                syncFavoriteBadge();
            }
        });

        $toggle.on('click', function(e) {
            e.preventDefault();
            var opened = $panel.hasClass('active');
            $panel.toggleClass('active', !opened);
            $panel.attr('aria-hidden', opened ? 'true' : 'false');
            $toggle.attr('aria-expanded', opened ? 'false' : 'true');
            if (!opened) {
                $panel.find('input[name="keyword"]').trigger('focus');
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-toggle, #desktopSearchPanel').length) {
                $panel.removeClass('active').attr('aria-hidden', 'true');
                $toggle.attr('aria-expanded', 'false');
            }
        });

        function formatVnd(num) {
            return Number(num || 0).toLocaleString('vi-VN') + '₫';
        }

        function updateCartBadge(totalQty) {
            $('.cart-count-badge').text(totalQty);
        }

        function recalcMiniCart() {
            if (!cartModalEl) {
                return;
            }

            var items = cartModalEl.querySelectorAll('.mini-cart-item');
            var total = 0;
            var totalQty = 0;

            items.forEach(function(item) {
                var qtyInput = item.querySelector('.mini-cart-qty');
                var lineEl = item.querySelector('.mini-cart-line-price');
                var price = Number(item.getAttribute('data-price') || 0);
                var qty = Number(qtyInput ? qtyInput.value : 0);
                var line = price * qty;
                if (lineEl) {
                    lineEl.textContent = formatVnd(line);
                }
                total += line;
                totalQty += qty;
            });

            var totalEl = cartModalEl.querySelector('#miniCartTotal');
            if (totalEl) {
                totalEl.textContent = formatVnd(total);
            }
            updateCartBadge(totalQty);

            var listEl = cartModalEl.querySelector('#miniCartList');
            var emptyEl = cartModalEl.querySelector('#miniCartEmpty');
            if (items.length === 0 && listEl && !emptyEl) {
                var emptyHtml = document.createElement('div');
                emptyHtml.className = 'mini-cart-empty';
                emptyHtml.id = 'miniCartEmpty';
                emptyHtml.innerHTML = '<i class="fa-solid fa-cart-shopping"></i><p>Hiện chưa có sản phẩm</p>';
                listEl.appendChild(emptyHtml);
            }
            if (items.length > 0 && emptyEl) {
                emptyEl.remove();
            }
        }

        async function postForm(url, body) {
            var resp = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: body.toString()
            });
            return resp.text();
        }

        $('.js-cart-toggle').on('click', function(e) {
            if (!cartModal) {
                return;
            }
            e.preventDefault();
            cartModal.show();
        });

        if (cartModalEl) {
            cartModalEl.addEventListener('click', async function(e) {
                var target = e.target;
                var itemEl = target.closest('.mini-cart-item');
                if (!itemEl) {
                    return;
                }

                var userId = cartModalEl.querySelector('.mini-cart-content').getAttribute('data-user-id');
                var pdId = itemEl.getAttribute('data-pd-id');
                var qtyEl = itemEl.querySelector('.mini-cart-qty');
                if (!userId || !pdId || !qtyEl) {
                    return;
                }

                if (target.classList.contains('increment') || target.classList.contains('decrement')) {
                    var current = Number(qtyEl.value || 1);
                    var next = current;
                    if (target.classList.contains('increment') && current < 99) {
                        next = current + 1;
                    }
                    if (target.classList.contains('decrement') && current > 1) {
                        next = current - 1;
                    }

                    if (next !== current) {
                        var data = new URLSearchParams();
                        data.set('quantity', String(next));
                        data.set('id_user', String(userId));
                        data.set('id_pd', String(pdId));
                        var result = await postForm('/onlinestore/public/cart_update_quantity.php', data);
                        if (result.trim() === 'success') {
                            qtyEl.value = String(next);
                            recalcMiniCart();
                        }
                    }
                }

                if (target.classList.contains('mini-cart-remove')) {
                    var deleteData = new URLSearchParams();
                    deleteData.set('id_user', String(userId));
                    deleteData.set('id_pd', String(pdId));
                    var deleteResult = await postForm('/onlinestore/public/cart_delete.php', deleteData);
                    if (deleteResult.trim() === 'success') {
                        itemEl.remove();
                        recalcMiniCart();
                    }
                }
            });
        }
    });
</script>
