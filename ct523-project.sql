-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 23, 2026 lúc 08:40 AM
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
-- Cơ sở dữ liệu: `ct523-project`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `pd_id` int(11) UNSIGNED NOT NULL,
  `pd_size` varchar(20) NOT NULL DEFAULT 'Freezie',
  `pd_quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`user_id`, `pd_id`, `pd_size`, `pd_quantity`) VALUES
(6, 19, 'Freezie', 1),
(7, 12, 'Freezie', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Áo'),
(2, 'Quần'),
(3, 'Phụ kiện'),
(4, 'Đầm'),
(5, 'Yếm'),
(6, 'Quần Shorts'),
(7, 'Quần ống rộng'),
(8, 'Chân váy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) UNSIGNED NOT NULL,
  `order_code` int(5) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pd_id` int(11) UNSIGNED NOT NULL,
  `pd_size` varchar(20) NOT NULL DEFAULT 'Freezie',
  `pd_quantity` int(6) NOT NULL,
  `stock_deducted` tinyint(1) NOT NULL DEFAULT 0,
  `stock_returned` tinyint(1) NOT NULL DEFAULT 0,
  `order_total` int(12) NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `user_id`, `address`, `phone`, `pd_id`, `pd_size`, `pd_quantity`, `stock_deducted`, `stock_returned`, `order_total`, `order_status`) VALUES
(31, 2396, 6, 'Cần Thơ', '0939554486', 11, 'Freezie', 1, 0, 0, 135000, 1),
(32, 3678, 6, 'adfadsfasdfasd', '0988554455', 118, 'Freezie', 3, 0, 0, 945000, 1),
(33, 8599, 6, 'fasdfsdafasd', '0988997788', 137, 'Freezie', 1, 0, 0, 225000, 4),
(34, 7896, 8, 'Cần Thơ', '0988775544', 114, 'Freezie', 1, 0, 0, 285000, 2);

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
(2, '(Có Sẵn) Áo kiểu tay phồng trễ vai phối nơ form babydoll viền ren phối chun | TRUFFLE TOP | SECODEE\n', '285000', 'Áo sơ mi lịch sự, chất vải dày dặn, phù hợp đi làm.', 'ao-so-mi-oxford-navy.jpg', 1, 0, 'XS,M', ''),
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
(115, 'ÁO - NAERYN\n', '355000', 'Chan vay xep ly de di chuc tet, de phoi voi nhieu kieu ao.', 'bst-xn-4.jpg', 1, 0, 'XS,M,L', 'xuan-nhien'),
(116, 'ĐẦM - THIERRY\n', '545000', 'Dam sat om dang ton form, hop cho nhung buoi hen toi va su kien nho.', 'bst-no-1.jpg', 4, 0, 'XS,M,L', 'night-out'),
(117, 'ÁO - RICHARD\n', '395000', 'Ao corset nhan eo, tao diem nhan manh me cho set do night out.', 'bst-no-2.jpg', 1, 0, 'XS,M,L', 'night-out'),
(118, 'ÁO - JODIE\n', '315000', 'Chan vay mini tong toi, phoi cung boots va ao om rat hop.', 'bst-no-3.jpg', 1, 0, 'XS,M,L', 'night-out'),
(119, 'Áo Tay Dài Nữ SCARLET TOP Phối Lông Cá Tính Chất Thun Co Giãn SECODEE\n', '265000', 'Tui mini de tiec nho, kich thuoc gon nhe nhung van noi bat.', 'bst-no-4.jpg', 1, 0, 'Freezie', 'night-out'),
(120, 'ÁO - CARYSI\n', '325000', 'Ao so mi thanh lich danh cho ngay di lam, de phoi voi quan ong suong.', 'bst-ch-1.jpg', 1, 0, 'M,L,Freezie', 'city-hours'),
(121, 'ÁO - ARDESON\n', '375000', 'Cardigan mong khoac ngoai, hoan thien set do cong so gon gang.', 'bst-ch-2.jpg', 1, 0, 'M,L,Freezie', 'city-hours'),
(122, 'ÁO - FINEGAN\n', '410000', 'Quan ong suong dang dai, mac len dep va tao cam giac chuyen nghiep.', 'bst-ch-3.jpg', 7, 0, 'XS,M,L', 'city-hours'),
(123, 'ÁO - CERITH\n', '365000', 'Chan vay but chi cho set do lam viec, ton dang va de di chuyen.', 'bst-ch-4.jpg', 1, 0, 'XS,M,L', 'city-hours'),
(124, '(BÁN LẺ) Quần Nữ JURLES Dài Ống Rộng Thể Thao Năng Động SECODEE\n', '225000', 'Ao thun tre trung phu hop di hoc va di choi hang ngay.', 'bst-cn-1.jpg', 1, 0, 'XS,M,L,Freezie', 'classmate-notes'),
(125, 'ÁO - ROCHELL\n', '435000', 'Hoodie phong cach hoc duong, mac cung short hoac jean deu hop.', 'bst-cn-2.jpg', 1, 0, 'M,L,Freezie', 'classmate-notes'),
(126, 'ÁO KHOÁC - OTTILIE\n', '275000', 'Quan short dang rong, nang dong cho nhung ngay den truong.', 'bst-cn-3.jpg', 1, 0, 'XS,M,L', 'classmate-notes'),
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_size_stock`
--

CREATE TABLE `product_size_stock` (
  `stock_id` int(11) UNSIGNED NOT NULL,
  `pd_id` int(11) UNSIGNED NOT NULL,
  `size_code` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_size_stock`
--

INSERT INTO `product_size_stock` (`stock_id`, `pd_id`, `size_code`, `quantity`) VALUES
(1, 1, 'XS', 10),
(2, 1, 'M', 10),
(3, 1, 'L', 10),
(4, 1, 'Freezie', 10),
(5, 2, 'XS', 10),
(6, 2, 'M', 10),
(7, 3, 'XS', 10),
(8, 3, 'M', 10),
(9, 3, 'L', 10),
(10, 3, 'Freezie', 10),
(11, 4, 'XS', 10),
(12, 4, 'M', 10),
(13, 4, 'L', 10),
(14, 4, 'Freezie', 10),
(15, 5, 'XS', 10),
(16, 5, 'M', 10),
(17, 5, 'L', 10),
(18, 5, 'Freezie', 10),
(19, 6, 'XS', 10),
(20, 6, 'M', 10),
(21, 6, 'L', 10),
(22, 6, 'Freezie', 10),
(23, 7, 'XS', 10),
(24, 7, 'M', 10),
(25, 7, 'L', 10),
(26, 7, 'Freezie', 10),
(27, 8, 'XS', 10),
(28, 8, 'M', 10),
(29, 8, 'L', 10),
(30, 8, 'Freezie', 10),
(31, 9, 'XS', 10),
(32, 9, 'M', 10),
(33, 9, 'L', 10),
(34, 9, 'Freezie', 10),
(35, 10, 'XS', 10),
(36, 10, 'M', 10),
(37, 10, 'L', 10),
(38, 10, 'Freezie', 10),
(39, 11, 'XS', 10),
(40, 11, 'M', 10),
(41, 11, 'L', 10),
(42, 11, 'Freezie', 10),
(43, 12, 'XS', 10),
(44, 12, 'M', 10),
(45, 12, 'L', 10),
(46, 12, 'Freezie', 10),
(47, 13, 'XS', 10),
(48, 13, 'M', 10),
(49, 13, 'L', 10),
(50, 13, 'Freezie', 10),
(51, 14, 'XS', 10),
(52, 14, 'M', 10),
(53, 14, 'L', 10),
(54, 15, 'XS', 10),
(55, 15, 'M', 10),
(56, 15, 'L', 10),
(57, 16, 'XS', 10),
(58, 16, 'M', 10),
(59, 16, 'L', 10),
(60, 17, 'XS', 10),
(61, 17, 'M', 10),
(62, 17, 'L', 10),
(63, 18, 'XS', 10),
(64, 18, 'M', 10),
(65, 18, 'L', 10),
(66, 18, 'Freezie', 10),
(67, 19, 'XS', 10),
(68, 19, 'M', 10),
(69, 19, 'L', 10),
(70, 20, 'XS', 10),
(71, 20, 'M', 10),
(72, 20, 'L', 10),
(73, 20, 'Freezie', 10),
(74, 21, 'XS', 10),
(75, 21, 'M', 10),
(76, 21, 'L', 10),
(77, 22, 'XS', 10),
(78, 22, 'M', 10),
(79, 22, 'L', 10),
(80, 23, 'XS', 10),
(81, 23, 'M', 10),
(82, 23, 'L', 10),
(83, 23, 'Freezie', 10),
(84, 24, 'XS', 10),
(85, 24, 'M', 10),
(86, 24, 'L', 10),
(87, 25, 'XS', 10),
(88, 25, 'M', 10),
(89, 25, 'L', 10),
(90, 26, 'XS', 10),
(91, 26, 'M', 10),
(92, 26, 'L', 10),
(93, 27, 'XS', 10),
(94, 27, 'M', 10),
(95, 27, 'L', 10),
(96, 27, 'Freezie', 10),
(97, 28, 'XS', 10),
(98, 28, 'M', 10),
(99, 28, 'L', 10),
(100, 29, 'Freezie', 10),
(101, 30, 'Freezie', 10),
(102, 31, 'Freezie', 10),
(103, 32, 'Freezie', 10),
(104, 33, 'Freezie', 10),
(105, 34, 'Freezie', 10),
(106, 35, 'Freezie', 10),
(107, 36, 'Freezie', 10),
(108, 37, 'Freezie', 10),
(109, 38, 'Freezie', 10),
(110, 39, 'Freezie', 10),
(111, 40, 'Freezie', 10),
(112, 70, 'XS', 10),
(113, 70, 'M', 10),
(114, 70, 'L', 10),
(115, 71, 'XS', 10),
(116, 71, 'M', 10),
(117, 71, 'L', 10),
(118, 72, 'XS', 10),
(119, 72, 'M', 10),
(120, 72, 'L', 10),
(121, 73, 'XS', 10),
(122, 73, 'M', 10),
(123, 73, 'L', 10),
(124, 74, 'XS', 10),
(125, 74, 'M', 10),
(126, 74, 'L', 10),
(127, 75, 'XS', 10),
(128, 75, 'M', 10),
(129, 75, 'L', 10),
(130, 75, 'Freezie', 10),
(131, 76, 'XS', 10),
(132, 76, 'M', 10),
(133, 76, 'L', 10),
(134, 76, 'Freezie', 10),
(135, 77, 'XS', 10),
(136, 77, 'M', 10),
(137, 77, 'L', 10),
(138, 77, 'Freezie', 10),
(139, 78, 'XS', 10),
(140, 78, 'M', 10),
(141, 78, 'L', 10),
(142, 78, 'Freezie', 10),
(143, 79, 'XS', 10),
(144, 79, 'M', 10),
(145, 79, 'L', 10),
(146, 80, 'XS', 10),
(147, 80, 'M', 10),
(148, 80, 'L', 10),
(149, 81, 'XS', 10),
(150, 81, 'M', 10),
(151, 81, 'L', 10),
(152, 82, 'XS', 10),
(153, 82, 'M', 10),
(154, 82, 'L', 10),
(155, 83, 'XS', 10),
(156, 83, 'M', 10),
(157, 83, 'L', 10),
(158, 108, 'XS', 10),
(159, 108, 'M', 10),
(160, 108, 'L', 10),
(161, 109, 'XS', 10),
(162, 109, 'M', 10),
(163, 109, 'L', 10),
(164, 109, 'Freezie', 10),
(165, 111, 'M', 10),
(166, 111, 'L', 10),
(167, 111, 'Freezie', 10),
(168, 112, 'XS', 10),
(169, 112, 'M', 10),
(170, 112, 'L', 10),
(171, 113, 'XS', 10),
(172, 113, 'M', 10),
(173, 113, 'L', 10),
(174, 114, 'XS', 10),
(175, 114, 'M', 10),
(176, 114, 'L', 10),
(177, 115, 'XS', 10),
(178, 115, 'M', 10),
(179, 115, 'L', 10),
(180, 116, 'XS', 10),
(181, 116, 'M', 10),
(182, 116, 'L', 10),
(183, 117, 'XS', 10),
(184, 117, 'M', 10),
(185, 117, 'L', 10),
(186, 118, 'XS', 10),
(187, 118, 'M', 10),
(188, 118, 'L', 10),
(189, 119, 'Freezie', 10),
(190, 120, 'M', 10),
(191, 120, 'L', 10),
(192, 120, 'Freezie', 10),
(193, 121, 'M', 10),
(194, 121, 'L', 10),
(195, 121, 'Freezie', 10),
(196, 122, 'XS', 10),
(197, 122, 'M', 10),
(198, 122, 'L', 10),
(199, 123, 'XS', 10),
(200, 123, 'M', 10),
(201, 123, 'L', 10),
(202, 124, 'XS', 10),
(203, 124, 'M', 10),
(204, 124, 'L', 10),
(205, 124, 'Freezie', 10),
(206, 125, 'M', 10),
(207, 125, 'L', 10),
(208, 125, 'Freezie', 10),
(209, 126, 'XS', 10),
(210, 126, 'M', 10),
(211, 126, 'L', 10),
(212, 127, 'M', 10),
(213, 127, 'L', 10),
(214, 127, 'Freezie', 10),
(215, 128, 'XS', 10),
(216, 128, 'M', 10),
(217, 128, 'L', 10),
(218, 129, 'XS', 10),
(219, 129, 'M', 10),
(220, 129, 'L', 10),
(221, 130, 'XS', 10),
(222, 130, 'M', 10),
(223, 130, 'L', 10),
(224, 131, 'XS', 10),
(225, 131, 'M', 10),
(226, 131, 'L', 10),
(227, 132, 'XS', 10),
(228, 132, 'M', 10),
(229, 132, 'L', 10),
(230, 133, 'XS', 10),
(231, 133, 'M', 10),
(232, 133, 'L', 10),
(233, 134, 'XS', 10),
(234, 134, 'M', 10),
(235, 134, 'L', 10),
(236, 135, 'XS', 10),
(237, 135, 'M', 10),
(238, 135, 'L', 10),
(239, 136, 'XS', 10),
(240, 136, 'M', 10),
(241, 136, 'L', 10),
(242, 137, 'XS', 10),
(243, 137, 'M', 10),
(244, 137, 'L', 10),
(245, 138, 'XS', 10),
(246, 138, 'M', 10),
(247, 138, 'L', 10),
(248, 139, 'XS', 10),
(249, 139, 'M', 10),
(250, 139, 'L', 10),
(251, 338, 'XS', 10),
(252, 338, 'M', 10),
(253, 338, 'L', 10),
(254, 338, 'Freezie', 10),
(255, 339, 'XS', 10),
(256, 339, 'M', 10),
(257, 339, 'L', 10),
(258, 339, 'Freezie', 10),
(259, 340, 'XS', 10),
(260, 340, 'M', 10),
(261, 340, 'L', 10),
(262, 340, 'Freezie', 10),
(263, 341, 'XS', 10),
(264, 341, 'M', 10),
(265, 341, 'L', 10),
(266, 341, 'Freezie', 10),
(267, 342, 'XS', 10),
(268, 342, 'M', 10),
(269, 342, 'L', 10),
(270, 342, 'Freezie', 10),
(271, 343, 'XS', 10),
(272, 343, 'M', 10),
(273, 343, 'L', 10),
(274, 343, 'Freezie', 10),
(275, 344, 'XS', 10),
(276, 344, 'M', 10),
(277, 344, 'L', 10),
(278, 344, 'Freezie', 10),
(279, 345, 'XS', 10),
(280, 345, 'M', 10),
(281, 345, 'L', 10),
(282, 345, 'Freezie', 10),
(283, 346, 'XS', 10),
(284, 346, 'M', 10),
(285, 346, 'L', 10),
(286, 346, 'Freezie', 10),
(287, 347, 'XS', 10),
(288, 347, 'M', 10),
(289, 347, 'L', 10),
(290, 347, 'Freezie', 10),
(291, 348, 'XS', 10),
(292, 348, 'M', 10),
(293, 348, 'L', 10),
(294, 348, 'Freezie', 10),
(295, 349, 'XS', 10),
(296, 349, 'M', 10),
(297, 349, 'L', 10),
(298, 349, 'Freezie', 10),
(299, 350, 'XS', 10),
(300, 350, 'M', 10),
(301, 350, 'L', 10),
(302, 350, 'Freezie', 10),
(303, 351, 'XS', 10),
(304, 351, 'M', 10),
(305, 351, 'L', 10),
(306, 351, 'Freezie', 10),
(307, 352, 'XS', 10),
(308, 352, 'M', 10),
(309, 352, 'L', 10),
(310, 352, 'Freezie', 10),
(311, 353, 'XS', 10),
(312, 353, 'M', 10),
(313, 353, 'L', 10),
(314, 353, 'Freezie', 10),
(315, 354, 'XS', 10),
(316, 354, 'M', 10),
(317, 354, 'L', 10),
(318, 354, 'Freezie', 10),
(319, 355, 'XS', 10),
(320, 355, 'M', 10),
(321, 355, 'L', 10),
(322, 355, 'Freezie', 10),
(323, 356, 'XS', 10),
(324, 356, 'M', 10),
(325, 356, 'L', 10),
(326, 356, 'Freezie', 10),
(327, 357, 'XS', 10),
(328, 357, 'M', 10),
(329, 357, 'L', 10),
(330, 357, 'Freezie', 10),
(331, 358, 'XS', 10),
(332, 358, 'M', 10),
(333, 358, 'L', 10),
(334, 358, 'Freezie', 10),
(335, 359, 'XS', 10),
(336, 359, 'M', 10),
(337, 359, 'L', 10),
(338, 359, 'Freezie', 10),
(339, 360, 'XS', 10),
(340, 360, 'M', 10),
(341, 360, 'L', 10),
(342, 360, 'Freezie', 10),
(343, 361, 'XS', 10),
(344, 361, 'M', 10),
(345, 361, 'L', 10),
(346, 361, 'Freezie', 10),
(347, 362, 'XS', 10),
(348, 362, 'M', 10),
(349, 362, 'L', 10),
(350, 362, 'Freezie', 10),
(351, 363, 'XS', 10),
(352, 363, 'M', 10),
(353, 363, 'L', 10),
(354, 363, 'Freezie', 10),
(355, 364, 'XS', 10),
(356, 364, 'M', 10),
(357, 364, 'L', 10),
(358, 364, 'Freezie', 10),
(359, 365, 'XS', 10),
(360, 365, 'M', 10),
(361, 365, 'L', 10),
(362, 365, 'Freezie', 10),
(363, 366, 'XS', 10),
(364, 366, 'M', 10),
(365, 366, 'L', 10),
(366, 366, 'Freezie', 10),
(367, 367, 'XS', 10),
(368, 367, 'M', 10),
(369, 367, 'L', 10),
(370, 367, 'Freezie', 10),
(371, 368, 'XS', 10),
(372, 368, 'M', 10),
(373, 368, 'L', 10),
(374, 368, 'Freezie', 10),
(375, 369, 'XS', 10),
(376, 369, 'M', 10),
(377, 369, 'L', 10),
(378, 369, 'Freezie', 10),
(379, 370, 'XS', 10),
(380, 370, 'M', 10),
(381, 370, 'L', 10),
(382, 370, 'Freezie', 10),
(383, 371, 'XS', 10),
(384, 371, 'M', 10),
(385, 371, 'L', 10),
(386, 371, 'Freezie', 10),
(387, 372, 'XS', 10),
(388, 372, 'M', 10),
(389, 372, 'L', 10),
(390, 372, 'Freezie', 10),
(391, 373, 'XS', 10),
(392, 373, 'M', 10),
(393, 373, 'L', 10),
(394, 373, 'Freezie', 10),
(395, 374, 'XS', 10),
(396, 374, 'M', 10),
(397, 374, 'L', 10),
(398, 374, 'Freezie', 10),
(399, 375, 'XS', 10),
(400, 375, 'M', 10),
(401, 375, 'L', 10),
(402, 375, 'Freezie', 10),
(403, 376, 'XS', 10),
(404, 376, 'M', 10),
(405, 376, 'L', 10),
(406, 376, 'Freezie', 10),
(407, 377, 'XS', 10),
(408, 377, 'M', 10),
(409, 377, 'L', 10),
(410, 377, 'Freezie', 10),
(411, 378, 'XS', 10),
(412, 378, 'M', 10),
(413, 378, 'L', 10),
(414, 378, 'Freezie', 10),
(415, 379, 'XS', 10),
(416, 379, 'M', 10),
(417, 379, 'L', 10),
(418, 379, 'Freezie', 10),
(419, 380, 'XS', 10),
(420, 380, 'M', 10),
(421, 380, 'L', 10),
(422, 380, 'Freezie', 10),
(423, 381, 'XS', 10),
(424, 381, 'M', 10),
(425, 381, 'L', 10),
(426, 381, 'Freezie', 10),
(427, 382, 'XS', 10),
(428, 382, 'M', 10),
(429, 382, 'L', 10),
(430, 382, 'Freezie', 10),
(431, 383, 'XS', 10),
(432, 383, 'M', 10),
(433, 383, 'L', 10),
(434, 383, 'Freezie', 10),
(435, 384, 'XS', 10),
(436, 384, 'M', 10),
(437, 384, 'L', 10),
(438, 384, 'Freezie', 10),
(439, 385, 'XS', 10),
(440, 385, 'M', 10),
(441, 385, 'L', 10),
(442, 385, 'Freezie', 10),
(443, 386, 'XS', 10),
(444, 386, 'M', 10),
(445, 386, 'L', 10),
(446, 386, 'Freezie', 10),
(45905, 387, 'XS', 10),
(45906, 387, 'M', 0),
(45907, 387, 'L', 10),
(45908, 387, 'Freezie', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_psw` varchar(32) NOT NULL,
  `role` varchar(5) NOT NULL DEFAULT 'user',
  `user_avatar` varchar(255) NOT NULL DEFAULT '',
  `user_birthday` date DEFAULT NULL,
  `user_gender` varchar(20) NOT NULL DEFAULT '',
  `user_phone` varchar(20) NOT NULL DEFAULT '',
  `user_address` varchar(255) NOT NULL DEFAULT '',
  `user_contact_email` varchar(255) NOT NULL DEFAULT '',
  `user_website` varchar(255) NOT NULL DEFAULT '',
  `user_role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_psw`, `role`, `user_avatar`, `user_birthday`, `user_gender`, `user_phone`, `user_address`, `user_contact_email`, `user_website`, `user_role`) VALUES
(2, 'admin', 'admin@gmail.com', '1', 'admin', '', NULL, 'male', '', '', '', '', 'admin'),
(3, 'Trần Văn B', 'tvb@gmail.com', '123456789', 'user', '', NULL, '', '', '', '', '', 'user'),
(5, 'Lê Thị C ', 'ltc123@gmail.com', '123456789', 'user', '', NULL, '', '', '', '', '', 'user'),
(6, 'Huỳnh Quãng Anh Thư', 'thu@gmail.com', '123456789', 'user', '', NULL, '', '', '', '', '', 'user'),
(7, 'Thư Thư ', 'thuthu@gmaill.com', '12345678', 'user', '', NULL, '', '', '', '', '', 'user'),
(8, 'thu', 'thu123@gmail.com', 'thu12345', 'user', 'avatar-8-69bada2900619266510270.jpg', NULL, '', '', '', '', '', 'user'),
(12, 'Nguyễn Văn D', 'd@gmail.com', '123456789', 'user', '', '2026-03-18', 'male', '0987123456	', 'Cần Thơ', '', '', 'user'),
(13, 'Nguyễn Thị Bé Lan', 'lan@gmail.com', '123456', 'user', '', '0000-00-00', 'female', '0987123456	', 'Sóc Trăng', '', '', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`user_id`,`pd_id`,`pd_size`),
  ADD KEY `pd_id` (`pd_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`,`order_code`),
  ADD KEY `pd_id` (`pd_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pd_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Chỉ mục cho bảng `product_size_stock`
--
ALTER TABLE `product_size_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD UNIQUE KEY `uniq_pd_size` (`pd_id`,`size_code`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `pd_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=388;

--
-- AUTO_INCREMENT cho bảng `product_size_stock`
--
ALTER TABLE `product_size_stock`
  MODIFY `stock_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57609;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`pd_id`) REFERENCES `products` (`pd_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`pd_id`) REFERENCES `products` (`pd_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);

--
-- Các ràng buộc cho bảng `product_size_stock`
--
ALTER TABLE `product_size_stock`
  ADD CONSTRAINT `fk_stock_product` FOREIGN KEY (`pd_id`) REFERENCES `products` (`pd_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
