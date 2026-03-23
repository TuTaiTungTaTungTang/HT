
# Online Store (PHP + MySQL)

Website bán hàng thời trang viết bằng PHP thuần, dùng MySQL/MariaDB và chạy tốt với XAMPP trên Windows.

## 1. Tính năng chính

- Xem danh sách sản phẩm, chi tiết sản phẩm, tìm kiếm, lọc theo danh mục/collection.
- Giỏ hàng và đặt hàng theo size (`XS`, `M`, `L`, `Freezie`).
- Theo dõi đơn hàng theo trạng thái.
- Quản trị viên quản lý danh mục, sản phẩm, người dùng, đơn hàng.
- Quản lý tồn kho theo size qua bảng `product_size_stock`.

## 2. Công nghệ sử dụng

- PHP 8.x (PDO)
- MySQL/MariaDB
- Bootstrap + CSS/JS thuần
- Autoload theo PSR-4 (file `libraries/Psr4AutoloaderClass.php`)

## 3. Cấu trúc thư mục quan trọng

- `public/`: các trang web truy cập trực tiếp (index, login, product, cart, admin CRUD).
- `src/bootstrap.php`: khởi tạo kết nối DB và gọi các hàm đảm bảo schema.
- `src/functions.php`: helper chung và các hàm migration tự động.
- `src/classes/`: các lớp `Product`, `Category`, `Cart`, `Order`, `User`, `Profile`, `PDOFactory`.
- `src/partials/`: header/footer/navbar/template dùng lại.
- `ct523-project.sql`: file SQL đầy đủ để khởi tạo dữ liệu.
- `create_admin.php`: tạo tài khoản admin mặc định.

## 4. Yêu cầu môi trường

- XAMPP (Apache + MySQL) đang chạy.
- PHP extension PDO MySQL bật sẵn (mặc định trong XAMPP).
- Project đặt tại `htdocs/onlinestore`.

## 5. Cài đặt nhanh

### Bước 1: Import database

1. Mở phpMyAdmin.
2. Tạo database tên `ct523-project`.
3. Import file `ct523-project.sql`.

Luu y: trong code (`src/bootstrap.php`) đang dùng:

```php
'dbname' => 'ct523-project'
```

Neu ban import vao ten khac (vi du `ct523`) thi phai doi lai `dbname` cho khop.

### Bước 2: Cấu hình kết nối DB

Kiểm tra `src/bootstrap.php`:

```php
'dbhost' => 'localhost',
'dbname' => 'ct523-project',
'dbuser' => 'root',
'dbpass' => ''
```

### Bước 3: Chạy dự án

Truy cập:

- `http://localhost/onlinestore/public/index.php`

## 6. Tài khoản admin mặc định

Chạy một lần:

- `http://localhost/onlinestore/create_admin.php`

Tai khoan duoc tao:

- Email: `admin@gmail.com`
- Password: `123456`

## 7. Cơ chế migration tự động khi bootstrap

Mỗi lần ứng dụng load `src/bootstrap.php`, hệ thống sẽ gọi:

- `ensure_user_profile_columns($PDO)`
    - Bổ sung các cột profile của `users` nếu thiếu.
- `ensure_product_size_stock_table($PDO)`
    - Tạo bảng `product_size_stock` và đồng bộ tồn kho theo size từ `products`.
- `ensure_cart_order_size_columns($PDO)`
    - Bổ sung cột size trong `carts`/`orders`, thêm cột tracking tồn kho cho `orders`.

Các hàm này có guard để tránh crash khi schema chưa đầy đủ.

## 8. Vai trò người dùng

- `user`: duyệt sản phẩm, giỏ hàng, đặt hàng, xem profile.
- `admin`: thêm/sửa/xóa danh mục, sản phẩm, người dùng, quản lý đơn hàng.

## 9. Lưu ý bảo mật

Hiện tại password đang lưu dạng plain text trong DB. Khi deploy thực tế, nên chuyển sang:

- `password_hash()` khi lưu
- `password_verify()` khi đăng nhập

## 10. Cac file `tmp_*.php` co can giu khong?

Các file `tmp_*.php` trong root là script tạm để seed/migrate/check dữ liệu.

- Không được include trong runtime chính.
- Có thể xóa an toàn nếu không cần chạy lại các tác vụ tạm.

Nếu cần dọn project, có thể xóa toàn bộ `tmp_*.php`.

## 11. Lỗi thường gặp và cách xử lý nhanh

### Loi: `Table '...products' doesn't exist` hoặc `...categories doesn't exist`

- Nguyên nhân: DB chưa import đúng hoặc sai tên DB.
- Cách xử lý:
    1. Import `ct523-project.sql`.
    2. Kiểm tra `dbname` trong `src/bootstrap.php`.

### Loi FK khi tao `product_size_stock`

- Thường do bảng `products` chưa tồn tại hoặc schema lệch.
- Cần import lại SQL chuẩn, sau đó reload trang.

### Khong dang nhap duoc admin

- Chạy lại `create_admin.php` để tạo mới tài khoản admin.

## 12. Gợi ý phát triển tiếp

- Hash password và thêm cơ chế reset password.
- Tách migration ra file riêng thay vì chạy trong bootstrap mỗi request.
- Thêm `.env` cho cấu hình DB.
- Viết test cơ bản cho các luồng `Cart`, `Order`, `Product`.
