<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT27502\Project\Order;
use CT27502\Project\Profile;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    redirect('/onlinestore/public/login.php');
}

$userId = (int) $_SESSION['id'];
$profile = new Profile($PDO);
$errors = [];
$successMessage = '';

$section = isset($_GET['section']) && $_GET['section'] === 'orders' ? 'orders' : 'account';
$availableOrderTabs = ['pending', 'pickup', 'shipping', 'delivered', 'return', 'cancelled'];
$orderTab = isset($_GET['status']) && in_array($_GET['status'], $availableOrderTabs, true) ? $_GET['status'] : 'pending';
$orderKeyword = trim((string) ($_GET['q'] ?? ''));

if (!$profile->loadById($userId)) {
    redirect('/onlinestore/public/logout.php');
}

$_SESSION['avatar'] = $profile->getAvatar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'save_profile') {
        $profile->fillPersonalInfo($_POST);

        if ($profile->validatePersonalInfo()) {
            if ($profile->updatePersonalInfo($userId)) {
                $_SESSION['name'] = $profile->name;
                $successMessage = 'Cập nhật thông tin cá nhân thành công.';
            } else {
                $errors[] = 'Không thể cập nhật thông tin cá nhân.';
            }
        } else {
            $errors = $profile->getValidationErrors();
        }

        if (isset($_FILES['avatar']) && is_array($_FILES['avatar']) && (string) ($_FILES['avatar']['tmp_name'] ?? '') !== '') {
            $avatarFile = $_FILES['avatar'];
            if ((int) $avatarFile['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'Tải ảnh lên không thành công, vui lòng thử lại.';
            } else {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $originalName = (string) ($avatarFile['name'] ?? '');
                $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $imageInfo = getimagesize((string) $avatarFile['tmp_name']);

                if (!$imageInfo || !in_array($extension, $allowedExtensions, true)) {
                    $errors[] = 'Chỉ chấp nhận ảnh JPG, JPEG, PNG, GIF hoặc WEBP.';
                }

                if ((int) ($avatarFile['size'] ?? 0) > 2 * 1024 * 1024) {
                    $errors[] = 'Ảnh đại diện phải nhỏ hơn 2MB.';
                }

                if (empty($errors)) {
                    $newAvatar = 'avatar-' . $userId . '-' . str_replace('.', '', uniqid('', true)) . '.' . $extension;
                    $uploadPath = __DIR__ . '/avatar/' . $newAvatar;

                    if (!move_uploaded_file((string) $avatarFile['tmp_name'], $uploadPath)) {
                        $errors[] = 'Không thể lưu ảnh đại diện.';
                    } else {
                        $oldAvatar = $profile->getAvatar();
                        if ($profile->updateAvatar($userId, $newAvatar)) {
                            $_SESSION['avatar'] = $newAvatar;
                            $successMessage = 'Cập nhật thông tin thành công.';

                            if ($oldAvatar !== '' && $oldAvatar !== $newAvatar) {
                                $oldPath = __DIR__ . '/avatar/' . basename($oldAvatar);
                                if (is_file($oldPath)) {
                                    @unlink($oldPath);
                                }
                            }
                        } else {
                            @unlink($uploadPath);
                            $errors[] = 'Không thể cập nhật ảnh đại diện.';
                        }
                    }
                }
            }
        }
    } else {
        $errors[] = 'Yêu cầu không hợp lệ.';
    }

    $profile->loadById($userId);
}

$order = new Order($PDO);
$orderCounts = $order->historyCountByStatus($userId);
$historyRows = [];

$genderLabels = [
    'male' => 'Nam',
    'female' => 'Nữ',
    'other' => 'Khác',
];

$birthdayDisplay = $profile->birthday !== '' ? date('d/m/Y', strtotime($profile->birthday)) : 'Thêm thông tin';
$genderDisplay = $profile->gender !== '' && isset($genderLabels[$profile->gender]) ? $genderLabels[$profile->gender] : 'Thêm thông tin';
$phoneDisplay = $profile->phone !== '' ? $profile->phone : 'Thêm thông tin';
$contactEmailDisplay = $profile->contactEmail !== '' ? $profile->contactEmail : 'Thêm thông tin';
$websiteDisplay = $profile->website !== '' ? $profile->website : 'Thêm thông tin';

if ($section === 'orders') {
    if (in_array($orderTab, $availableOrderTabs, true)) {
        $historyRows = $order->historyByUser($userId, $orderTab, $orderKeyword);
    } else {
        $historyRows = [];
    }
}

include_once __DIR__ . '/../src/partials/header.php';
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container user-dashboard-page">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-3">
                <aside class="user-dashboard-card user-dashboard-side">
                    <div class="user-dashboard-head">
                        <div>
                            <h2><?= html_escape($profile->name) ?></h2>
                            <p><?= html_escape($profile->email) ?></p>
                        </div>
                        <?php if ($profile->getAvatar() !== '') : ?>
                            <img class="user-dashboard-avatar user-dashboard-avatar-clickable" src="/onlinestore/public/avatar/<?= html_escape($profile->getAvatar()) ?>" alt="Avatar của <?= html_escape($profile->name) ?>" role="button" tabindex="0" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="avatar" data-edit-title="Ảnh đại diện" title="Bấm để thay đổi ảnh đại diện">
                        <?php else : ?>
                            <div class="user-dashboard-avatar user-dashboard-avatar-fallback user-dashboard-avatar-clickable" role="button" tabindex="0" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="avatar" data-edit-title="Ảnh đại diện" title="Bấm để tải ảnh đại diện" aria-hidden="true">
                                <?= html_escape(mb_strtoupper(mb_substr((string) $profile->name, 0, 1, 'UTF-8'), 'UTF-8')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="user-dashboard-menu">
                        <a class="<?= $section === 'account' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=account">
                            <span><i class="fa-regular fa-user"></i> Thông tin tài khoản</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        <a class="<?= $section === 'orders' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=orders&status=pending">
                            <span><i class="fa-regular fa-rectangle-list"></i> Lịch sử đơn hàng</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>

                    <div class="user-dashboard-menu user-dashboard-meta">
                        <button type="button" class="menu-static-row menu-static-row-btn" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="address" data-edit-title="Địa chỉ đã lưu">
                            <span><i class="fa-solid fa-location-dot"></i> Địa chỉ đã lưu</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                        <button type="button" class="menu-static-row menu-static-row-btn" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="contact_email" data-edit-title="Email liên hệ">
                            <span><i class="fa-regular fa-envelope"></i> Email liên hệ</span>
                            <strong><?= html_escape($contactEmailDisplay) ?></strong>
                        </button>
                        <button type="button" class="menu-static-row menu-static-row-btn" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="website" data-edit-title="Website">
                            <span><i class="fa-solid fa-globe"></i> Website</span>
                            <strong><?= html_escape($websiteDisplay) ?></strong>
                        </button>
                    </div>
                </aside>
            </div>

            <div class="col-lg-9 col-xl-9">
                <?php if (!empty($successMessage)) : ?>
                    <div class="alert alert-success" role="alert"><?= html_escape($successMessage) ?></div>
                <?php endif; ?>

                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($errors as $error) : ?>
                            <div><?= html_escape((string) $error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($section === 'account') : ?>
                    <section class="user-dashboard-card user-dashboard-content account-like-card">
                        <div class="account-like-head">
                            <h3>Thông tin cá nhân</h3>
                            <button type="button" class="btn account-edit-btn" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="name" data-edit-title="Họ và tên">Chỉnh sửa</button>
                        </div>

                        <div class="account-like-rows">
                            <button type="button" class="account-like-row" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="name" data-edit-title="Họ và tên">
                                <span>Họ và tên</span>
                                <strong><?= html_escape($profile->name) ?> <i class="fa-solid fa-chevron-right"></i></strong>
                            </button>
                            <button type="button" class="account-like-row" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="birthday" data-edit-title="Ngày sinh">
                                <span>Ngày sinh</span>
                                <strong class="is-muted"><?= html_escape($birthdayDisplay) ?> <i class="fa-solid fa-chevron-right"></i></strong>
                            </button>
                            <button type="button" class="account-like-row" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="gender" data-edit-title="Giới tính">
                                <span>Giới tính</span>
                                <strong class="is-muted"><?= html_escape($genderDisplay) ?> <i class="fa-solid fa-chevron-right"></i></strong>
                            </button>
                            <button type="button" class="account-like-row" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="phone" data-edit-title="Số điện thoại">
                                <span>Số điện thoại</span>
                                <strong class="is-muted"><?= html_escape($phoneDisplay) ?> <i class="fa-solid fa-lock"></i> <i class="fa-solid fa-chevron-right"></i></strong>
                            </button>
                            <button type="button" class="account-like-row" data-bs-toggle="modal" data-bs-target="#profileEditModal" data-edit-field="email_display" data-edit-title="Email đăng nhập">
                                <span>Email</span>
                                <strong class="is-muted"><?= html_escape($profile->email) ?> <i class="fa-solid fa-lock"></i> <i class="fa-solid fa-chevron-right"></i></strong>
                            </button>
                        </div>

                        <div class="mt-3">
                            <a href="/onlinestore/public/logout.php" class="btn account-logout-btn">Đăng xuất</a>
                        </div>
                    </section>
                <?php else : ?>
                    <section class="user-dashboard-card user-dashboard-content">
                        <h3>Lịch sử đơn hàng</h3>

                        <form class="user-order-search" action="/onlinestore/public/profile.php" method="get">
                            <input type="hidden" name="section" value="orders">
                            <input type="hidden" name="status" value="<?= html_escape($orderTab) ?>">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="search" name="q" value="<?= html_escape($orderKeyword) ?>" placeholder="Tìm theo mã đơn hàng hoặc tên sản phẩm">
                        </form>

                        <div class="user-order-tabs">
                            <a class="<?= $orderTab === 'pending' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=orders&status=pending&q=<?= urlencode($orderKeyword) ?>">Chờ xác nhận (<?= (int) $orderCounts['pending'] ?>)</a>
                            <a class="<?= $orderTab === 'pickup' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=orders&status=pickup&q=<?= urlencode($orderKeyword) ?>">Chờ lấy hàng</a>
                            <a class="<?= $orderTab === 'shipping' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=orders&status=shipping&q=<?= urlencode($orderKeyword) ?>">Đang giao hàng</a>
                            <a class="<?= $orderTab === 'delivered' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=orders&status=delivered&q=<?= urlencode($orderKeyword) ?>">Đã giao (<?= (int) $orderCounts['delivered'] ?>)</a>
                            <a class="<?= $orderTab === 'return' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=orders&status=return&q=<?= urlencode($orderKeyword) ?>">Trả hàng</a>
                            <a class="<?= $orderTab === 'cancelled' ? 'active' : '' ?>" href="/onlinestore/public/profile.php?section=orders&status=cancelled&q=<?= urlencode($orderKeyword) ?>">Đã huỷ</a>
                        </div>

                        <?php if (empty($historyRows)) : ?>
                            <div class="user-order-empty">
                                <i class="fa-solid fa-box-open"></i>
                                <p>Bạn chưa có đơn hàng nào</p>
                            </div>
                        <?php else : ?>
                            <div class="user-order-list">
                                <?php foreach ($historyRows as $historyRow) : ?>
                                    <?php
                                    $orderCode = (int) $historyRow['order_code'];
                                    $orderItems = $order->itemsByCodeAndUser($orderCode, $userId);
                                    $statusCode = (int) $historyRow['order_status'];
                                    $orderStatusText = $order->getStatusLabel($statusCode);
                                    $statusClass = $statusCode === 3 ? 'done' : 'pending';
                                    ?>
                                    <article class="user-order-card">
                                        <div class="user-order-head">
                                            <div>
                                                <h4>Đơn #<?= $orderCode ?></h4>
                                                <p><?= html_escape((string) $historyRow['product_names']) ?></p>
                                            </div>
                                            <span class="status <?= $statusClass ?>"><?= html_escape($orderStatusText) ?></span>
                                        </div>

                                        <div class="user-order-meta">
                                            <span><?= (int) $historyRow['total_quantity'] ?> sản phẩm</span>
                                            <strong><?= number_format((int) $historyRow['grand_total']) ?>₫</strong>
                                        </div>

                                        <details class="user-order-detail">
                                            <summary>Xem chi tiết</summary>
                                            <div class="user-order-items">
                                                <?php foreach ($orderItems as $orderItem) : ?>
                                                    <div class="user-order-item-row">
                                                        <span><?= html_escape((string) $orderItem['pd_name']) ?> (Size: <?= html_escape((string) ($orderItem['pd_size'] ?? 'Freezie')) ?>) x <?= (int) $orderItem['pd_quantity'] ?></span>
                                                        <strong><?= number_format((int) $orderItem['order_total']) ?>₫</strong>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </details>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profileEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg profile-edit-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileEditModalTitle">Cập nhật thông tin cá nhân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/onlinestore/public/profile.php?section=account" method="post" enctype="multipart/form-data" class="modal-body user-profile-form">
                    <input type="hidden" name="action" value="save_profile">

                    <div class="row g-3">
                        <div class="col-12 profile-field-group" data-field="name">
                            <label class="form-label" for="name">Họ và tên</label>
                            <input class="form-control" type="text" id="name" name="name" value="<?= html_escape($profile->name) ?>" required>
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="birthday">
                            <label class="form-label" for="birthday">Ngày sinh</label>
                            <input class="form-control" type="date" id="birthday" name="birthday" value="<?= html_escape($profile->birthday) ?>">
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="gender">
                            <label class="form-label" for="gender">Giới tính</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="" <?= $profile->gender === '' ? 'selected' : '' ?>>Thêm thông tin</option>
                                <option value="male" <?= $profile->gender === 'male' ? 'selected' : '' ?>>Nam</option>
                                <option value="female" <?= $profile->gender === 'female' ? 'selected' : '' ?>>Nữ</option>
                                <option value="other" <?= $profile->gender === 'other' ? 'selected' : '' ?>>Khác</option>
                            </select>
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="phone">
                            <label class="form-label" for="phone">Số điện thoại</label>
                            <input class="form-control" type="text" id="phone" name="phone" value="<?= html_escape($profile->phone) ?>" placeholder="Thêm thông tin">
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="email_display">
                            <label class="form-label" for="email">Email đăng nhập</label>
                            <input class="form-control" type="text" id="email" value="<?= html_escape($profile->email) ?>" readonly>
                            <small class="text-muted">Email đăng nhập không thể chỉnh sửa tại đây.</small>
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="contact_email">
                            <label class="form-label" for="contact_email">Email liên hệ</label>
                            <input class="form-control" type="email" id="contact_email" name="contact_email" value="<?= html_escape($profile->contactEmail) ?>" placeholder="Thêm thông tin">
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="address" id="address-row">
                            <label class="form-label" for="address">Địa chỉ đã lưu</label>
                            <input class="form-control" type="text" id="address" name="address" value="<?= html_escape($profile->address) ?>" placeholder="Thêm thông tin">
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="website">
                            <label class="form-label" for="website">Website</label>
                            <input class="form-control" type="url" id="website" name="website" value="<?= html_escape($profile->website) ?>" placeholder="https://example.com">
                        </div>

                        <div class="col-12 profile-field-group d-none" data-field="avatar">
                            <label class="form-label" for="avatar">Ảnh đại diện</label>
                            <input class="form-control" type="file" id="avatar" name="avatar" accept=".jpg,.jpeg,.png,.gif,.webp,image/*">
                            <small class="text-muted">Định dạng: JPG, JPEG, PNG, GIF, WEBP. Tối đa 2MB.</small>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end gap-2 profile-modal-actions">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn user-dashboard-btn" type="submit">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const editModal = document.getElementById('profileEditModal');
            if (!editModal) {
                return;
            }

            const titleNode = document.getElementById('profileEditModalTitle');
            const fieldGroups = editModal.querySelectorAll('.profile-field-group');

            function showField(fieldName, titleText) {
                fieldGroups.forEach((group) => {
                    const match = group.getAttribute('data-field') === fieldName;
                    group.classList.toggle('d-none', !match);
                });

                if (titleNode) {
                    titleNode.textContent = titleText || 'Cập nhật thông tin cá nhân';
                }

                window.setTimeout(() => {
                    const target = editModal.querySelector('[data-field="' + fieldName + '"] input:not([type="hidden"]), [data-field="' + fieldName + '"] select, [data-field="' + fieldName + '"] textarea');
                    if (target && !target.readOnly && !target.disabled) {
                        target.focus();
                    }
                }, 120);
            }

            editModal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                const fieldName = trigger ? trigger.getAttribute('data-edit-field') : 'name';
                const titleText = trigger ? trigger.getAttribute('data-edit-title') : 'Cập nhật thông tin cá nhân';
                showField(fieldName || 'name', titleText || 'Cập nhật thông tin cá nhân');
            });
        })();
    </script>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>
