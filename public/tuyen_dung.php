<?php
require_once __DIR__ . '/../src/bootstrap.php';
include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container info-page recruit-page">
        <div class="info-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chủ</a> / Tuyển dụng
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <aside class="info-card">
                    <h3>Danh mục</h3>
                    <ul class="info-list">
                        <li><a href="/onlinestore/public/gioi_thieu.php">Giới thiệu</a></li>
                        <li><a href="/onlinestore/public/su_kien.php">Sự kiện</a></li>
                        <li><a class="active" href="/onlinestore/public/tuyen_dung.php">Tuyển dụng</a></li>
                        <li><a href="/onlinestore/public/lien_he.php">Liên hệ</a></li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-9 info-content recruit-content">
                <h1>Tuyển dụng</h1>
                <p class="recruit-subtitle">MORNING tìm đồng đội yêu thời trang, chủ động và sẵn sàng học hỏi mỗi ngày.</p>

                <article class="recruit-card">
                    <div class="recruit-head">
                        <h3>Fashion Sales Assistant</h3>
                        <span>Toàn thời gian</span>
                    </div>
                    <p><strong>Địa điểm:</strong> Ninh Kiều, Cần Thơ</p>
                    <p><strong>Mô tả:</strong> Tư vấn sản phẩm, sắp xếp trưng bày và hỗ trợ khách hàng tại cửa hàng.</p>
                    <p><strong>Yêu cầu:</strong> Giao tiếp tốt, thân thiện, có thể xoay ca cuối tuần.</p>
                </article>

                <article class="recruit-card">
                    <div class="recruit-head">
                        <h3>Social Content Intern</h3>
                        <span>Part-time</span>
                    </div>
                    <p><strong>Địa điểm:</strong> Hybrid (Cần Thơ)</p>
                    <p><strong>Mô tả:</strong> Lên ý tưởng và sản xuất nội dung ngắn cho Facebook, TikTok và Instagram.</p>
                    <p><strong>Yêu cầu:</strong> Có gu thẩm mỹ tốt, biết dùng Canva/CapCut là lợi thế.</p>
                </article>

                <div class="recruit-cta">
                    <h3>Cách ứng tuyển</h3>
                    <p>Gửi CV về email <strong>morningfashion@gmail.com</strong> với tiêu đề: <strong>[Vị trí] - Họ tên</strong>.</p>
                    <p>Hoặc liên hệ nhanh qua hotline <strong>0939554486</strong> để được hướng dẫn thêm.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>