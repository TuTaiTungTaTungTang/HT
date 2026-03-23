<?php
session_start();

require_once __DIR__ . '/../src/bootstrap.php';

if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin') {
    redirect('/');
}

use ct523\Project\User;

$user = new User($PDO);
$users = $user->all();
$i = 0;

include_once __DIR__ . '/../src/partials/header.php'
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php' ?>

    <div class="container">
        <?php
        $subtitle = 'QUẢN LÝ NGƯỜI DÙNG';
        include_once __DIR__ . '/../src/partials/heading.php';
        ?>

        <?php if(isset($_SESSION['flash_message'])): ?>
            <div id="flash_message" class="text-success text-center fw-semibold">
                <?= $_SESSION['flash_message'] ?>
            </div>
            <?php unset($_SESSION['flash_message']) ?>
        <?php endif ?>

        <div class="row">
            <div class="col-12">

                <a href="user_add.php" class="btn btn-primary mb-3 fs-4 p-3">
                    <i class="fa fa-plus"></i> Thêm người dùng
                </a>

                <!-- Table Starts Here -->
                <table id="contacts" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">STT</th>
                            <th scope="col">Tên người dùng</th>
                            <th scope="col">Email</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $u) :
                            $i++;
                        ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td><?= html_escape($u->user_name) ?></td>
                                <td><?= html_escape($u->user_email) ?></td>
                                <td><?= html_escape($u->user_phone ?: '-') ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $u->user_role === 'admin' ? 'bg-danger' : 'bg-info' ?>">
                                        <?= $u->user_role === 'admin' ? 'Admin' : 'User' ?>
                                    </span>
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="<?= 'user_edit.php?id=' . $u->getID() ?>" class="btn btn-xs btn-warning fs-5 me-3">
                                        <i alt="Edit" class="fa fa-pencil"></i> Chỉnh sửa</a>
                                    <form action="user_delete.php" method="POST" class="form-inline ml-1">
                                        <input type="hidden" name="id" value="<?= $u->getID() ?>">
                                        <button type="submit" name="delete-user" class="btn btn-xs btn-danger fs-5 ms-3" data-bs-toggle="modal" data-bs-target="#delete-confirm">
                                            <i alt="Delete" class="fa fa-trash"></i> Xóa</a>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="delete-confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3 fw-bold" id="staticBackdropLabel">Xác nhận xóa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fs-5">
                    Bạn có chắc chắn muốn xóa người dùng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger fs-5" id="delete">Xóa</button>
                    <button type="button" class="btn fs-5" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php' ?>
    <script>
        $(document).ready(function() {
            let pendingDeleteForm = null;

            $('button[name="delete-user"]').on('click', function(e) {
                e.preventDefault();
                pendingDeleteForm = $(this).closest('form');
                const nameTd = $(this).closest('tr').find('td:eq(1)');
                if (nameTd.length > 0) {
                    $('.modal-body').html(`Bạn có chắc muốn xóa người dùng "${nameTd.text().trim()}"?`);
                } else {
                    $('.modal-body').text('Bạn có chắc muốn xóa dữ liệu này không?');
                }
                $('#delete-confirm').modal('show');
            });

            $('#delete').off('click').on('click', function() {
                if (pendingDeleteForm) {
                    pendingDeleteForm.trigger('submit');
                }
            });

            $('#delete-confirm').on('hidden.bs.modal', function() {
                pendingDeleteForm = null;
            });
        });
    </script>
</body>

</html>
