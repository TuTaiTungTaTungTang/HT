<?php
require_once __DIR__ . '/../src/bootstrap.php';
include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container info-page">
        <div class="info-breadcrumb">
            <a href="/onlinestore/public/index.php">Trang chu</a> / Gioi thieu
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <aside class="info-card">
                    <h3>Danh muc</h3>
                    <ul class="info-list">
                        <li><a class="active" href="/onlinestore/public/gioi_thieu.php">Gioi thieu</a></li>
                        <li><a href="/onlinestore/public/su_kien.php">Su kien</a></li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-9 info-content">
                <h1>Gioi thieu</h1>
                <p>Ra doi nam 2020, MORNING bat dau voi mot mong muon rat don gian: tao nen nhung trang phuc de mac, de yeu va de the hien chinh ban tren moi phien ban.</p>
                <p>Tui minh tin rang: trang phuc khong chi la thu ban khoac len nguoi, ma con la nang luong ban mang theo, mot cach de moi co gai the hien ca tinh va cam xuc rieng minh.</p>
                <p>Tai MORNING, ban se luon tim thay nhung thiet ke toi gian, tre trung, hien dai, nhung van du thoai mai de song dung voi nhip dieu ca nhan.</p>
                <p>Tung chi tiet, tu chat lieu, duong may den bang mau, tung lop lot mem mai deu duoc cham chut de mang lai su tu nhien, vui tuoi trong ca nhung khoanh khac thuong ngay nhat.</p>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>
