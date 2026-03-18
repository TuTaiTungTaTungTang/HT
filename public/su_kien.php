<?php
require_once __DIR__ . '/../src/bootstrap.php';
include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container info-page">
        <div class="info-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chủ</a> / Sự kiện
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <aside class="info-card">
                    <h3>Danh mục</h3>
                    <ul class="info-list">
                        <li><a href="/onlinestore/public/gioi_thieu.php">Giới thiệu</a></li>
                        <li><a class="active" href="/onlinestore/public/su_kien.php">Sự kiện</a></li>
                        <li><a href="/onlinestore/public/tuyen_dung.php">Tuyển dụng</a></li>
                        <li><a href="/onlinestore/public/lien_he.php">Liên hệ</a></li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-9 info-content">
                <h1>Sự kiện</h1>

                <article class="event-item">
                    <span class="event-date">14/09/2025</span>
                    <h3>Khai trương không gian thu đông</h3>
                    <p>Bộ sưu tập mới được ra mắt với concept tối giản và thanh lịch, tập trung vào chất liệu mềm nhẹ cho mùa cuối năm.</p>
                </article>

                <article class="event-item">
                    <span class="event-date">31/08/2025</span>
                    <h3>After Class pop-up</h3>
                    <p>Chuỗi sự kiện pop-up dành cho sinh viên và nhân viên văn phòng với ưu đãi theo set đồ và quà tặng đặc biệt.</p>
                </article>

                <article class="event-item">
                    <span class="event-date">05/08/2025</span>
                    <h3>Workshop phối đồ cuối tuần</h3>
                    <p>Workshop chia sẻ cách phối đồ theo màu sắc trung tính và item cơ bản để ứng dụng linh hoạt trong mọi tình huống.</p>
                </article>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>