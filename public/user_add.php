<?php
session_start();

require_once __DIR__ . '/../src/bootstrap.php';

if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin') {
    redirect('/');
}

use CT27502\Project\User;

$user = new User($PDO);
$errors = [];
$success = '';

// Handle POST request for creating new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->fill($_POST);
    
    // Check if email already exists
    $statement = $PDO->prepare('SELECT user_id FROM users WHERE user_email = :email');
    $statement->execute(['email' => $user->user_email]);
    
    if ($statement->fetch()) {
        $errors['user_email'] = 'Email này đã tồn tại.';
    }
    
    if (empty($errors) && $user->validate()) {
        // Hash password
        $password = isset($_POST['user_psw']) && !empty($_POST['user_psw']) ? $_POST['user_psw'] : '123456';
        
        $statement = $PDO->prepare('INSERT INTO users (user_name, user_email, user_psw, role, user_phone, user_address, user_contact_email, user_website, user_birthday, user_gender) VALUES (:name, :email, :psw, :role, :phone, :address, :contact_email, :website, :birthday, :gender)');
        
        if ($statement->execute([
            'name' => $user->user_name,
            'email' => $user->user_email,
            'psw' => $password,
            'role' => $user->user_role,
            'phone' => $user->user_phone,
            'address' => $user->user_address,
            'contact_email' => $user->user_contact_email,
            'website' => $user->user_website,
            'birthday' => $user->user_birthday,
            'gender' => $user->user_gender
        ])) {
            $_SESSION['flash_message'] = 'Tạo người dùng mới thành công.';
            redirect('user_list.php');
        } else {
            $errors[] = 'Không thể tạo người dùng mới.';
        }
    } else {
        if (!empty($user->getValidationErrors())) {
            $errors = array_merge($errors, $user->getValidationErrors());
        }
    }
}

include_once __DIR__ . '/../src/partials/header.php'
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php' ?>

    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Thêm người dùng mới</h2>

                <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $error): ?>
                            <div><?= html_escape($error) ?></div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <form action="" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label for="user_name" class="form-label">Tên người dùng <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= html_escape($user->user_name) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="user_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="user_email" name="user_email" value="<?= html_escape($user->user_email) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="user_psw" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="user_psw" name="user_psw" placeholder="Để trống dùng mặc định: 123456">
                        <small class="text-muted">Nếu để trống sẽ sử dụng mật khẩu mặc định: <strong>123456</strong></small>
                    </div>

                    <div class="col-md-6">
                        <label for="user_role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                        <select class="form-select" id="user_role" name="user_role" required>
                            <option value="user" selected>User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="user_phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="user_phone" name="user_phone" value="<?= html_escape($user->user_phone) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="user_birthday" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="user_birthday" name="user_birthday" value="<?= html_escape($user->user_birthday) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="user_gender" class="form-label">Giới tính</label>
                        <select class="form-select" id="user_gender" name="user_gender">
                            <option value="">Chọn giới tính</option>
                            <option value="male">Nam</option>
                            <option value="female">Nữ</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="user_address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="user_address" name="user_address" value="<?= html_escape($user->user_address) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="user_contact_email" class="form-label">Email liên hệ</label>
                        <input type="email" class="form-control" id="user_contact_email" name="user_contact_email" value="<?= html_escape($user->user_contact_email) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="user_website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="user_website" name="user_website" value="<?= html_escape($user->user_website) ?>">
                    </div>

                    <div class="col-12">
                        <a href="user_list.php" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Tạo người dùng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php' ?>
</body>

</html>
