<?php
session_start();

require_once __DIR__ . '/../src/bootstrap.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    redirect('/');
}

use CT27502\Project\Product;
use CT27502\Project\Category;

$product = new Product($PDO);

$id = isset($_REQUEST['id']) ? filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
if ($id < 0 || !($product->find($id))) {
    redirect('product_list.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product->validate();
    $errors = $product->getValidationErrors();
    $img_file = handle_image_upload();

    $old_img = $_POST['old-image'];

    if($_FILES['image']['name']!='') {
        if ($img_file === false) {
            $errors['pd_image'] = "Ảnh không hợp lệ.";
        }
    }

    if (empty($errors)) {
        if ($img_file) {
            $_POST['pd_image'] = $img_file;
        } else {
            $_POST['pd_image'] = $old_img;
        }

        if ($product->update($_POST)) {
            if ($img_file && $old_img) {
                remove_image_file($old_img);
            }

            $_SESSION['flash_message'] = 'Cập nhật sản phẩm thành công';

            redirect('product_list.php');
        }

        $errors = $product->getValidationErrors();
    }
}

$category = new Category($PDO);
$categories = $category->all();
$bstCollectionOptions = [
    '' => 'Không thuộc BST riêng',
    'clair-de-spring' => 'CLAIR DE SPRING',
    'xuan-nhien' => 'XUÂN NHIÊN',
    'night-out' => 'NIGHT OUT COLLECTION',
    'city-hours' => 'CITY HOURS',
    'classmate-notes' => 'CLASSMATE NOTES',
    'after-class' => 'AFTER CLASS',
];

include_once __DIR__ . '/../src/partials/header.php'
?>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php' ?>

    <div class="container mb-4">
        <?php
        $subtitle = 'CẬP NHẬT SẢN PHẨM';
        include_once __DIR__ . '/../src/partials/heading.php';
        ?>

        <div class="row my-5">
            <div class="col-12">
                <form method="POST" enctype="multipart/form-data" class="col-md-6 offset-md-3">
                    <!-- Name -->
                    <div class="form-group">
                        <label for="pd_name" class="mt-4 mb-2">Tên sản phẩm<span class="red">*</span></label>
                        <input type="text" name="pd_name" class="form-control fs-5<?= isset($errors['name']) ? ' is-invalid' : '' ?>" maxlen="255" id="pd_name" value="<?= html_escape($product->pd_name) ?>" />

                        <?php if (isset($errors['name'])) : ?>
                            <span class="invalid-feedback">
                                <strong><?= $errors['name'] ?></strong>
                            </span>
                        <?php endif ?>
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label for="pd_image" class="mt-4 mb-2">Hình ảnh (&#8804 2MB)<span class="red">*</span></label>
                        <img src="<?= './uploads/' . html_escape($product->pd_image) ?>" alt="" width="80px" height="80px">
                        <input type="file" id="pd_image" name="image" accept="image/*" class="form-control fs-5<?= isset($errors['pd_image']) ? ' is-invalid' : '' ?>" id="pd_image" />
                        <input type="hidden" name="old-image" value="<?= html_escape($product->pd_image) ?>">

                        <?php if (isset($errors['pd_image'])) : ?>
                            <span class="invalid-feedback">
                                <strong><?= $errors['pd_image'] ?></strong>
                            </span>
                        <?php endif ?>
                        <div class="preview_img my-2 mx-5" style="display: none;">
                            <span>Preview hình ảnh mới: </span>
                            <img src="" class="imagePreview" alt="" width="80px" height="80px">
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="pd_price" class="mt-4 mb-2">Giá<span class="red">*</span></label>
                        <input type="text" name="pd_price" class="form-control fs-5<?= isset($errors['price']) ? ' is-invalid' : '' ?>" maxlen="255" id="pd_price" value="<?= html_escape($product->pd_price) ?>" />

                        <?php if (isset($errors['price'])) : ?>
                            <span class="invalid-feedback">
                                <strong><?= $errors['price'] ?></strong>
                            </span>
                        <?php endif ?>
                    </div>

                    <!-- Info -->
                    <div class="form-group">
                        <label for="pd_info" class="mt-4 mb-2">Thông tin sản phẩm<span class="red">*</span></label>
                        <textarea name="pd_info" class="form-control fs-5<?= isset($errors['info']) ? ' is-invalid' : '' ?>" id="pd_info" rows="5"><?= html_escape($product->pd_info) ?></textarea>

                        <?php if (isset($errors['info'])) : ?>
                            <span class="invalid-feedback">
                                <strong><?= $errors['info'] ?></strong>
                            </span>
                        <?php endif ?>
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="cat" class="mt-4 mb-2">Loại sản phẩm<span class="red">*</span></label>
                        <select name="cat_id" id="cat" class="form-select fs-5">
                            <?php
                            foreach ($categories as $category) :
                            ?>
                                <option value="<?= $category->getID() ?>" <?= ($product->cat_id == $category->getID()) ? 'selected' : '' ?>>
                                    <?= html_escape($category->cat_name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>

                        <?php if (isset($errors['name'])) : ?>
                            <span class="invalid-feedback">
                                <strong><?= $errors['name'] ?></strong>
                            </span>
                        <?php endif ?>
                    </div>


                    <!-- Sizes -->
                    <div class="form-group">
                        <label class="mt-4 mb-2 d-block">Kích thước</label>
                        <div class="d-flex gap-3 flex-wrap">
                            <?php
                            $currentSizes = array_filter(array_map('trim', explode(',', $product->pd_sizes ?? '')));
                            foreach (['XS', 'M', 'L', 'Freezie'] as $sz) :
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pd_sizes[]" value="<?= $sz ?>" id="sz_<?= $sz ?>" <?= in_array($sz, $currentSizes) ? 'checked' : '' ?>>
                                    <label class="form-check-label fs-5" for="sz_<?= $sz ?>"><?= $sz ?></label>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pd_collection" class="mt-4 mb-2">Bộ sưu tập BST</label>
                        <select name="pd_collection" id="pd_collection" class="form-select fs-5">
                            <?php foreach ($bstCollectionOptions as $collectionCode => $collectionLabel) : ?>
                                <option value="<?= html_escape($collectionCode) ?>" <?= (($product->pd_collection ?? '') === $collectionCode) ? 'selected' : '' ?>>
                                    <?= html_escape($collectionLabel) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- Submit -->
                    <button type="submit" name="submit" class="btn btn-primary fs-4 mt-4 p-3 fw-bold">Cập nhật sản phẩm</button>
                </form>

            </div>
        </div>

        <a href="product_list.php" class="btn btn-secondary fs-4 py-2 px-3 text-light fw-medium">
            <i class="fa-solid fa-chevron-left text-light"></i>
            Trở về
        </a>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php' ?>

    <script>
        $(function() {
            $('#pd_image').on("change", function(event) { //Sự kiện được kích hoạt khi chọn file ảnh 
                var file = event.target.files[0]; //Truy cập vào file đã chọn
                var reader = new FileReader(); //Tạo một đối tượng FileReader mới để đọc dữ liệu từ file được chọn.
                reader.onload = function(e) { //Sự kiện được kích hoạt khi file đã được đọc hoàn toàn
                    $('.imagePreview').attr('src', e.target.result);
                    $('.preview_img').show();
                }
                reader.readAsDataURL(file); //Đọc file và chuyển đổi nó thành một data URL có thể sử dụng để hiển thị hình ảnh.
            });
        });
    </script>
</body>

</html>

