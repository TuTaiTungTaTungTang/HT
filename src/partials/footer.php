<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <h3 class="footer-title">Secodee</h3>
                <p class="footer-text">
                    <i class="fa-solid fa-location-dot"></i> 51/17 Giải Phóng, phường Tân Sơn Nhất, TP.HCM<br>
                    <i class="fa-solid fa-phone"></i> 0356686741<br>
                    <i class="fa-regular fa-envelope"></i> secodee.recruitment@gmail.com
                </p>
                <p class="footer-text mt-3 mb-0">HỘ KINH DOANH PHẠM THỊ DUNG<br>Website thuộc quyền sở hữu của bà Phạm Thị Dung</p>
            </div>

            <div class="col-lg-3 col-md-6">
                <h3 class="footer-title">HO TRO</h3>
                <a href="#" class="footer-link">He thong cua hang</a>
                <a href="#" class="footer-link">Chinh sach doi tra</a>
                <a href="#" class="footer-link">Chinh sach van chuyen</a>
                <a href="#" class="footer-link">Chinh sach bao mat</a>
                <a href="#" class="footer-link">Chinh sach kiem hang</a>
                <a href="#" class="footer-link">Huong dan thanh toan</a>
            </div>

            <div class="col-lg-3 col-md-6">
                <h3 class="footer-title">Fanpage</h3>
                <div class="fanpage-box">Facebook Fanpage Widget</div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h3 class="footer-title">THEO DOI CHUNG TOI</h3>
                <p class="footer-text">Dang ky de nhan thong tin som nhat ve cac chuong trinh khuyen mai.</p>
                <form class="footer-signup" action="#" method="post">
                    <input type="email" class="form-control search_input" placeholder="Email cua ban" aria-label="Email cua ban">
                    <button type="submit" class="btn-all_product">Dang ky</button>
                </form>
                <div class="social-row">
                    <a href="#" class="sn-icon"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#" class="sn-icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="sn-icon"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; Copyright 2026 by Secodee style demo on Morning Fashion.
        </div>
    </div>
</footer>

<div class="backtop">
    <i class="fa-solid fa-arrow-up"></i>
</div>

<script>
    $(document).ready(function() {
        var $backToTop = $(".backtop");
        $backToTop.hide();

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 20) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });

        $backToTop.on('click', function(e) {
            e.preventDefault();
            $("html, body").animate({scrollTop: 0}, 500);
        });
    });
</script>