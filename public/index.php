<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT27502\Project\Product;
use CT27502\Project\Category;

$product = new Product($PDO);
$allProducts = $product->all();

$category = new Category($PDO);
$categories = $category->all();


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

                <div class="row hot-product-list">
                    <?php
                    $promoProducts = array_slice($allProducts, 0, 6);
                    foreach ($promoProducts as $promoProduct) :
                    ?>
                    <div class="col-lg-2 col-sm-4 col-6 card card-product">
                        <a href="detail_product.php?id=<?= $promoProduct->getID() ?>" class="product_a">
                            <img src="<?= './uploads/' . html_escape($promoProduct->pd_image) ?>" class="card-img-top" alt="...">
                            <div class="card-title-wrap">
                                <h6 class="card-title"><?= html_escape($promoProduct->pd_name) ?></h6>
                            </div>
                        </a>
                        <p class="card-text price-product"><?= number_format(html_escape($promoProduct->pd_price)) . '₫'?></p>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role']=='user' && isset($_SESSION['name']) && isset($_SESSION['id'])){
                        echo'
                        <form action="cart_add.php" method="post">
                            <input type="hidden" name="idsanpham" value="'.$promoProduct->getID().'">
                            <input type="hidden" name="iduser" value="'.$_SESSION['id'].'">
                            <button class="btn-add_cart w-100" name="themgiohang">Thêm vào giỏ hàng</button>
                        </form>
                        ';
                        }
                        else echo '<button class="btn-add_cart w-100" disabled>Thêm vào giỏ hàng</button>';
                        ?>
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
                <div class="row hot-product-list">
                    <?php
                    $bestSellerProducts = array_slice($allProducts, 6, 6);
                    foreach ($bestSellerProducts as $bestProduct) :
                    ?>
                    <div class="col-lg-2 col-sm-4 col-6 card card-product">
                        <a href="detail_product.php?id=<?= $bestProduct->getID() ?>" class="product_a">
                            <img src="<?= './uploads/' . html_escape($bestProduct->pd_image) ?>" class="card-img-top" alt="...">
                            <div class="card-title-wrap">
                                <h6 class="card-title"><?= html_escape($bestProduct->pd_name) ?></h6>
                            </div>
                        </a>
                        <p class="card-text price-product"><?= number_format(html_escape($bestProduct->pd_price)) . '₫'?></p>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role']=='user' && isset($_SESSION['name']) && isset($_SESSION['id'])){
                        echo'
                        <form action="cart_add.php" method="post">
                            <input type="hidden" name="idsanpham" value="'.$bestProduct->getID().'">
                            <input type="hidden" name="iduser" value="'.$_SESSION['id'].'">
                            <button class="btn-add_cart w-100" name="themgiohang">Thêm vào giỏ hàng</button>
                        </form>
                        ';
                        }
                        else echo '<button class="btn-add_cart w-100" disabled>Thêm vào giỏ hàng</button>';
                        ?>
                    </div>
                    <?php endforeach ?>
                </div>
            </section>

            <?php foreach ($categories as $category) : ?>
                <section class="container-fluid category-hot">
                    <div class="section-head">
                        <h2 class="title">BỘ SƯU TẬP</h2>
                    </div>

                    <div class="collection-tabs">
                        <span class="tab-pill active">CLAIR DE SPRING</span>
                        <span class="tab-pill">XUÂN NHIÊN</span>
                        <span class="tab-pill">NIGHT OUT</span>
                        <span class="tab-pill">CITY HOURS</span>
                        <span class="tab-pill">CLASSMATE NOTES</span>
                        <span class="tab-pill">AFTER CLASS</span>
                    </div>

                    <div class="row hot-product-list">
                        <?php $hotProducts = $product->showHotProducts(html_escape($category->getID())) ;
                        foreach ($hotProducts as $hotProduct) :
                        ?>
                        <div class="col-lg-2 col-sm-4 col-6 card card-product">
                            <a href="detail_product.php?id=<?= $hotProduct->getID() ?>" class="product_a">
                                <img src="<?= './uploads/' . html_escape($hotProduct->pd_image) ?>" class="card-img-top" alt="...">
                                <div class="card-title-wrap">
                                    <h6 class="card-title"><?= html_escape($hotProduct->pd_name) ?></h6>
                                </div>
                            </a>
                            <p class="card-text price-product"><?= number_format(html_escape($hotProduct->pd_price)) . '₫'?></p>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role']=='user' && isset($_SESSION['name']) && isset($_SESSION['id'])){
                            $id = $_SESSION['id'];
                            echo'
                            <form action="cart_add.php" method="post">
                                <input type="hidden" name="idsanpham" value="'.$hotProduct->getID().'">
                                <input type="hidden" name="iduser" value="'.$_SESSION['id'].'">
                                <button class="btn-add_cart w-100" name="themgiohang">Thêm vào giỏ hàng</button>
                            </form>
                            ';
                            }
                            else echo '<button class="btn-add_cart w-100" disabled>Thêm vào giỏ hàng</button>';
                            ?>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <div class="text-center">
                        <a href="product.php?catID=<?=html_escape($category->getID())?>">
                            <button class="btn-all_product">
                                Xem tất cả sản phẩm <b><?= html_escape($category->cat_name) ?></b>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </a>
                    </div>
                </section>
            <?php endforeach ?>

            <section class="container-fluid category-hot">
                <div class="section-head">
                    <h2 class="title">TIN TỨC MỚI</h2>
                    <p class="section-divider">___ /// ___</p>
                </div>
                <div class="row g-3 news-row">
                    <div class="col-md-4">
                        <article class="news-card">
                            <img src="./images/banner-3.jpg" alt="Tin tuc 1">
                            <div class="news-content">
                                <h3>CHẬM LẠI THEO NHỊP THỞ ĐẦU THU</h3>
                                <span class="news-date">14/09/2025</span>
                                <p>Mùa thu luôn đến rất khẽ, không ồn ào mà dịu dàng như ánh nắng đầu ngày.</p>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4">
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

    <?php include_once __DIR__ .'/../src/partials/footer.php'?>
    
</body>

</html>

