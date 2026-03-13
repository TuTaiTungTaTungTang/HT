<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid header_wrap secodee-navbar">
            <a class="navbar-brand brand-word" href="/onlinestore/public/index.php">secodee</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 secodee-menu">
                    <li class="nav-item mx-4">
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a class="nav-link active" aria-current="page" href="category_list.php">QUẢN LÝ DANH MỤC</a>';
                        } else {
                            echo '<a class="nav-link active dropdown-toggle" aria-current="page" href="/onlinestore/public/index.php">THÔNG TIN CHUNG</a>';
                        }
                        ?>
                    </li>

                    <li class="nav-item mx-4 dropdown">
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a class="nav-link active" aria-current="page" href="product_list.php">QUẢN LÝ MẶT HÀNG</a>';
                        } else {
                            echo '<div class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">SẢN PHẨM</div>
                                <ul class="dropdown-menu fs-5 text">
                                    <li><a class="dropdown-item" href="product.php?catID=1">Áo</a></li>
                                    <li><a class="dropdown-item" href="product.php?catID=2">Quần</a></li>
                                    <li><a class="dropdown-item" href="product.php?catID=3">Phụ kiện</a></li>
                                </ul>';
                        }
                        ?>
                    </li>

                    <li class="nav-item mx-4">
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a class="nav-link active" aria-current="page" href="order_list.php">QUẢN LÝ ĐƠN HÀNG</a>';
                        } else {
                            echo '<a class="nav-link active" aria-current="page" href="product.php">BST</a>';
                        }
                        ?>
                    </li>

                    <?php
                    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
                        echo '<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="product.php">ƯU ĐÃI</a></li>';
                        echo '<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="register.php">TUYỂN DỤNG</a></li>';
                        echo '<li class="nav-item mx-4"><a class="nav-link active" aria-current="page" href="login.php">LIÊN HỆ</a></li>';
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
                    <div class="dropdown nav-icon-dropdown">
                        <button class="action-link dropdown-toggle user-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Tài khoản">
                            <i class="fa-regular fa-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                echo '<li><a class="dropdown-item" href="category_list.php">Quản trị</a></li>';
                                echo '<li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>';
                            } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
                                echo '<li><span class="dropdown-item-text">' . html_escape($_SESSION['name']) . '</span></li>';
                                echo '<li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>';
                            } else {
                                echo '<li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>';
                                echo '<li><a class="dropdown-item" href="register.php">Đăng ký</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <a href="#" class="action-link" aria-label="Yêu thích"><i class="fa-regular fa-heart"></i><span class="count-badge">0</span></a>
                    <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
                        echo '<a href="cart.php?id=' . (int) $_SESSION['id'] . '" class="action-link" aria-label="Giỏ hàng"><i class="fa-solid fa-cart-shopping"></i><span class="count-badge">0</span></a>';
                    } else {
                        echo '<a href="login.php" class="action-link" aria-label="Giỏ hàng"><i class="fa-solid fa-cart-shopping"></i><span class="count-badge">0</span></a>';
                    }
                    ?>
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

<script>
    $(function() {
        var $toggle = $('.search-toggle');
        var $panel = $('#desktopSearchPanel');

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
    });
</script>
