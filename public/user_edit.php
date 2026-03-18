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
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$userId) {
    redirect('user_list.php');
}

// Find user by ID
if (!$user->find($userId)) {
    $_SESSION['flash_message'] = 'Người dùng không tồn tại.';
    redirect('user_list.php');
}

// Handle POST request for update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->fill($_POST);
    
    if ($user->validate()) {
        if ($user->update($userId)) {
            $_SESSION['flash_message'] = 'Cập nhật người dùng thành công.';
            redirect('user_list.php');
        } else {
            $errors[] = 'Không thể cập nhật người dùng.';
        }
    } else {
        $errors = $user->getValidationErrors();
    }
}

$genderLabels = [
    'male' => 'Nam',
    'female' => 'Nữ',
    'other' => 'Khác',
];

include_once __DIR__ . '/../src/partials/header.php'
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php' ?>

    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Chỉnh sửa thông tin người dùng</h2>

                <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $error): ?>
                            <div><?= html_escape($error) ?></div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <form action="" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label for="user_name" class="form-label">Tên người dùng</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= html_escape($user->user_name) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" value="<?= html_escape($user->user_email) ?>" required>
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
                            <option value="male" <?= $user->user_gender === 'male' ? 'selected' : '' ?>>Nam</option>
                            <option value="female" <?= $user->user_gender === 'female' ? 'selected' : '' ?>>Nữ</option>
                            <option value="other" <?= $user->user_gender === 'other' ? 'selected' : '' ?>>Khác</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="user_role" class="form-label">Vai trò</label>
                        <select class="form-select" id="user_role" name="user_role" required>
                            <option value="user" <?= $user->user_role === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user->user_role === 'admin' ? 'selected' : '' ?>>Admin</option>
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
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php' ?>
</body>

</html>
