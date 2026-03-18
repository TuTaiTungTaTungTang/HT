<?php
require_once __DIR__ . '/../src/bootstrap.php';
include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container info-page contact-page">
        <div class="info-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chủ</a> / Liên hệ
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <aside class="info-card">
                    <h3>Danh mục</h3>
                    <ul class="info-list">
                        <li><a href="/onlinestore/public/gioi_thieu.php">Giới thiệu</a></li>
                        <li><a href="/onlinestore/public/su_kien.php">Sự kiện</a></li>
                        <li><a href="/onlinestore/public/tuyen_dung.php">Tuyển dụng</a></li>
                        <li><a class="active" href="/onlinestore/public/lien_he.php">Liên hệ</a></li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-9">
                <h1 class="contact-page-title">Liên hệ</h1>
                <div class="row g-4">
                    <div class="col-lg-7">
                        <h2 class="contact-title">Gửi thắc mắc cho chúng tôi</h2>
                        <form class="contact-form" action="#" method="post">
                            <label for="contact_name">Họ và tên</label>
                            <input id="contact_name" class="form-control" type="text" placeholder="Nhập tên của bạn">

                            <label for="contact_phone">Số điện thoại</label>
                            <input id="contact_phone" class="form-control" type="text" placeholder="Nhập số điện thoại của bạn">

                            <label for="contact_email">Email</label>
                            <input id="contact_email" class="form-control" type="email" placeholder="Nhập email của bạn">

                            <label for="contact_message">Tin nhắn</label>
                            <textarea id="contact_message" class="form-control" rows="5" placeholder="Nội dung..."></textarea>

                            <button type="submit" class="btn contact-send-btn">
                                Gửi liên hệ <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="col-lg-5 contact-info-wrap">
                        <h2 class="contact-title">Thông tin liên hệ</h2>
                        <p><i class="fa-solid fa-location-dot"></i> Đại học Cần Thơ, Khu II, đường 3/2, phường Xuân Khánh, quận Ninh Kiều, TP. Cần Thơ</p>
                        <p><i class="fa-solid fa-phone"></i> 0939554486</p>
                        <p><i class="fa-regular fa-envelope"></i> morningfashion@gmail.com</p>

                        <div class="contact-map-wrap">
                            <iframe
                                title="Google Map - Morning Fashion"
                                src="https://www.google.com/maps?q=Dai%20hoc%20Can%20Tho%20Khu%20II%20duong%203%2F2%20Xuan%20Khanh%20Ninh%20Kieu%20Can%20Tho&output=embed"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>