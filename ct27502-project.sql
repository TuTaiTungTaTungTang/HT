-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 18, 2026 lúc 11:43 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ct27502-project`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `pd_id` int(11) UNSIGNED NOT NULL,
  `pd_name` varchar(255) NOT NULL,
  `pd_price` varchar(255) NOT NULL,
  `pd_info` text NOT NULL,
  `pd_image` varchar(255) NOT NULL,
  `cat_id` int(11) UNSIGNED NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `pd_sizes` varchar(50) NOT NULL DEFAULT '',
  `pd_collection` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`pd_id`, `pd_name`, `pd_price`, `pd_info`, `pd_image`, `cat_id`, `is_new`, `pd_sizes`, `pd_collection`) VALUES
(1, 'ÁO - CEDRIC\n', '149000', 'Áo thun cotton mềm, thoáng mát, phù hợp mặc hằng ngày.', 'ao-thun-trang.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(2, '(Có Sẵn) Áo kiểu tay phồng trễ vai phối nơ form babydoll viền ren phối chun | TRUFFLE TOP | SECODEE\n', '285000', 'Áo sơ mi lịch sự, chất vải dày dặn, phù hợp đi làm.', 'ao-so-mi-oxford-navy.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(3, 'ÁO - GREGYN\n', '420000', 'Áo khoác bomber trẻ trung, có túi hông và khóa kéo bền.', 'ao-khoac-bomber.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(4, 'ÁO - HABROS\n', '375000', 'Hoodie nỉ dày dặn, giữ ấm tốt, form rộng dễ phối đồ.', 'ao-hoodie-ni.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(5, 'ÁO - HABSEL\n', '195000', 'Áo polo vải cá sấu, thiết kế đơn giản, dễ mặc.', 'ao-polo-nam.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(6, 'ÁO - HAFINS\n', '465000', 'Áo khoác jean phong cách, bền đẹp và dễ phối trang phục.', 'ao-khoac-jean.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(7, 'ÁO - INVER\n', '165000', 'Áo polo nữ dáng suông, chất liệu mềm, thoải mái vận động.', 'ao-polo-nu.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(8, 'ÁO - KAGI\n', '295000', 'Bộ đồ mặc nhà thoáng mát, dễ chịu, phù hợp mặc hằng ngày.', 'bo-do-mac-nha.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(9, 'ÁO - OZICIE\n', '189000', 'Áo thể thao nữ thoát ẩm nhanh, co giãn tốt khi tập luyện.', 'ao-the-thao-nu.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(10, 'ÁO - RHYTESS\n', '245000', 'Áo sơ mi nữ thanh lịch, dễ phối với quần tây hoặc chân váy.', 'ao-so-mi-nu-trang.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(11, 'ÁO - STURFI\n', '135000', 'Áo thun cổ tim trẻ trung, chất vải mềm và dễ giặt.', 'ao-thun-co-tim.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(12, 'ÁO KIỂU - BRYONY\n', '175000', 'Áo giữ nhiệt mỏng nhẹ, giữ ấm tốt cho ngày lạnh.', 'ao-giu-nhiet.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(13, 'ÁO KIỂU - DREWY\n', '259000', 'Áo cardigan len mỏng, mặc khoác ngoài lịch sự và gọn gàng.', 'ao-cardigan-len.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(14, '(CS) Quần Short Nữ Nỉ Mỏng Form Basic Mùa Hè Năng Động | DIVINE SHORTS | Secodee\n', '385000', 'Quần jean nữ co giãn nhẹ, ôm dáng vừa vặn.', 'quan-jean-nu-skinny.jpg', 2, 0, 'XS,M,L', ''),
(15, 'Quần Short Nữ NURINS SHORT Chất Nhung Gập Lai SECODEE\n', '245000', 'Quần short kaki thoáng mát, phù hợp đi chơi và dạo phố.', 'quan-short-kaki.jpg', 6, 0, 'XS,M,L', ''),
(16, 'Quần jogger thể thao', '295000', 'Quần jogger bo ống gọn, chất vải nhẹ và dễ vận động.', 'quan-jogger.jpg', 2, 0, 'XS,M,L', ''),
(17, 'Quần Short Nữ Form Bí Phồng Denim Cực Xinh | RUSSY SHORT| SECODEE\n', '425000', 'Quần tây nam form slimfit, lịch sự cho môi trường công sở.', 'quan-tay-nam.jpg', 2, 0, 'XS,M,L', ''),
(18, 'Quần jean nam baggy', '395000', 'Quần jean nam ống rộng, phong cách streetwear hiện đại.', 'quan-jean-baggy.jpg', 7, 0, 'XS,M,L,Freezie', ''),
(19, 'Quần legging nữ gym', '185000', 'Quần legging nữ co giãn 4 chiều, phù hợp tập gym hoặc yoga.', 'quan-legging.jpg', 2, 0, 'XS,M,L', ''),
(20, 'Quần culottes nữ linen', '335000', 'Quần culottes ống rộng, chất linen mát, dáng đẹp.', 'quan-culottes.jpg', 7, 0, 'XS,M,L,Freezie', ''),
(21, 'Quần nỉ nam nữ', '275000', 'Quần nỉ mềm ấm, mặc nhà hoặc đi chơi đều phù hợp.', 'quan-ni.jpg', 2, 0, 'XS,M,L', ''),
(22, 'Quần short jean nữ', '265000', 'Quần short jean nữ trẻ trung, dễ phối với áo thun.', 'quan-short-jean.jpg', 6, 0, 'XS,M,L', ''),
(23, 'Quần kaki nữ ống suông', '355000', 'Quần kaki nữ ống suông, thanh lịch cho môi trường công sở.', 'quan-kaki-nu.jpg', 7, 0, 'XS,M,L,Freezie', ''),
(24, 'Quần Short Nữ SVENRI SHORTS Phối Gấu Bèo 2 Tầng Dễ Thương SECODEE\n', '195000', 'Quần short thể thao nhẹ, nhanh khô và thoáng khí.', 'quan-short-the-thao.jpg', 6, 0, 'XS,M,L', ''),
(25, 'Quần dài nữ vải tuyết mưa', '315000', 'Quần dài nữ vải đẹp, ít nhăn, dễ bảo quản.', 'quan-dai-nu.jpg', 2, 0, 'XS,M,L', ''),
(26, 'Quần jean nam slim fit', '385000', 'Quần jean nam slim fit dễ mặc, dễ kết hợp trang phục.', 'quan-jean-nam-slim.jpg', 2, 0, 'XS,M,L', ''),
(27, 'Quần baggy nữ kaki', '295000', 'Quần baggy nữ phong cách Hàn Quốc, mặc thoải mái.', 'quan-baggy-nu.jpg', 7, 0, 'XS,M,L,Freezie', ''),
(28, 'Quần thể thao nữ dài', '235000', 'Quần thể thao nữ co giãn, phù hợp tập luyện hằng ngày.', 'quan-the-thao-nu.jpg', 2, 0, 'XS,M,L', ''),
(29, 'Túi tote canvas', '125000', 'Túi tote vải canvas bền đẹp, đựng được nhiều vật dụng.', 'tui-tote-canvas.jpg', 3, 0, 'Freezie', ''),
(30, 'Mũ lưỡi trai unisex', '89000', 'Mũ lưỡi trai đơn giản, dễ đội, dễ phối đồ.', 'mu-luoi-trai.jpg', 3, 0, 'Freezie', ''),
(31, 'Balo laptop 15.6 inch', '425000', 'Balo chống nước nhẹ, có ngăn riêng cho laptop.', 'balo-laptop.jpg', 3, 0, 'Freezie', ''),
(32, 'Dây nịt da nam', '185000', 'Dây nịt da khóa tự động, phù hợp đi làm và sự kiện.', 'day-nit-da.jpg', 3, 0, 'Freezie', ''),
(33, 'Vớ cổ cao thể thao', '85000', 'Bộ vớ cổ cao mềm, thoáng, dùng cho sinh hoạt hằng ngày.', 'vo-co-cao.jpg', 3, 0, 'Freezie', ''),
(34, 'Khăn choàng cổ len', '145000', 'Khăn len mềm, giữ ấm tốt trong thời tiết lạnh.', 'khan-choang-len.jpg', 3, 0, 'Freezie', ''),
(35, 'Túi xách nữ da PU', '385000', 'Túi xách nữ kích thước vừa, tiện dụng khi đi làm.', 'tui-xach-nu.jpg', 3, 0, 'Freezie', ''),
(36, 'Mũ len beanie', '75000', 'Mũ len beanie đơn giản, giữ ấm và dễ phối trang phục.', 'mu-beanie.jpg', 3, 0, 'Freezie', ''),
(37, 'Balo mini nữ', '255000', 'Balo mini nữ nhỏ gọn, phù hợp đi chơi hoặc dạo phố.', 'balo-mini-nu.jpg', 3, 0, 'Freezie', ''),
(38, 'Mũ bucket 2 mặt', '95000', 'Mũ bucket 2 mặt tiện dụng, che nắng tốt.', 'mu-bucket.jpg', 3, 0, 'Freezie', ''),
(39, 'Kính mát chống UV', '175000', 'Kính mát thời trang chống tia UV, bảo vệ mắt.', 'kinh-mat.jpg', 3, 0, 'Freezie', ''),
(40, 'Túi đeo chéo vải dù', '145000', 'Túi đeo chéo nhỏ gọn, chất liệu vải dù chống nước nhẹ.', 'tui-deo-cheo.jpg', 3, 0, 'Freezie', ''),
(70, 'Đầm suông vải linen nữ tính', '345000', 'Đầm suông chất linen mát, dáng rộng thoải mái mặc mùa hè.', 'dam-suong-linen.jpg', 4, 1, 'XS,M,L', ''),
(71, 'Đầm xòe hoa nhí dáng midi', '389000', 'Đầm xòe họa tiết hoa nhí, dáng midi thanh lịch quyến rũ.', 'dam-xoe-hoa-nhi.jpg', 4, 1, 'XS,M,L', ''),
(72, 'Đầm body ôm dáng cổ vuông', '275000', 'Đầm body cổ vuông, ôm vóc dáng, phù hợp đi tiệc nhẹ.', 'dam-body-co-vuong.jpg', 4, 1, 'XS,M,L', ''),
(73, 'Đầm babydoll tay phồng', '299000', 'Đầm babydoll tay phồng dáng búp bê, trẻ trung và đáng yêu.', 'dam-babydoll.jpg', 4, 1, 'XS,M,L', ''),
(74, 'Đầm maxi vải voan dự tiệc', '465000', 'Đầm maxi dài vải voan nhẹ, phù hợp đi tiệc hoặc chụp ảnh ngoại cảnh.', 'dam-maxi-voan.jpg', 4, 1, 'XS,M,L', ''),
(75, 'Yếm jean dáng rộng unisex', '265000', 'Yếm jean cổ thấp, dáng rộng dễ phối áo thun hoặc áo croptop.', 'yem-jean-rong.jpg', 5, 1, 'XS,M,L,Freezie', ''),
(76, 'Yếm vải thô cổ chữ U', '225000', 'Yếm vải thô mềm, cổ chữ U thanh thoát, mặc mùa hè mát mẻ.', 'yem-vai-tho.jpg', 5, 1, 'XS,M,L,Freezie', ''),
(77, 'Yếm trắng phối ren dáng ngắn', '245000', 'Yếm trắng phối đăng-ten tinh tế, dáng ngắn trẻ trung.', 'yem-trang-ren.jpg', 5, 1, 'XS,M,L,Freezie', ''),
(78, 'Yếm kẻ caro vintage', '255000', 'Yếm kẻ caro phong cách vintage, dễ phối với nhiều kiểu áo.', 'yem-caro-vintage.jpg', 5, 1, 'XS,M,L,Freezie', ''),
(79, 'Chân váy midi xếp ly thanh lịch', '315000', 'Chân váy midi xếp ly nhiều tầng, dáng suông nhẹ nhàng duyên dáng.', 'chan-vay-midi-xep-ly.jpg', 8, 1, 'XS,M,L', ''),
(80, 'Chân váy tennis ngắn trắng', '285000', 'Chân váy tennis viền đăng-ten, năng động phù hợp nhiều style.', 'chan-vay-tennis.jpg', 8, 1, 'XS,M,L', ''),
(81, 'Chân váy jean mini dáng A', '295000', 'Chân váy jean mini dáng chữ A, trẻ trung và dễ mặc.', 'chan-vay-jean-mini.jpg', 8, 1, 'XS,M,L', ''),
(82, 'Chân váy dài vải chiffon hoa', '355000', 'Chân váy dài vải chiffon nhẹ, họa tiết hoa đẹp mắt.', 'chan-vay-chiffon-hoa.jpg', 8, 1, 'XS,M,L', ''),
(83, 'Chân váy bút chì công sở kẻ sọc', '375000', 'Chân váy bút chì kẻ sọc mảnh, lịch sự cho môi trường văn phòng.', 'chan-vay-but-chi.jpg', 8, 1, 'XS,M,L', ''),
(108, '\nÁO - TINNE', '365000', 'Ao organza tay phong, tong mau nhe va de phoi do cho nhung set do mua xuan.', 'bst-cds-1.jpg', 1, 0, 'XS,M,L', 'clair-de-spring'),
(109, 'Mini dress - JESSI', '425000', 'Yem dang dai mem rui, hop cho nhung outfit thanh lich va ngot ngao.', 'bst-cds-2.jpg', 5, 0, 'XS,M,L,Freezie', 'clair-de-spring'),
(111, '\nÁO - JIEMIA\n', '395000', 'Ao len mong tong pastel, phu hop nhung bo suu tap diu dang va tre trung.', 'bst-cds-4.jpg', 1, 0, 'M,L,Freezie', 'clair-de-spring'),
(112, 'ÁO - MERAD\n', '335000', 'Ao yem phoi not no xinh xan, tone mau nhe nhu khong khi tet dau nam.', 'bst-xn-1.jpg', 5, 0, 'XS,M,L', 'xuan-nhien'),
(113, 'ÁO DÀI - DIÊN VỸ\n', '520000', 'Dam lua mem voi tong xanh trong, mang cam giac nhe nhang va thanh thoat.', 'bst-xn-2.jpg', 4, 0, 'XS,M,L', 'xuan-nhien'),
(114, 'ÁO - EVANIA\n', '285000', 'Croptop xep ly nhe, gam hong phan diu mat cho mua le hoi dau nam.', 'bst-xn-3.jpg', 1, 0, 'XS,M,L', 'xuan-nhien'),
(115, 'ÁO - NAERYN\n', '355000', 'Chan vay xep ly de di chuc tet, de phoi voi nhieu kieu ao.', 'bst-xn-4.jpg', 8, 0, 'XS,M,L', 'xuan-nhien'),
(116, 'ĐẦM - THIERRY\n', '545000', 'Dam sat om dang ton form, hop cho nhung buoi hen toi va su kien nho.', 'bst-no-1.jpg', 4, 0, 'XS,M,L', 'night-out'),
(117, 'ÁO - RICHARD\n', '395000', 'Ao corset nhan eo, tao diem nhan manh me cho set do night out.', 'bst-no-2.jpg', 1, 0, 'XS,M,L', 'night-out'),
(118, 'ÁO - JODIE\n', '315000', 'Chan vay mini tong toi, phoi cung boots va ao om rat hop.', 'bst-no-3.jpg', 8, 0, 'XS,M,L', 'night-out'),
(119, 'Áo Tay Dài Nữ SCARLET TOP Phối Lông Cá Tính Chất Thun Co Giãn SECODEE\n', '265000', 'Tui mini de tiec nho, kich thuoc gon nhe nhung van noi bat.', 'bst-no-4.jpg', 3, 0, 'Freezie', 'night-out'),
(120, 'ÁO - CARYSI\n', '325000', 'Ao so mi thanh lich danh cho ngay di lam, de phoi voi quan ong suong.', 'bst-ch-1.jpg', 1, 0, 'M,L,Freezie', 'city-hours'),
(121, 'ÁO - ARDESON\n', '375000', 'Cardigan mong khoac ngoai, hoan thien set do cong so gon gang.', 'bst-ch-2.jpg', 1, 0, 'M,L,Freezie', 'city-hours'),
(122, 'ÁO - FINEGAN\n', '410000', 'Quan ong suong dang dai, mac len dep va tao cam giac chuyen nghiep.', 'bst-ch-3.jpg', 7, 0, 'XS,M,L', 'city-hours'),
(123, 'ÁO - CERITH\n', '365000', 'Chan vay but chi cho set do lam viec, ton dang va de di chuyen.', 'bst-ch-4.jpg', 8, 0, 'XS,M,L', 'city-hours'),
(124, '(BÁN LẺ) Quần Nữ JURLES Dài Ống Rộng Thể Thao Năng Động SECODEE\n', '225000', 'Ao thun tre trung phu hop di hoc va di choi hang ngay.', 'bst-cn-1.jpg', 1, 0, 'XS,M,L,Freezie', 'classmate-notes'),
(125, 'ÁO - ROCHELL\n', '435000', 'Hoodie phong cach hoc duong, mac cung short hoac jean deu hop.', 'bst-cn-2.jpg', 1, 0, 'M,L,Freezie', 'classmate-notes'),
(126, 'ÁO KHOÁC - OTTILIE\n', '275000', 'Quan short dang rong, nang dong cho nhung ngay den truong.', 'bst-cn-3.jpg', 6, 0, 'XS,M,L', 'classmate-notes'),
(127, 'ÁO - BREXYN\n', '455000', 'Khoac bomber ca tinh, tao diem nhan cho set do hoc duong.', 'bst-cn-4.jpg', 1, 0, 'M,L,Freezie', 'classmate-notes'),
(128, 'ÁO KHOÁC - SARCHY\n', '255000', 'Ao polo co gian nhe, phu hop nhung ngay hoat dong sau gio hoc.', 'bst-ac-1.jpg', 1, 0, 'XS,M,L', 'after-class'),
(129, 'ÁO KIỂU - IRINE\n', '335000', 'Jogger mem va gon, de mac trong luc di choi hay tap nhe.', 'bst-ac-2.jpg', 2, 0, 'XS,M,L', 'after-class'),
(130, 'ÁO KIỂU - JAKKE\n', '295000', 'Ao dry fit thoang, phu hop nhung buoi van dong cuoi ngay.', 'bst-ac-3.jpg', 1, 0, 'XS,M,L', 'after-class'),
(131, 'ÁO KIỂU - GINNY\n', '310000', 'Legging co gian 4 chieu, de phoi cung ao ngan va hoodie.', 'bst-ac-4.jpg', 2, 0, 'XS,M,L', 'after-class'),
(132, 'Ao Linen Drift', '215000', 'Ao linen mong nhe, hop outfit he toi gian.', 'fs-1.jpg', 1, 0, 'XS,M,L', 'flash-sale'),
(133, 'Dam Misty Blue', '275000', 'Dam xanh nhat, dang suong de mac hang ngay.', 'fs-2.jpg', 4, 0, 'XS,M,L', 'flash-sale'),
(134, 'Yem Soft Tide', '245000', 'Yem dang dai, chat lieu mem va thoang.', 'fs-3.jpg', 5, 0, 'XS,M,L', 'flash-sale'),
(135, 'Quan Chill Fit', '235000', 'Quan form rong nhe, de phoi ao co ban.', 'fs-4.jpg', 7, 0, 'XS,M,L', 'flash-sale'),
(136, 'Ao Crop Whisper', '199000', 'Ao crop co gian nhe, tong mau trung tinh.', 'fs-5.jpg', 1, 0, 'XS,M,L', 'flash-sale'),
(137, 'Chân Váy Breeze', '225000', 'Chan vay bay nhe, duong cat thanh lich.', 'fs-6.jpg', 8, 0, 'XS,M,L', 'flash-sale'),
(138, 'Áo Polo Dawn', '205000', 'Ao polo daily wear, form gon de mac.', 'fs-7.jpg', 1, 0, 'XS,M,L', 'flash-sale'),
(139, 'Đầm Ribbon Light', '289000', 'Dam co diem nhan no nho, phong cach nu tinh.', 'fs-8.jpg', 4, 0, 'XS,M,L', 'flash-sale'),
(338, 'Áo Len', '247037', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-1-ao-len.avif', 1, 1, 'XS,M,L,Freezie', ''),
(339, 'Sọc Đỏ Trắng', '400370', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-10-sc-d-trng.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(340, 'Áo Xanh Vàng', '417407', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-11-ao-xanh-v-ang.avif', 1, 1, 'XS,M,L,Freezie', ''),
(341, 'Quần Xám', '434444', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-12-qun-x-am.jpg', 2, 1, 'XS,M,L,Freezie', ''),
(342, 'Quần Hồng', '451481', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-13-qun-hng.jpg', 2, 1, 'XS,M,L,Freezie', ''),
(343, 'Quần Xám', '238517', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-14-qun-x-am.avif', 2, 1, 'XS,M,L,Freezie', ''),
(344, 'Đầm Xám Góc Khác', '575555', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-15-dm-x-am-g-oc-kh-ac.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(345, 'Áo Len Hoa Idol', '272591', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-16-ao-len-hoa-idol.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(346, 'Len Tay Bồng', '289628', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-17-len-tay-bng.avif', 1, 1, 'XS,M,L,Freezie', ''),
(347, 'Áo Khoác Vàng', '306665', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-18-ao-kho-ac-v-ang.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(348, 'Cardigan Blue', '323702', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-19-cardigan-blue.avif', 1, 1, 'XS,M,L,Freezie', ''),
(349, 'Đỏ Caro', '264074', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-2-d-caro.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(350, 'Váy Caro Đỏ', '390739', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-20-v-ay-caro-d.avif', 4, 1, 'XS,M,L,Freezie', ''),
(351, 'Set Mùa Hè', '357776', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-21-set-m-ua-h-e.avif', 1, 1, 'XS,M,L,Freezie', ''),
(352, 'Đầm Xanh', '424813', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-22-dm-xanh.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(353, 'Đầm Nơ Caro Trắng', '441850', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-23-dm-n-caro-trng.avif', 4, 1, 'XS,M,L,Freezie', ''),
(354, 'Đầm Caro Đen', '458887', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-24-dm-caro-den.avif', 4, 1, 'XS,M,L,Freezie', ''),
(355, 'Đầm Chấm Bi', '475924', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-25-dm-chm-bi.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(356, 'Caro Pastel', '442961', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-26-caro-pastel.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(357, 'Set Caro Xanh', '459998', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-27-set-caro-xanh.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(358, 'Set Hồng', '247034', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-28-set-hng.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(359, 'Set', '264071', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-29-set.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(360, 'Xanhcaro', '281111', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-3-xanhcaro.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(361, 'Set Trắng', '281108', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-30-set-trng.avif', 1, 1, 'XS,M,L,Freezie', ''),
(362, 'Đầm Vintage', '578146', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-31-dm-vintage.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(363, 'Đầm Xanh', '325182', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-32-dm-xanh.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(364, 'Váy Tím', '342219', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-33-v-ay-t-im.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(365, 'Quần Nhiều Màu', '349256', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-34-qun-nhiu-m-au.avif', 2, 1, 'XS,M,L,Freezie', ''),
(366, 'Yếm Trắng', '456293', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-35-ym-trng.jpg', 5, 1, 'XS,M,L,Freezie', ''),
(367, 'Set Váy Voan', '393330', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-36-set-v-ay-voan.avif', 4, 1, 'XS,M,L,Freezie', ''),
(368, 'Set Vàng', '400367', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-37-set-v-ang.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(369, 'Set Kem', '417404', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-38-set-kem.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(370, 'Đầm Xanh', '444441', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-39-dm-xanh.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(371, 'Xanh Trắng', '298148', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-4-xanh-trng.avif', 1, 1, 'XS,M,L,Freezie', ''),
(372, 'Đầm Nơ Đen', '461478', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-40-dm-n-den.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(373, 'Suitdenim', '238514', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-41-suitdenim.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(374, 'Khoác Da Đỏ', '255551', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-42-kho-ac-da-d.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(375, 'Áo Khoác Xanh', '272588', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-43-ao-kho-ac-xanh.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(376, 'Sơ Mi Xanh', '289625', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-44-s-mi-xanh.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(377, 'Sơ Mi Sọc', '306662', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-45-s-mi-sc.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(378, 'Đầm Vàng', '563700', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-46-dm-v-ang.jpg', 4, 1, 'XS,M,L,Freezie', ''),
(379, 'Set Hoa Đỏ', '340736', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-47-set-hoa-d.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(380, 'Nàng Thơ Mùa Hè', '357773', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-48-n-ang-th-m-ua-h-e.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(381, 'Set Xanh Biển', '374810', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-49-set-xanh-bin.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(382, 'Whitebabydoll', '315185', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-5-whitebabydoll.avif', 1, 1, 'XS,M,L,Freezie', ''),
(383, 'Set', '391847', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-50-set.jpg', 1, 1, 'XS,M,L,Freezie', ''),
(384, 'Áo Thêu Hoa', '332222', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-6-ao-th-eu-hoa.avif', 1, 1, 'XS,M,L,Freezie', ''),
(385, 'Áo Hoa', '349259', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-7-ao-hoa.avif', 1, 1, 'XS,M,L,Freezie', ''),
(386, 'Áo Y2K', '366296', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-8-ao-y2k.avif', 1, 1, 'XS,M,L,Freezie', ''),
(387, 'Váy Hồng', '473333', 'San pham duoc them tu bo suu tap hinh anh clothes.', 'clothes-9-v-ay-hng.jpg', 4, 1, 'XS,M,L,Freezie', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pd_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `pd_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=388;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
