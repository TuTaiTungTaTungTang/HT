-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 18, 2026 lúc 07:51 AM
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
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `pd_id` int(11) UNSIGNED NOT NULL,
  `pd_quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`user_id`, `pd_id`, `pd_quantity`) VALUES
(6, 19, 1),
(7, 12, 1);

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
  `pd_quantity` int(6) NOT NULL,
  `order_total` int(12) NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `user_id`, `address`, `phone`, `pd_id`, `pd_quantity`, `order_total`, `order_status`) VALUES
(31, 2396, 6, 'Cần Thơ', '0939554486', 11, 1, 135000, 1),
(32, 3678, 6, 'adfadsfasdfasd', '0988554455', 118, 3, 945000, 1),
(33, 8599, 6, 'fasdfsdafasd', '0988997788', 137, 1, 225000, 1),
(34, 7896, 8, 'Cần Thơ', '0988775544', 114, 1, 285000, 0);

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
(1, 'Áo thun cotton trắng basic', '149000', 'Áo thun cotton mềm, thoáng mát, phù hợp mặc hằng ngày.', 'ao-thun-trang.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(2, 'Áo sơ mi nam Oxford xanh navy', '285000', 'Áo sơ mi lịch sự, chất vải dày dặn, phù hợp đi làm.', 'ao-so-mi-oxford-navy.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(3, 'Áo khoác bomber unisex', '420000', 'Áo khoác bomber trẻ trung, có túi hông và khóa kéo bền.', 'ao-khoac-bomber.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(4, 'Áo hoodie nỉ ngoại', '375000', 'Hoodie nỉ dày dặn, giữ ấm tốt, form rộng dễ phối đồ.', 'ao-hoodie-ni.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(5, 'Áo polo nam cao cấp', '195000', 'Áo polo vải cá sấu, thiết kế đơn giản, dễ mặc.', 'ao-polo-nam.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(6, 'Áo khoác jean washed', '465000', 'Áo khoác jean phong cách, bền đẹp và dễ phối trang phục.', 'ao-khoac-jean.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(7, 'Áo polo nữ tay ngắn', '165000', 'Áo polo nữ dáng suông, chất liệu mềm, thoải mái vận động.', 'ao-polo-nu.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(8, 'Bộ đồ mặc nhà cotton', '295000', 'Bộ đồ mặc nhà thoáng mát, dễ chịu, phù hợp mặc hằng ngày.', 'bo-do-mac-nha.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(9, 'Áo thể thao nữ dry-fit', '189000', 'Áo thể thao nữ thoát ẩm nhanh, co giãn tốt khi tập luyện.', 'ao-the-thao-nu.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(10, 'Áo sơ mi nữ trắng công sở', '245000', 'Áo sơ mi nữ thanh lịch, dễ phối với quần tây hoặc chân váy.', 'ao-so-mi-nu-trang.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(11, 'Áo thun nam cổ tim', '135000', 'Áo thun cổ tim trẻ trung, chất vải mềm và dễ giặt.', 'ao-thun-co-tim.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(12, 'Áo giữ nhiệt nam nữ', '175000', 'Áo giữ nhiệt mỏng nhẹ, giữ ấm tốt cho ngày lạnh.', 'ao-giu-nhiet.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(13, 'Áo cardigan len mỏng', '259000', 'Áo cardigan len mỏng, mặc khoác ngoài lịch sự và gọn gàng.', 'ao-cardigan-len.jpg', 1, 0, 'XS,M,L,Freezie', ''),
(14, 'Quần jean nữ skinny', '385000', 'Quần jean nữ co giãn nhẹ, ôm dáng vừa vặn.', 'quan-jean-nu-skinny.jpg', 2, 0, 'XS,M,L', ''),
(15, 'Quần short kaki nam', '245000', 'Quần short kaki thoáng mát, phù hợp đi chơi và dạo phố.', 'quan-short-kaki.jpg', 6, 0, 'XS,M,L', ''),
(16, 'Quần jogger thể thao', '295000', 'Quần jogger bo ống gọn, chất vải nhẹ và dễ vận động.', 'quan-jogger.jpg', 2, 0, 'XS,M,L', ''),
(17, 'Quần tây nam slimfit', '425000', 'Quần tây nam form slimfit, lịch sự cho môi trường công sở.', 'quan-tay-nam.jpg', 2, 0, 'XS,M,L', ''),
(18, 'Quần jean nam baggy', '395000', 'Quần jean nam ống rộng, phong cách streetwear hiện đại.', 'quan-jean-baggy.jpg', 7, 0, 'XS,M,L,Freezie', ''),
(19, 'Quần legging nữ gym', '185000', 'Quần legging nữ co giãn 4 chiều, phù hợp tập gym hoặc yoga.', 'quan-legging.jpg', 2, 0, 'XS,M,L', ''),
(20, 'Quần culottes nữ linen', '335000', 'Quần culottes ống rộng, chất linen mát, dáng đẹp.', 'quan-culottes.jpg', 7, 0, 'XS,M,L,Freezie', ''),
(21, 'Quần nỉ nam nữ', '275000', 'Quần nỉ mềm ấm, mặc nhà hoặc đi chơi đều phù hợp.', 'quan-ni.jpg', 2, 0, 'XS,M,L', ''),
(22, 'Quần short jean nữ', '265000', 'Quần short jean nữ trẻ trung, dễ phối với áo thun.', 'quan-short-jean.jpg', 6, 0, 'XS,M,L', ''),
(23, 'Quần kaki nữ ống suông', '355000', 'Quần kaki nữ ống suông, thanh lịch cho môi trường công sở.', 'quan-kaki-nu.jpg', 7, 0, 'XS,M,L,Freezie', ''),
(24, 'Quần short thể thao nam', '195000', 'Quần short thể thao nhẹ, nhanh khô và thoáng khí.', 'quan-short-the-thao.jpg', 6, 0, 'XS,M,L', ''),
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
(108, 'Ao Organza Som Mai', '365000', 'Ao organza tay phong, tong mau nhe va de phoi do cho nhung set do mua xuan.', 'bst-cds-1.jpg', 1, 0, 'XS,M,L', 'clair-de-spring'),
(109, 'Yem Lua Anh Dao', '425000', 'Yem dang dai mem rui, hop cho nhung outfit thanh lich va ngot ngao.', 'bst-cds-2.jpg', 5, 0, 'XS,M,L,Freezie', 'clair-de-spring'),
(110, 'Chan vay Voan Ban Mai', '345000', 'Chan vay voan bay nhe, tao cam giac trong treo va nu tinh.', 'bst-cds-3.jpg', 8, 0, 'XS,M,L', 'clair-de-spring'),
(111, 'Ao Len Mint Garden', '395000', 'Ao len mong tong pastel, phu hop nhung bo suu tap diu dang va tre trung.', 'bst-cds-4.jpg', 1, 0, 'M,L,Freezie', 'clair-de-spring'),
(112, 'Ao Yem Xuan Hoa', '335000', 'Ao yem phoi not no xinh xan, tone mau nhe nhu khong khi tet dau nam.', 'bst-xn-1.jpg', 5, 0, 'XS,M,L', 'xuan-nhien'),
(113, 'Dam Lua Thien Thanh', '520000', 'Dam lua mem voi tong xanh trong, mang cam giac nhe nhang va thanh thoat.', 'bst-xn-2.jpg', 4, 0, 'XS,M,L', 'xuan-nhien'),
(114, 'Ao Croptop Dao Hong', '285000', 'Croptop xep ly nhe, gam hong phan diu mat cho mua le hoi dau nam.', 'bst-xn-3.jpg', 1, 0, 'XS,M,L', 'xuan-nhien'),
(115, 'Chan vay Xep Ly Nhu Y', '355000', 'Chan vay xep ly de di chuc tet, de phoi voi nhieu kieu ao.', 'bst-xn-4.jpg', 8, 0, 'XS,M,L', 'xuan-nhien'),
(116, 'Dam Sat Scarlet Muse', '545000', 'Dam sat om dang ton form, hop cho nhung buoi hen toi va su kien nho.', 'bst-no-1.jpg', 4, 0, 'XS,M,L', 'night-out'),
(117, 'Ao Corset Velvet Glow', '395000', 'Ao corset nhan eo, tao diem nhan manh me cho set do night out.', 'bst-no-2.jpg', 1, 0, 'XS,M,L', 'night-out'),
(118, 'Chan vay Mini Noir', '315000', 'Chan vay mini tong toi, phoi cung boots va ao om rat hop.', 'bst-no-3.jpg', 8, 0, 'XS,M,L', 'night-out'),
(119, 'Tui Mini Rouge', '265000', 'Tui mini de tiec nho, kich thuoc gon nhe nhung van noi bat.', 'bst-no-4.jpg', 3, 0, 'Freezie', 'night-out'),
(120, 'Ao So Mi Office Muse', '325000', 'Ao so mi thanh lich danh cho ngay di lam, de phoi voi quan ong suong.', 'bst-ch-1.jpg', 1, 0, 'M,L,Freezie', 'city-hours'),
(121, 'Ao Cardigan Midtown', '375000', 'Cardigan mong khoac ngoai, hoan thien set do cong so gon gang.', 'bst-ch-2.jpg', 1, 0, 'M,L,Freezie', 'city-hours'),
(122, 'Quan Ong Suong Skyline', '410000', 'Quan ong suong dang dai, mac len dep va tao cam giac chuyen nghiep.', 'bst-ch-3.jpg', 7, 0, 'XS,M,L', 'city-hours'),
(123, 'Chan vay But Chi Metro', '365000', 'Chan vay but chi cho set do lam viec, ton dang va de di chuyen.', 'bst-ch-4.jpg', 8, 0, 'XS,M,L', 'city-hours'),
(124, 'Ao Thun Campus Chill', '225000', 'Ao thun tre trung phu hop di hoc va di choi hang ngay.', 'bst-cn-1.jpg', 1, 0, 'XS,M,L,Freezie', 'classmate-notes'),
(125, 'Hoodie Locker Room', '435000', 'Hoodie phong cach hoc duong, mac cung short hoac jean deu hop.', 'bst-cn-2.jpg', 1, 0, 'M,L,Freezie', 'classmate-notes'),
(126, 'Quan Short Notebook', '275000', 'Quan short dang rong, nang dong cho nhung ngay den truong.', 'bst-cn-3.jpg', 6, 0, 'XS,M,L', 'classmate-notes'),
(127, 'Bomber Hallway', '455000', 'Khoac bomber ca tinh, tao diem nhan cho set do hoc duong.', 'bst-cn-4.jpg', 1, 0, 'M,L,Freezie', 'classmate-notes'),
(128, 'Ao Polo Active Bloom', '255000', 'Ao polo co gian nhe, phu hop nhung ngay hoat dong sau gio hoc.', 'bst-ac-1.jpg', 1, 0, 'XS,M,L', 'after-class'),
(129, 'Quan Jogger Motion', '335000', 'Jogger mem va gon, de mac trong luc di choi hay tap nhe.', 'bst-ac-2.jpg', 2, 0, 'XS,M,L', 'after-class'),
(130, 'Ao Dry Fit Breeze', '295000', 'Ao dry fit thoang, phu hop nhung buoi van dong cuoi ngay.', 'bst-ac-3.jpg', 1, 0, 'XS,M,L', 'after-class'),
(131, 'Legging Studio Ease', '310000', 'Legging co gian 4 chieu, de phoi cung ao ngan va hoodie.', 'bst-ac-4.jpg', 2, 0, 'XS,M,L', 'after-class'),
(132, 'Ao Linen Drift', '215000', 'Ao linen mong nhe, hop outfit he toi gian.', 'fs-1.jpg', 1, 0, 'XS,M,L', 'flash-sale'),
(133, 'Dam Misty Blue', '275000', 'Dam xanh nhat, dang suong de mac hang ngay.', 'fs-2.jpg', 4, 0, 'XS,M,L', 'flash-sale'),
(134, 'Yem Soft Tide', '245000', 'Yem dang dai, chat lieu mem va thoang.', 'fs-3.jpg', 5, 0, 'XS,M,L', 'flash-sale'),
(135, 'Quan Chill Fit', '235000', 'Quan form rong nhe, de phoi ao co ban.', 'fs-4.jpg', 7, 0, 'XS,M,L', 'flash-sale'),
(136, 'Ao Crop Whisper', '199000', 'Ao crop co gian nhe, tong mau trung tinh.', 'fs-5.jpg', 1, 0, 'XS,M,L', 'flash-sale'),
(137, 'Chan Vay Breeze', '225000', 'Chan vay bay nhe, duong cat thanh lich.', 'fs-6.jpg', 8, 0, 'XS,M,L', 'flash-sale'),
(138, 'Ao Polo Dawn', '205000', 'Ao polo daily wear, form gon de mac.', 'fs-7.jpg', 1, 0, 'XS,M,L', 'flash-sale'),
(139, 'Dam Ribbon Light', '289000', 'Dam co diem nhan no nho, phong cach nu tinh.', 'fs-8.jpg', 4, 0, 'XS,M,L', 'flash-sale');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_psw` varchar(32) NOT NULL,
  `role` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_psw`, `role`) VALUES
(1, 'Nguyễn Văn A', 'nva@gmail.com', '123456789', 'user'),
(2, 'admin', 'admin@gmail.com', '1', 'admin'),
(3, 'Trần Văn B', 'tvb@gmail.com', '123456789', 'user'),
(5, 'Lê Thị C ', 'ltc123@gmail.com', '123456789', 'user'),
(6, 'Huỳnh Quãng Anh Thư', 'thu@gmail.com', '123456789', 'user'),
(7, 'Thư Thư ', 'thuthu@gmaill.com', '12345678', 'user'),
(8, 'thu', 'thu123@gmail.com', 'thu12345', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`user_id`,`pd_id`),
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
  MODIFY `pd_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
