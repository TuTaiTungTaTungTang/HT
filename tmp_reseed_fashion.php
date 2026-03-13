<?php
require __DIR__ . '/src/bootstrap.php';

$PDO->beginTransaction();

try {
    $PDO->exec('SET FOREIGN_KEY_CHECKS = 0');
    $PDO->exec('DELETE FROM carts');
    $PDO->exec('DELETE FROM orders');
    $PDO->exec('DELETE FROM products');
    $PDO->exec('DELETE FROM categories');
    $PDO->exec('SET FOREIGN_KEY_CHECKS = 1');

    $PDO->exec("INSERT INTO categories (cat_id, cat_name) VALUES
        (1, 'Áo'),
        (2, 'Quần'),
        (3, 'Phụ kiện')");

    $PDO->exec("INSERT INTO products (pd_id, pd_name, pd_price, pd_info, pd_image, cat_id) VALUES
        (1, 'Áo thun cotton trắng basic', '149000', 'Áo thun cotton mềm, thoáng mát, phù hợp mặc hằng ngày.', 'ao-thun-trang.jpg', 1),
        (2, 'Áo sơ mi nam Oxford xanh navy', '285000', 'Áo sơ mi lịch sự, chất vải dày dặn, phù hợp đi làm.', 'ao-so-mi-oxford-navy.jpg', 1),
        (3, 'Áo khoác bomber unisex', '420000', 'Áo khoác bomber trẻ trung, có túi hông và khóa kéo bền.', 'ao-khoac-bomber.jpg', 1),
        (4, 'Áo hoodie nỉ ngoại', '375000', 'Hoodie nỉ dày dặn, giữ ấm tốt, form rộng dễ phối đồ.', 'ao-hoodie-ni.jpg', 1),
        (5, 'Áo polo nam cao cấp', '195000', 'Áo polo vải cá sấu, thiết kế đơn giản, dễ mặc.', 'ao-polo-nam.jpg', 1),
        (6, 'Áo khoác jean washed', '465000', 'Áo khoác jean phong cách, bền đẹp và dễ phối trang phục.', 'ao-khoac-jean.jpg', 1),
        (7, 'Áo polo nữ tay ngắn', '165000', 'Áo polo nữ dáng suông, chất liệu mềm, thoải mái vận động.', 'ao-polo-nu.jpg', 1),
        (8, 'Bộ đồ mặc nhà cotton', '295000', 'Bộ đồ mặc nhà thoáng mát, dễ chịu, phù hợp mặc hằng ngày.', 'bo-do-mac-nha.jpg', 1),
        (9, 'Áo thể thao nữ dry-fit', '189000', 'Áo thể thao nữ thoát ẩm nhanh, co giãn tốt khi tập luyện.', 'ao-the-thao-nu.jpg', 1),
        (10, 'Áo sơ mi nữ trắng công sở', '245000', 'Áo sơ mi nữ thanh lịch, dễ phối với quần tây hoặc chân váy.', 'ao-so-mi-nu-trang.jpg', 1),
        (11, 'Áo thun nam cổ tim', '135000', 'Áo thun cổ tim trẻ trung, chất vải mềm và dễ giặt.', 'ao-thun-co-tim.jpg', 1),
        (12, 'Áo giữ nhiệt nam nữ', '175000', 'Áo giữ nhiệt mỏng nhẹ, giữ ấm tốt cho ngày lạnh.', 'ao-giu-nhiet.jpg', 1),
        (13, 'Áo cardigan len mỏng', '259000', 'Áo cardigan len mỏng, mặc khoác ngoài lịch sự và gọn gàng.', 'ao-cardigan-len.jpg', 1),
        (14, 'Quần jean nữ skinny', '385000', 'Quần jean nữ co giãn nhẹ, ôm dáng vừa vặn.', 'quan-jean-nu-skinny.jpg', 2),
        (15, 'Quần short kaki nam', '245000', 'Quần short kaki thoáng mát, phù hợp đi chơi và dạo phố.', 'quan-short-kaki.jpg', 2),
        (16, 'Quần jogger thể thao', '295000', 'Quần jogger bo ống gọn, chất vải nhẹ và dễ vận động.', 'quan-jogger.jpg', 2),
        (17, 'Quần tây nam slimfit', '425000', 'Quần tây nam form slimfit, lịch sự cho môi trường công sở.', 'quan-tay-nam.jpg', 2),
        (18, 'Quần jean nam baggy', '395000', 'Quần jean nam ống rộng, phong cách streetwear hiện đại.', 'quan-jean-baggy.jpg', 2),
        (19, 'Quần legging nữ gym', '185000', 'Quần legging nữ co giãn 4 chiều, phù hợp tập gym hoặc yoga.', 'quan-legging.jpg', 2),
        (20, 'Quần culottes nữ linen', '335000', 'Quần culottes ống rộng, chất linen mát, dáng đẹp.', 'quan-culottes.jpg', 2),
        (21, 'Quần nỉ nam nữ', '275000', 'Quần nỉ mềm ấm, mặc nhà hoặc đi chơi đều phù hợp.', 'quan-ni.jpg', 2),
        (22, 'Quần short jean nữ', '265000', 'Quần short jean nữ trẻ trung, dễ phối với áo thun.', 'quan-short-jean.jpg', 2),
        (23, 'Quần kaki nữ ống suông', '355000', 'Quần kaki nữ ống suông, thanh lịch cho môi trường công sở.', 'quan-kaki-nu.jpg', 2),
        (24, 'Quần short thể thao nam', '195000', 'Quần short thể thao nhẹ, nhanh khô và thoáng khí.', 'quan-short-the-thao.jpg', 2),
        (25, 'Quần dài nữ vải tuyết mưa', '315000', 'Quần dài nữ vải đẹp, ít nhăn, dễ bảo quản.', 'quan-dai-nu.jpg', 2),
        (26, 'Quần jean nam slim fit', '385000', 'Quần jean nam slim fit dễ mặc, dễ kết hợp trang phục.', 'quan-jean-nam-slim.jpg', 2),
        (27, 'Quần baggy nữ kaki', '295000', 'Quần baggy nữ phong cách Hàn Quốc, mặc thoải mái.', 'quan-baggy-nu.jpg', 2),
        (28, 'Quần thể thao nữ dài', '235000', 'Quần thể thao nữ co giãn, phù hợp tập luyện hằng ngày.', 'quan-the-thao-nu.jpg', 2),
        (29, 'Túi tote canvas', '125000', 'Túi tote vải canvas bền đẹp, đựng được nhiều vật dụng.', 'tui-tote-canvas.jpg', 3),
        (30, 'Mũ lưỡi trai unisex', '89000', 'Mũ lưỡi trai đơn giản, dễ đội, dễ phối đồ.', 'mu-luoi-trai.jpg', 3),
        (31, 'Balo laptop 15.6 inch', '425000', 'Balo chống nước nhẹ, có ngăn riêng cho laptop.', 'balo-laptop.jpg', 3),
        (32, 'Dây nịt da nam', '185000', 'Dây nịt da khóa tự động, phù hợp đi làm và sự kiện.', 'day-nit-da.jpg', 3),
        (33, 'Vớ cổ cao thể thao', '85000', 'Bộ vớ cổ cao mềm, thoáng, dùng cho sinh hoạt hằng ngày.', 'vo-co-cao.jpg', 3),
        (34, 'Khăn choàng cổ len', '145000', 'Khăn len mềm, giữ ấm tốt trong thời tiết lạnh.', 'khan-choang-len.jpg', 3),
        (35, 'Túi xách nữ da PU', '385000', 'Túi xách nữ kích thước vừa, tiện dụng khi đi làm.', 'tui-xach-nu.jpg', 3),
        (36, 'Mũ len beanie', '75000', 'Mũ len beanie đơn giản, giữ ấm và dễ phối trang phục.', 'mu-beanie.jpg', 3),
        (37, 'Balo mini nữ', '255000', 'Balo mini nữ nhỏ gọn, phù hợp đi chơi hoặc dạo phố.', 'balo-mini-nu.jpg', 3),
        (38, 'Mũ bucket 2 mặt', '95000', 'Mũ bucket 2 mặt tiện dụng, che nắng tốt.', 'mu-bucket.jpg', 3),
        (39, 'Kính mát chống UV', '175000', 'Kính mát thời trang chống tia UV, bảo vệ mắt.', 'kinh-mat.jpg', 3),
        (40, 'Túi đeo chéo vải dù', '145000', 'Túi đeo chéo nhỏ gọn, chất liệu vải dù chống nước nhẹ.', 'tui-deo-cheo.jpg', 3)");

    $PDO->commit();
    echo "Reseed completed." . PHP_EOL;
} catch (Throwable $e) {
    $PDO->rollBack();
    echo "Reseed failed: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
