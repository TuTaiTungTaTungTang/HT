<?php
session_start();

require_once __DIR__ . '/../src/bootstrap.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    redirect('/');
}

// Base URL for image assets
$baseURL = '/onlinestore/public/';

use ct523\Project\Category;
use ct523\Project\Product;

$productModel = new Product($PDO);
$allProducts = $productModel->all();
$categoryModel = new Category($PDO);
$categories = $categoryModel->all();
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$selectedCategory = isset($_GET['category']) && ctype_digit((string)$_GET['category']) ? (int) $_GET['category'] : 0;

// Function to get the correct image file for a product
function getProductImagePath($product) {
    if (preg_match('/clothes-(\d+)-/', $product->pd_image, $matches)) {
        $folderId = $matches[1];

        // 1. Kiểm tra trong images/clothes/
        $dir1 = __DIR__ . '/images/clothes/' . $folderId;
        if (is_dir($dir1)) {
            $files = scandir($dir1);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && !strpos($file, 'background') && !strpos($file, '(')) {
                    return 'images/clothes/' . $folderId . '/' . $file;
                }
            }
        }

        // 2. Kiểm tra trong uploads/ (Quan trọng: Sửa lại logic tìm file ở đây)
        $dir2 = __DIR__ . '/uploads/' . $folderId;
        if (is_dir($dir2)) {
            $files = scandir($dir2);
            foreach ($files as $file) {
                // Kiểm tra xem có phải là file ảnh không (jpg, png, webp, avif)
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'])) {
                    if (!strpos($file, 'background') && !strpos($file, '(')) {
                        return 'uploads/' . $folderId . '/' . $file;
                    }
                }
            }
        }
    }

    // 3. Nếu không tìm thấy trong subfolder, thử kiểm tra file trực tiếp trong uploads/
    // (Dành cho trường hợp file nằm ngay trong uploads chứ không nằm trong folder ID)
    if (!empty($product->pd_image)) {
        $directPath = __DIR__ . '/uploads/' . $product->pd_image;
        if (file_exists($directPath)) {
            return 'uploads/' . $product->pd_image;
        }
    }

    return 'assets/images/placeholder.svg';
}
// Lọc sản phẩm theo tìm kiếm và theo category
$products = $allProducts;
if (!empty($searchQuery) || $selectedCategory > 0) {
    $products = array_filter($allProducts, function ($product) use ($searchQuery, $selectedCategory) {
        $matchSearch = true;
        $matchCategory = true;

        if (!empty($searchQuery)) {
            $query = strtolower($searchQuery);
            $matchSearch = strpos(strtolower($product->pd_name), $query) !== false ||
                strpos((string) $product->getID(), $query) !== false;
        }

        if ($selectedCategory > 0) {
            $matchCategory = (int) $product->cat_id === $selectedCategory;
        }

        return $matchSearch && $matchCategory;
    });
}

// Xử lý AJAX cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_update'])) {
    header('Content-Type: application/json');
    
    $productId = isset($_POST['pd_id']) ? (int) $_POST['pd_id'] : 0;
    $stockInput = isset($_POST['stock']) && is_array($_POST['stock']) ? $_POST['stock'] : [];

    if ($productId > 0 && $productModel->saveSizeStockForProduct($productId, $stockInput)) {
        echo json_encode(['success' => true, 'message' => 'Cập nhật tồn kho thành công']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại, vui lòng thử lại']);
    }
    exit;
}

include_once __DIR__ . '/../src/partials/header.php';
?>

<style>
    .stock-card {
        border: 1px solid #e8eef2;
        border-radius: 10px;
        transition: all 0.3s ease;
        height: 100%;
        cursor: pointer;
        overflow: hidden;
        background: #fff;
    }

    .stock-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
        border-color: #8bb3c0;
    }

    .stock-card-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: #f5f7fa;
    }

    .stock-card-header {
        background: linear-gradient(135deg, #7ba5a6 0%, #9fbcc0 100%);
        color: white;
        padding: 1.2rem;
        font-weight: 500;
    }

    .stock-card-id {
        font-size: 0.85rem;
        opacity: 0.95;
        margin-top: 0.25rem;
        font-weight: 400;
    }

    .stock-card-body {
        padding: 1rem;
    }

    .stock-size-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .stock-size-row:last-child {
        border-bottom: none;
    }

    .stock-size-label {
        font-weight: 500;
        color: #556B73;
        min-width: 60px;
        font-size: 1.1rem;
    }

    .stock-size-value {
        display: inline-block;
        min-width: 50px;
        background: #eff5f7;
        padding: 0.35rem 0.75rem;
        border-radius: 5px;
        font-weight: 600;
        color: #7ba5a6;
        text-align: center;
        font-size: 1.1rem;
    }

    .stock-card-footer {
        padding: 1rem;
        border-top: 1px solid #e8eef2;
        display: flex;
        gap: 0.5rem;
    }

    .btn-edit-stock {
        flex: 1;
        font-weight: 500;
    }

    .search-container {
        margin-bottom: 2rem;
    }

    .modal-stock-form .modal-body {
        padding: 2rem;
    }

    .form-group-stock {
        margin-bottom: 1.5rem;
    }

    .form-group-stock label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .form-group-stock input {
        border: 2px solid #e8eef2;
        border-radius: 6px;
        padding: 0.75rem;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .form-group-stock input:focus {
        border-color: #8bb3c0;
        box-shadow: 0 0 0 3px rgba(139, 179, 192, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #7ba5a6 0%, #9fbcc0 100%);
        color: white;
        border: none;
    }

    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading::after {
        content: '';
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-left: 0.5rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .badge {
        font-weight: 500;
        font-size: 1rem; /* Tăng kích thước badge */
    padding: 0.5rem 0.8rem;
    }

    .btn-outline-secondary {
        border-color: #d1d5db;
        color: #556b73;
    }

    .btn-outline-secondary:hover {
        background-color: #f3f4f6;
        border-color: #8bb3c0;
        color: #7ba5a6;
    }

    .btn {
        font-weight: 500;
    }

    .btn-primary {
        background-color: #7ba5a6;
        border-color: #7ba5a6;
    }

    .btn-primary:hover {
        background-color: #6a919a;
        border-color: #6a919a;
    }

    .btn-primary:active, .btn-primary.active {
        background-color: #5a7d8e;
        border-color: #5a7d8e;
    }
</style>

<body>
    <?php include_once __DIR__ . '/../src/partials/navbar.php'; ?>

    <div class="container-lg py-4">
        <?php
        $subtitle = 'QUẢN LÝ TỒN KHO THEO SIZE';
        include_once __DIR__ . '/../src/partials/heading.php';
        ?>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= html_escape($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <div id="alertContainer"></div>

        <!-- Thanh tìm kiếm -->
        <div class="search-container">
            <form method="get" action="stock_size_list.php" class="row g-2">
                <div class="col-md-6">
                    <div class="input-group input-group-lg">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Tìm kiếm sản phẩm (tên hoặc ID)..."
                            value="<?= html_escape($searchQuery) ?>"
                        >
                        <button type="submit" class="btn btn-outline-secondary">Tìm</button>
                        <?php if (!empty($searchQuery)): ?>
                            <a href="stock_size_list.php" class="btn btn-outline-secondary">Xóa</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-lg">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="0" <?= $selectedCategory === 0 ? 'selected' : '' ?>>Tất cả danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->getID() ?>" <?= $selectedCategory === $category->getID() ? 'selected' : '' ?>><?= html_escape($category->cat_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($selectedCategory > 0): ?>
                            <a href="stock_size_list.php<?= !empty($searchQuery) ? '?search=' . urlencode($searchQuery) : '' ?>" class="btn btn-outline-secondary">Bỏ khóa</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 text-md-end d-flex align-items-center justify-content-md-end">
                    <span class="text-muted">
                        Hiển thị: <strong><?= count($products) ?></strong> sản phẩm
                        <?php if ($selectedCategory > 0): ?>
                            • Khóa: <strong><?= html_escape($categoryModel->getNameByID($selectedCategory)) ?></strong>
                        <?php endif; ?>
                    </span>
                </div>
            </form>
        </div>

        <!-- Danh sách sản phẩm dạng Grid -->
        <?php if (empty($products)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h5 class="text-muted">Không tìm thấy sản phẩm</h5>
                <p class="text-muted">Vui lòng thử tìm kiếm với từ khóa khác</p>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($products as $product): ?>
                    <?php
                    $stockMap = $productModel->getSizeStockMap($product->getID());
                    $categoryName = $categoryModel->getNameByID((int) $product->cat_id);
                    $productId = (int) $product->getID();
                    $totalStock = array_sum($stockMap);
                    $productSizes = array_filter(array_map('trim', explode(',', (string) ($product->pd_sizes ?? ''))));
                    
                    // Xác định màu badge dựa trên tồn kho (tone dịu hơn)
                    $stockBadgeClass = $totalStock > 50 ? 'bg-success bg-opacity-75' : ($totalStock > 20 ? 'bg-warning bg-opacity-75' : 'bg-danger bg-opacity-75');
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="stock-card">
                            <!-- Hình ảnh sản phẩm -->
                            <img 
                                src="<?= $baseURL . getProductImagePath($product) ?>" 
                                alt="<?= html_escape($product->pd_name) ?>"
                                class="stock-card-image"
                                onerror="this.src='<?= $baseURL ?>assets/images/placeholder.svg'"
                            >
                            
                            <div class="stock-card-header">
                                <div class="text-truncate"><?= html_escape($product->pd_name) ?></div>
                                <div class="stock-card-id">ID: <?= $productId ?> • <?= html_escape($categoryName) ?></div>
                            </div>
                            
                            <div class="stock-card-body">
                                <div style="margin-bottom: 0.75rem;">
                                    <span class="badge <?= $stockBadgeClass ?>">
                                        Tồn kho: <strong><?= $totalStock ?></strong>
                                    </span>
                                </div>

                                <?php foreach (Product::allowedSizes() as $sizeCode): ?>
                                    <?php $quantity = (int) ($stockMap[$sizeCode] ?? 0); ?>
                                    <div class="stock-size-row">
                                        <span class="stock-size-label"><?= html_escape($sizeCode) ?></span>
                                        <span class="stock-size-value"><?= $quantity ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="stock-card-footer">
                                <button 
                                    type="button" 
                                    class="btn btn-primary btn-edit-stock edit-stock-btn"
                                    data-product-id="<?= $productId ?>"
                                    data-product-name="<?= html_escape($product->pd_name) ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#stockModal"
                                >
                                    Sửa
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal cập nhật tồn kho -->
    <div class="modal fade" id="stockModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <div>
                        <h5 class="modal-title" id="modalProductName">Cập nhật tồn kho</h5>
                        <small id="modalProductCategory" style="opacity: 0.9;"></small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="stockUpdateForm">
                    <input type="hidden" id="modalProductId" name="pd_id" value="">
                    <input type="hidden" name="ajax_update" value="1">

                    <div class="modal-body modal-stock-form">
                        <div id="sizeInputsContainer">
                            <!-- Sẽ được fill bằng JavaScript -->
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <span id="submitBtnText">Cập nhật</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../src/partials/footer.php'; ?>

    <script>
        // Dữ liệu sản phẩm để reference
      const productStockData = <?= json_encode(array_reduce($products, function ($carry, $product) use ($productModel, $categoryModel) {
    $productId = (int) $product->getID();
    $carry[$productId] = [
        'stock' => $productModel->getSizeStockMap($productId),
        'category' => $categoryModel->getNameByID((int) $product->cat_id)
    ];
    return $carry;
}, [])); ?>;

        // Khi click nút "Sửa", load dữ liệu vào modal
        document.querySelectorAll('.edit-stock-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const data = productStockData[productId] || {};
                const stockMap = data.stock || {};
                const categoryName = data.category || '';

                document.getElementById('modalProductId').value = productId;
                document.getElementById('modalProductName').textContent = productName;
                document.getElementById('modalProductCategory').textContent = categoryName;

                // Tạo input field cho từng size
                const container = document.getElementById('sizeInputsContainer');
                container.innerHTML = '';

                const sizes = <?php echo json_encode(Product::allowedSizes()); ?>;
                sizes.forEach((size, index) => {
                    const quantity = stockMap[size] || 0;
                    const div = document.createElement('div');
                    div.className = 'form-group-stock';
                    div.innerHTML = `
                        <label for="stock_${size}">
                            <strong>${size}</strong>
                            <small class="text-muted ms-2">Size ${index + 1}</small>
                        </label>
                        <input 
                            type="number" 
                            id="stock_${size}"
                            name="stock[${size}]"
                            min="0"
                            step="1"
                            class="form-control" 
                            value="${quantity}"
                            required
                        >
                    `;
                    container.appendChild(div);
                    
                    // Focus ke input đầu tiên
                    if (index === 0) {
                        setTimeout(() => document.getElementById(`stock_${size}`).focus(), 200);
                    }
                });
            });
        });

        // Xử lý submit form (AJAX)
        document.getElementById('stockUpdateForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const submitText = document.getElementById('submitBtnText');
            const originalText = submitText.textContent;

            submitBtn.disabled = true;
            submitBtn.classList.add('btn-loading');

            const formData = new FormData(this);

            try {
                const response = await fetch('stock_size_list.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showAlert('success', data.message);
                    
                    // Đóng modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('stockModal'));
                    modal.hide();

                    // Reload trang sau 1.5 giây
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert('danger', data.message);
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-loading');
                    submitText.textContent = originalText;
                }
            } catch (error) {
                showAlert('danger', 'Có lỗi xảy ra: ' + error.message);
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-loading');
                submitText.textContent = originalText;
            }
        });

        // Hàm hiển thị thông báo
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show animation-slide`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.getElementById('alertContainer').insertAdjacentElement('afterbegin', alertDiv);

            // Tự động ẩn sau 5 giây
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 300);
            }, 5000);
        }

        // Đóng modal khi bấm Escape
        const stockModal = document.getElementById('stockModal');
        stockModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('stockUpdateForm').reset();
        });
    </script>
</body>

</html>