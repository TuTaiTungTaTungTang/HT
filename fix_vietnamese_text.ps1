$root = 'D:\APPS\XAMPP\htdocs\onlinestore\public'

$replacements = [ordered]@{
    'ThA?m vA?o giỏ hA?ng' = 'Thêm vào giỏ hàng'
    'ThA?ng tin người nhận:' = 'Thông tin người nhận:'
    'Nhập địa chỉ nhận hA?ng' = 'Nhập địa chỉ nhận hàng'
    'GI?? HA?NG' = 'GIỎ HÀNG'
    'Đặt hA?ng thA?nh cA?ng! QuA? khA?ch vui lA?ng kiểm tra email để xem chi tiết đơn hA?ng' = 'Đặt hàng thành công! Quý khách vui lòng kiểm tra email để xem chi tiết đơn hàng'

    'TA?M KI?M' = 'TÌM KIẾM'
    'KhA?ng tA?m thấy sản phẩm' = 'Không tìm thấy sản phẩm'
    'KhA?ng tA?m thấy sản phẩm nA?o với từ khA?a' = 'Không tìm thấy sản phẩm nào với từ khóa'
    'TA?m thấy sản phẩm' = 'Tìm thấy sản phẩm'
    'Kết quả tA?m kiếm sản phẩm với từ khA?a' = 'Kết quả tìm kiếm sản phẩm với từ khóa'

    'QUẢN LA? DANH MỤC' = 'QUẢN LÝ DANH MỤC'
    'QUẢN LA? SẢN PHẨM' = 'QUẢN LÝ SẢN PHẨM'
    'QUẢN LA? ĐƠN HA?NG' = 'QUẢN LÝ ĐƠN HÀNG'

    'THA?M DANH MỤC' = 'THÊM DANH MỤC'
    'ThA?m danh mục' = 'Thêm danh mục'
    'ThA?m sản phẩm' = 'Thêm sản phẩm'

    'TA?n danh mục' = 'Tên danh mục'
    'TA?n sản phẩm' = 'Tên sản phẩm'
    'TA?n khA?ch hA?ng' = 'Tên khách hàng'

    'HA?nh ảnh' = 'Hình ảnh'
    'GiA?' = 'Giá'
    'ThA?ng tin' = 'Thông tin'
    'ThA?nh tiền' = 'Thành tiền'

    'MA? đơn hA?ng' = 'Mã đơn hàng'
    'TA?nh trạng' = 'Tình trạng'
    'ĐA? giao hA?ng' = 'Đã giao hàng'
    'Đang xử lA?' = 'Đang xử lý'
    'Cập nhật tA?nh trạng' = 'Cập nhật tình trạng'
    'Xem chi tiết đơn hA?ng' = 'Xem chi tiết đơn hàng'

    'Địa chỉ giao hA?ng' = 'Địa chỉ giao hàng'
    'TA?nh trạng đơn hA?ng' = 'Tình trạng đơn hàng'

    'XA?a' = 'Xóa'
    'xA?c nhận xA?a' = 'xác nhận xóa'
    'XA?c nhận xA?a' = 'Xác nhận xóa'
    'Bạn cA? chắc muốn xA?a' = 'Bạn có chắc muốn xóa'

    'Cập nhật danh mục thA?nh cA?ng' = 'Cập nhật danh mục thành công'
    'Cập nhật sản phẩm thA?nh cA?ng' = 'Cập nhật sản phẩm thành công'
    'Cập nhật trạng thA?i đơn hA?ng thA?nh cA?ng' = 'Cập nhật trạng thái đơn hàng thành công'
    'ThA?m danh mục thA?nh cA?ng' = 'Thêm danh mục thành công'
    'ThA?m sản phẩm thA?nh cA?ng' = 'Thêm sản phẩm thành công'
    'XA?a danh mục thA?nh cA?ng' = 'Xóa danh mục thành công'
    'XA?a sản phẩm thA?nh cA?ng' = 'Xóa sản phẩm thành công'
    'XA?a đơn hA?ng thA?nh cA?ng' = 'Xóa đơn hàng thành công'

    'ĐĂNG KA?' = 'ĐĂNG KÝ'
    'Đăng kA?' = 'Đăng ký'
    'Họ TA?n:' = 'Họ Tên:'
    'Nhập họ vA? tA?n' = 'Nhập họ và tên'
    'Nhập mật khẩu từ 8-32 kA? tự' = 'Nhập mật khẩu từ 8-32 ký tự'
    'Nếu chưa cA? tA?i khoản, hA?y' = 'Nếu chưa có tài khoản, hãy'

    'Ảnh khA?ng hợp lệ.' = 'Ảnh không hợp lệ.'
    'Preview hA?nh ảnh mới:' = 'Preview hình ảnh mới:'

    'Nếu khA?ng hợp lệ, lấy thA?ng bA?o lỗi' = 'Nếu không hợp lệ, lấy thông báo lỗi'
    'Kiểm tra hợp lệ vA? lưu dữ liệu sản phẩm' = 'Kiểm tra hợp lệ và lưu dữ liệu sản phẩm'
    'Sự kiện được kA?ch hoạt khi chọn file ảnh' = 'Sự kiện được kích hoạt khi chọn file ảnh'
    'Truy cập vA?o file đA? chọn' = 'Truy cập vào file đã chọn'
    'Sự kiện được kA?ch hoạt khi file đA? được đọc hoA?n toA?n' = 'Sự kiện được kích hoạt khi file đã được đọc hoàn toàn'
    'Đọc file vA? chuyển đổi nA? thA?nh một data URL cA? thể sử dụng để hiển thị hA?nh ảnh.' = 'Đọc file và chuyển đổi nó thành một data URL có thể sử dụng để hiển thị hình ảnh.'

    'TẤT CẢ MẶT HA?NG' = 'TẤT CẢ MẶT HÀNG'
    'Tất cả mặt hA?ng' = 'Tất cả mặt hàng'
    'Nút thA?m giỏ hA?ng' = 'Nút thêm giỏ hàng'

    'catID thA? gọi hA?m' = 'catID thì gọi hàm'
    'tham số lA?' = 'tham số là'
}

$changed = 0
Get-ChildItem -Path $root -Filter '*.php' -File | ForEach-Object {
    $path = $_.FullName
    $content = Get-Content -Path $path -Raw
    $original = $content

    foreach ($key in $replacements.Keys) {
        $pattern = [regex]::Escape($key).Replace('\?', '.')
        $content = [regex]::Replace($content, $pattern, [System.Text.RegularExpressions.MatchEvaluator]{ param($m) $replacements[$key] })
    }

    if ($content -ne $original) {
        Set-Content -Path $path -Value $content -Encoding utf8
        $changed++
    }
}

Write-Output "Files updated: $changed"
