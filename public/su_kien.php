<?php
require_once __DIR__ . '/../src/bootstrap.php';
include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container info-page">
        <div class="info-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chu</a> / Su kien
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <aside class="info-card">
                    <h3>Danh muc</h3>
                    <ul class="info-list">
                        <li><a href="/onlinestore/public/gioi_thieu.php">Gioi thieu</a></li>
                        <li><a class="active" href="/onlinestore/public/su_kien.php">Su kien</a></li>
                        <li><a href="/onlinestore/public/tuyen_dung.php">Tuyen dung</a></li>
                        <li><a href="/onlinestore/public/lien_he.php">Lien he</a></li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-9 info-content">
                <h1>Su kien</h1>

                <article class="event-item">
                    <span class="event-date">14/09/2025</span>
                    <h3>Khai truong khong gian thu dong</h3>
                    <p>Bo suu tap moi duoc ra mat voi concept toi gian va thanh lich, tap trung vao chat lieu mem nhe cho mua cuoi nam.</p>
                </article>

                <article class="event-item">
                    <span class="event-date">31/08/2025</span>
                    <h3>After Class pop-up</h3>
                    <p>Chuoi su kien pop-up danh cho sinh vien va nhan vien van phong voi uu dai theo set do va qua tang dac biet.</p>
                </article>

                <article class="event-item">
                    <span class="event-date">05/08/2025</span>
                    <h3>Workshop phoi do cuoi tuan</h3>
                    <p>Workshop chia se cach phoi do theo mau sac trung tinh va item co ban de ung dung linh hoat trong moi tinh huong.</p>
                </article>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>
