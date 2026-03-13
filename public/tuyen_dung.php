<?php
require_once __DIR__ . '/../src/bootstrap.php';
include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container info-page recruit-page">
        <div class="info-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chu</a> / Tuyen dung
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <aside class="info-card">
                    <h3>Danh muc</h3>
                    <ul class="info-list">
                        <li><a href="/onlinestore/public/gioi_thieu.php">Gioi thieu</a></li>
                        <li><a href="/onlinestore/public/su_kien.php">Su kien</a></li>
                        <li><a class="active" href="/onlinestore/public/tuyen_dung.php">Tuyen dung</a></li>
                        <li><a href="/onlinestore/public/lien_he.php">Lien he</a></li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-9 info-content recruit-content">
                <h1>Tuyen dung</h1>
                <p class="recruit-subtitle">MORNING tim dong doi yeu thoi trang, chu dong va san sang hoc hoi moi ngay.</p>

                <article class="recruit-card">
                    <div class="recruit-head">
                        <h3>Fashion Sales Assistant</h3>
                        <span>Toan thoi gian</span>
                    </div>
                    <p><strong>Dia diem:</strong> Ninh Kieu, Can Tho</p>
                    <p><strong>Mo ta:</strong> Tu van san pham, sap xep trung bay va ho tro khach hang tai cua hang.</p>
                    <p><strong>Yeu cau:</strong> Giao tiep tot, than thien, co the xoay ca cuoi tuan.</p>
                </article>

                <article class="recruit-card">
                    <div class="recruit-head">
                        <h3>Social Content Intern</h3>
                        <span>Part-time</span>
                    </div>
                    <p><strong>Dia diem:</strong> Hybrid (Can Tho)</p>
                    <p><strong>Mo ta:</strong> Len y tuong va san xuat noi dung ngan cho Facebook, TikTok va Instagram.</p>
                    <p><strong>Yeu cau:</strong> Co gu tham my tot, biet dung Canva/CapCut la loi the.</p>
                </article>

                <div class="recruit-cta">
                    <h3>Cach ung tuyen</h3>
                    <p>Gui CV ve email <strong>morningfashion@gmail.com</strong> voi tieu de: <strong>[Vi tri] - Ho ten</strong>.</p>
                    <p>Hoac lien he nhanh qua hotline <strong>0939554486</strong> de duoc huong dan them.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>
