<?php
require_once __DIR__ . '/../src/bootstrap.php';
include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container info-page">
        <div class="info-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chủ</a> / Giới thiệu
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <aside class="info-card">
                    <h3>Danh mục</h3>
                    <ul class="info-list">
                        <li><a class="active" href="/onlinestore/public/gioi_thieu.php">Giới thiệu</a></li>
                        <li><a href="/onlinestore/public/su_kien.php">Sự kiện</a></li>
                        <li><a href="/onlinestore/public/tuyen_dung.php">Tuyển dụng</a></li>
                        <li><a href="/onlinestore/public/lien_he.php">Liên hệ</a></li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-9 info-content">
                <h1>Giới thiệu</h1>
                <p>Ra đời năm 2020, MORNING bắt đầu với một mong muốn rất đơn giản: tạo nên những trang phục dễ mặc, dễ yêu và dễ thể hiện chính bạn trên mỗi phiên bản.</p>
                <p>Tụi mình tin rằng: trang phục không chỉ là thứ bạn khoác lên người, mà còn là năng lượng bạn mang theo, một cách để mỗi cô gái thể hiện cá tính và cảm xúc riêng mình.</p>
                <p>Tại MORNING, bạn sẽ luôn tìm thấy những thiết kế tối giản, trẻ trung, hiện đại, nhưng vẫn đủ thoải mái để sống đúng với nhịp điệu cá nhân.</p>
                <p>Từng chi tiết, từ chất liệu, đường may đến bảng màu, từng lớp lót mềm mại đều được chăm chút để mang lại sự tự nhiên, vui tươi trong cả những khoảnh khắc thường ngày nhất.</p>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>