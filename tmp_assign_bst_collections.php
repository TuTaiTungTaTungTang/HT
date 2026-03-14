<?php
require __DIR__ . '/src/bootstrap.php';

$pdo = $PDO;

try {
    $columnExists = (int) $pdo->query("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'pd_collection'")->fetchColumn() > 0;

    if (!$columnExists) {
        $pdo->exec("ALTER TABLE products ADD COLUMN pd_collection VARCHAR(50) NOT NULL DEFAULT '' AFTER pd_sizes");
    }

    $bstProducts = [
        // CLAIR DE SPRING — ảnh mới bst-cds-*.jpg
        ['pd_name' => 'Ao Organza Som Mai', 'pd_price' => 365000, 'pd_info' => 'Ao organza tay phong, tong mau nhe va de phoi do cho nhung set do mua xuan.', 'pd_image' => 'bst-cds-1.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'clair-de-spring'],
        ['pd_name' => 'Yem Lua Anh Dao', 'pd_price' => 425000, 'pd_info' => 'Yem dang dai mem rui, hop cho nhung outfit thanh lich va ngot ngao.', 'pd_image' => 'bst-cds-2.jpg', 'cat_id' => 5, 'pd_sizes' => 'XS,M,L,Freezie', 'pd_collection' => 'clair-de-spring'],
        ['pd_name' => 'Chan vay Voan Ban Mai', 'pd_price' => 345000, 'pd_info' => 'Chan vay voan bay nhe, tao cam giac trong treo va nu tinh.', 'pd_image' => 'bst-cds-3.jpg', 'cat_id' => 8, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'clair-de-spring'],
        ['pd_name' => 'Ao Len Mint Garden', 'pd_price' => 395000, 'pd_info' => 'Ao len mong tong pastel, phu hop nhung bo suu tap diu dang va tre trung.', 'pd_image' => 'bst-cds-4.jpg', 'cat_id' => 1, 'pd_sizes' => 'M,L,Freezie', 'pd_collection' => 'clair-de-spring'],

        // XUAN NHIEN — ảnh mới bst-xn-*.jpg
        ['pd_name' => 'Ao Yem Xuan Hoa', 'pd_price' => 335000, 'pd_info' => 'Ao yem phoi not no xinh xan, tone mau nhe nhu khong khi tet dau nam.', 'pd_image' => 'bst-xn-1.jpg', 'cat_id' => 5, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'xuan-nhien'],
        ['pd_name' => 'Dam Lua Thien Thanh', 'pd_price' => 520000, 'pd_info' => 'Dam lua mem voi tong xanh trong, mang cam giac nhe nhang va thanh thoat.', 'pd_image' => 'bst-xn-2.jpg', 'cat_id' => 4, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'xuan-nhien'],
        ['pd_name' => 'Ao Croptop Dao Hong', 'pd_price' => 285000, 'pd_info' => 'Croptop xep ly nhe, gam hong phan diu mat cho mua le hoi dau nam.', 'pd_image' => 'bst-xn-3.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'xuan-nhien'],
        ['pd_name' => 'Chan vay Xep Ly Nhu Y', 'pd_price' => 355000, 'pd_info' => 'Chan vay xep ly de di chuc tet, de phoi voi nhieu kieu ao.', 'pd_image' => 'bst-xn-4.jpg', 'cat_id' => 8, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'xuan-nhien'],

        // NIGHT OUT — ảnh mới bst-no-*.jpg
        ['pd_name' => 'Dam Sat Scarlet Muse', 'pd_price' => 545000, 'pd_info' => 'Dam sat om dang ton form, hop cho nhung buoi hen toi va su kien nho.', 'pd_image' => 'bst-no-1.jpg', 'cat_id' => 4, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'night-out'],
        ['pd_name' => 'Ao Corset Velvet Glow', 'pd_price' => 395000, 'pd_info' => 'Ao corset nhan eo, tao diem nhan manh me cho set do night out.', 'pd_image' => 'bst-no-2.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'night-out'],
        ['pd_name' => 'Chan vay Mini Noir', 'pd_price' => 315000, 'pd_info' => 'Chan vay mini tong toi, phoi cung boots va ao om rat hop.', 'pd_image' => 'bst-no-3.jpg', 'cat_id' => 8, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'night-out'],
        ['pd_name' => 'Tui Mini Rouge', 'pd_price' => 265000, 'pd_info' => 'Tui mini de tiec nho, kich thuoc gon nhe nhung van noi bat.', 'pd_image' => 'bst-no-4.jpg', 'cat_id' => 3, 'pd_sizes' => 'Freezie', 'pd_collection' => 'night-out'],

        // CITY HOURS — ảnh mới bst-ch-*.jpg
        ['pd_name' => 'Ao So Mi Office Muse', 'pd_price' => 325000, 'pd_info' => 'Ao so mi thanh lich danh cho ngay di lam, de phoi voi quan ong suong.', 'pd_image' => 'bst-ch-1.jpg', 'cat_id' => 1, 'pd_sizes' => 'M,L,Freezie', 'pd_collection' => 'city-hours'],
        ['pd_name' => 'Ao Cardigan Midtown', 'pd_price' => 375000, 'pd_info' => 'Cardigan mong khoac ngoai, hoan thien set do cong so gon gang.', 'pd_image' => 'bst-ch-2.jpg', 'cat_id' => 1, 'pd_sizes' => 'M,L,Freezie', 'pd_collection' => 'city-hours'],
        ['pd_name' => 'Quan Ong Suong Skyline', 'pd_price' => 410000, 'pd_info' => 'Quan ong suong dang dai, mac len dep va tao cam giac chuyen nghiep.', 'pd_image' => 'bst-ch-3.jpg', 'cat_id' => 7, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'city-hours'],
        ['pd_name' => 'Chan vay But Chi Metro', 'pd_price' => 365000, 'pd_info' => 'Chan vay but chi cho set do lam viec, ton dang va de di chuyen.', 'pd_image' => 'bst-ch-4.jpg', 'cat_id' => 8, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'city-hours'],

        // CLASSMATE NOTES — ảnh mới bst-cn-*.jpg
        ['pd_name' => 'Ao Thun Campus Chill', 'pd_price' => 225000, 'pd_info' => 'Ao thun tre trung phu hop di hoc va di choi hang ngay.', 'pd_image' => 'bst-cn-1.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L,Freezie', 'pd_collection' => 'classmate-notes'],
        ['pd_name' => 'Hoodie Locker Room', 'pd_price' => 435000, 'pd_info' => 'Hoodie phong cach hoc duong, mac cung short hoac jean deu hop.', 'pd_image' => 'bst-cn-2.jpg', 'cat_id' => 1, 'pd_sizes' => 'M,L,Freezie', 'pd_collection' => 'classmate-notes'],
        ['pd_name' => 'Quan Short Notebook', 'pd_price' => 275000, 'pd_info' => 'Quan short dang rong, nang dong cho nhung ngay den truong.', 'pd_image' => 'bst-cn-3.jpg', 'cat_id' => 6, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'classmate-notes'],
        ['pd_name' => 'Bomber Hallway', 'pd_price' => 455000, 'pd_info' => 'Khoac bomber ca tinh, tao diem nhan cho set do hoc duong.', 'pd_image' => 'bst-cn-4.jpg', 'cat_id' => 1, 'pd_sizes' => 'M,L,Freezie', 'pd_collection' => 'classmate-notes'],

        // AFTER CLASS — ảnh mới bst-ac-*.jpg
        ['pd_name' => 'Ao Polo Active Bloom', 'pd_price' => 255000, 'pd_info' => 'Ao polo co gian nhe, phu hop nhung ngay hoat dong sau gio hoc.', 'pd_image' => 'bst-ac-1.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'after-class'],
        ['pd_name' => 'Quan Jogger Motion', 'pd_price' => 335000, 'pd_info' => 'Jogger mem va gon, de mac trong luc di choi hay tap nhe.', 'pd_image' => 'bst-ac-2.jpg', 'cat_id' => 2, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'after-class'],
        ['pd_name' => 'Ao Dry Fit Breeze', 'pd_price' => 295000, 'pd_info' => 'Ao dry fit thoang, phu hop nhung buoi van dong cuoi ngay.', 'pd_image' => 'bst-ac-3.jpg', 'cat_id' => 1, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'after-class'],
        ['pd_name' => 'Legging Studio Ease', 'pd_price' => 310000, 'pd_info' => 'Legging co gian 4 chieu, de phoi cung ao ngan va hoodie.', 'pd_image' => 'bst-ac-4.jpg', 'cat_id' => 2, 'pd_sizes' => 'XS,M,L', 'pd_collection' => 'after-class'],
    ];

    $deleteStmt = $pdo->prepare("DELETE FROM products WHERE pd_name = :pd_name");
    foreach ($bstProducts as $bstProduct) {
        $deleteStmt->execute([':pd_name' => $bstProduct['pd_name']]);
    }

    $insertStmt = $pdo->prepare(
        "INSERT INTO products (pd_name, pd_price, pd_info, pd_image, cat_id, pd_sizes, pd_collection)
         VALUES (:pd_name, :pd_price, :pd_info, :pd_image, :cat_id, :pd_sizes, :pd_collection)"
    );

    foreach ($bstProducts as $bstProduct) {
        $insertStmt->execute($bstProduct);
    }

    echo "BST fresh seed data inserted.\n";
    $rows = $pdo->query("SELECT pd_collection, COUNT(*) AS total FROM products WHERE pd_collection <> '' GROUP BY pd_collection ORDER BY pd_collection")->fetchAll();
    foreach ($rows as $row) {
        echo $row['pd_collection'] . ': ' . $row['total'] . "\n";
    }
} catch (Throwable $e) {
    echo 'BST assignment failed: ' . $e->getMessage() . "\n";
    exit(1);
}
