<?php

namespace CT27502\Project;

use PDO;

class Product
{
    private ?PDO $db;

    private int $pd_id = -1;
    public $pd_name;
    public $pd_price;
    public $pd_info;
    public $pd_image;
    public $cat_id;
    public $pd_sizes = '';
    private array $errors = [];

    public function getID(): int
    {
        return $this->pd_id;
    }

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function fill(array $data): Product
    {
        $this->pd_name = $data['pd_name'] ?? '';
        $this->pd_price = $data['pd_price'] ?? '';
        $this->pd_info = $data['pd_info'] ?? '';
        $this->pd_image = $data['pd_image'] ?? '';
        $this->cat_id = $data['cat_id'] ?? '';
        $allowed = ['XS', 'M', 'L', 'Freezie'];
        $sizesRaw = isset($data['pd_sizes']) && is_array($data['pd_sizes']) ? $data['pd_sizes'] : [];
        $this->pd_sizes = implode(',', array_filter($sizesRaw, fn($s) => in_array($s, $allowed, true)));
        return $this;
    }

    public function getValidationErrors(): array
    {
        return $this->errors;
    }

    public function validate(): bool
    {
        $name = trim($this->pd_name);
        if (!$name) {
            $this->errors['name'] = 'Tên không được để trống.';
        } elseif (!preg_match('/^[\p{L}0-9\s(),]+$/u', $name)) {
            $this->errors['name'] = 'Tên không hợp lệ.';
        }

        $price = trim($this->pd_price);
        if (!$price) {
            $this->errors['price'] = 'Giá không được để trống.';
        } elseif (!is_numeric($price) || $price <= 0) {
            $this->errors['price'] = 'Giá không hợp lệ.';
        }

        $info = trim($this->pd_info);
        if (!$info) {
            $this->errors['info'] = 'Thông tin không được để trống.';
        }

        return empty($this->errors);
    }

    public function all(): array
    {
        $products = [];

        $statement = $this->db->prepare('SELECT * FROM products ORDER BY pd_id DESC');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $product = new Product($this->db);
            $product->fillFromDB($row);
            $products[] = $product;
        }

        return $products;
    }

    protected function fillFromDB(array $row): Product
    {
        [
            'pd_id' => $this->pd_id,
            'pd_name' => $this->pd_name,
            'pd_price' => $this->pd_price,
            'pd_info' => $this->pd_info,
            'pd_image' => $this->pd_image,
            'cat_id' => $this->cat_id,
            'pd_sizes' => $this->pd_sizes
        ] = $row;

        return $this;
    }

    // Tìm sản phẩm với id
    public function find(int $id): ?Product
    {
        $statement = $this->db->prepare('SELECT * FROM products WHERE pd_id = :id');
        $statement->execute(['id' => $id]);

        if ($row = $statement->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }

        return null;
    }

    // Lưu thông tin sản phẩm (thêm/cập nhật)
    public function save(): bool
    {
        $result = false;

        if ($this->pd_id >= 0) {
            $statement = $this->db->prepare('UPDATE products 
                SET pd_name = :name, pd_price = :price, pd_info = :info, 
                pd_image = :image, cat_id = :cat_id, pd_sizes = :pd_sizes WHERE pd_id = :pd_id');
            $result = $statement->execute([
                'name' => $this->pd_name,
                'price' => $this->pd_price,
                'info' => $this->pd_info,
                'image' => $this->pd_image,
                'cat_id' => $this->cat_id,
                'pd_sizes' => $this->pd_sizes,
                'pd_id' => $this->pd_id
            ]);
        } else {
            $statement = $this->db->prepare('INSERT INTO products(pd_name, pd_price, pd_info, pd_image, cat_id, pd_sizes) 
                VALUES (:name, :price, :info, :image, :cat_id, :pd_sizes)');
            $result = $statement->execute([
                'name' => $this->pd_name,
                'price' => $this->pd_price,
                'info' => $this->pd_info,
                'image' => $this->pd_image,
                'cat_id' => $this->cat_id,
                'pd_sizes' => $this->pd_sizes
            ]);

            if ($result) {
                $this->pd_id = $this->db->lastInsertId();
            }
        }

        return $result;
    }

    // Cập nhật sản phẩm
    public function update(array $data): bool
    {
        $this->fill($data);
        if ($this->validate()) {
            return $this->save();
        }
        return false;
    }

    // Xóa sản phẩm
    public function delete(): bool
    {
        $statement = $this->db->prepare('DELETE FROM products WHERE pd_id = ?');
        return $statement->execute([$this->pd_id]);
    }

    // Đếm số lượng sản phẩm
    public function count($cat_id, ?float $minPrice = null, ?float $maxPrice = null, array $keywords = [], bool $isNew = false, ?string $size = null): int
    {
        $sql = 'SELECT count(*) FROM products WHERE 1=1';
        $params = [];

        if ($isNew) {
            $sql .= ' AND is_new = 1';
        }

        if ($cat_id !== -1) {
            $sql .= ' AND cat_id = :cat_id';
            $params[':cat_id'] = $cat_id;
        }

        if ($size !== null && $size !== '') {
            $sql .= ' AND FIND_IN_SET(:size, pd_sizes) > 0';
            $params[':size'] = $size;
        }

        if ($minPrice !== null) {
            $sql .= ' AND pd_price >= :min_price';
            $params[':min_price'] = $minPrice;
        }

        if ($maxPrice !== null) {
            $sql .= ' AND pd_price <= :max_price';
            $params[':max_price'] = $maxPrice;
        }

        if (!empty($keywords)) {
            $searchParts = [];
            foreach (array_values($keywords) as $index => $keyword) {
                $termKey = ':keyword_' . $index;
                $searchParts[] = "(pd_name LIKE $termKey OR pd_info LIKE $termKey)";
                $params[$termKey] = '%' . $keyword . '%';
            }
            $sql .= ' AND (' . implode(' OR ', $searchParts) . ')';
        }

        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        return $statement->fetchColumn();
    }
    
    // Phân trang
    public function paginate(
        int $offset = 0,
        int $limit = 12,
        int $cat_id = -1,
        string $sort = 'newest',
        ?float $minPrice = null,
        ?float $maxPrice = null,
        array $keywords = [],
        bool $isNew = false,
        ?string $size = null
    ): array
    {
        $products = [];
        $orderBy = match ($sort) {
            'name_asc' => 'pd_name ASC',
            'name_desc' => 'pd_name DESC',
            'price_asc' => 'pd_price ASC',
            'price_desc' => 'pd_price DESC',
            default => 'pd_id DESC'
        };

        $sql = "SELECT * FROM products WHERE 1=1";

        if ($isNew) {
            $sql .= ' AND is_new = 1';
        }

        if ($cat_id !== -1) {
            $sql .= ' AND cat_id = :cat_id';
        }

        if ($size !== null && $size !== '') {
            $sql .= ' AND FIND_IN_SET(:size, pd_sizes) > 0';
        }

        if ($minPrice !== null) {
            $sql .= ' AND pd_price >= :min_price';
        }

        if ($maxPrice !== null) {
            $sql .= ' AND pd_price <= :max_price';
        }

        if (!empty($keywords)) {
            $searchParts = [];
            foreach (array_values($keywords) as $index => $keyword) {
                $termKey = ':keyword_' . $index;
                $searchParts[] = "(pd_name LIKE $termKey OR pd_info LIKE $termKey)";
            }
            $sql .= ' AND (' . implode(' OR ', $searchParts) . ')';
        }

        $sql .= " ORDER BY $orderBy LIMIT :offset, :limit";
        $statement = $this->db->prepare($sql);

        if ($cat_id !== -1) {
            $statement->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
        }

        if ($size !== null && $size !== '') {
            $statement->bindValue(':size', $size);
        }

        if ($minPrice !== null) {
            $statement->bindValue(':min_price', $minPrice);
        }

        if ($maxPrice !== null) {
            $statement->bindValue(':max_price', $maxPrice);
        }

        if (!empty($keywords)) {
            foreach (array_values($keywords) as $index => $keyword) {
                $statement->bindValue(':keyword_' . $index, '%' . $keyword . '%');
            }
        }

        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        while ($row = $statement->fetch()) {
            $product = new Product($this->db);
            $product->fillFromDB($row);
            $products[] = $product;
        }

        return $products;
    }

    // Tìm kiếm
    public function search(string $key): array | bool
    {
        $products = [];

        $statement = $this->db->prepare('SELECT * FROM products WHERE pd_name LIKE :search ORDER BY pd_id DESC');
        $statement->execute([':search' => '%' . $key . '%']);

        // Không tìm thấy kết quả
        if ($statement->rowCount() <= 0) {
            return false;
        }

        while ($row = $statement->fetch()) {
            $product = new Product($this->db);
            $product->fillFromDB($row);
            $products[] = $product;
        }

        return $products;
    }

    // Hiển thị sản phẩm nổi bật ở trang chủ
    public function showHotProducts($catID): array
    {
        $products = [];

        $statement = $this->db->prepare('SELECT * FROM products WHERE cat_id = ? ORDER BY pd_id DESC LIMIT 6');
        $statement->execute([$catID]);
        while ($row = $statement->fetch()) {
            $product = new Product($this->db);
            $product->fillFromDB($row);
            $products[] = $product;
        }

        return $products;
    }

    public function relatedProducts(int $categoryId, int $excludeId, int $limit = 10): array
    {
        $products = [];

        $statement = $this->db->prepare(
            'SELECT * FROM products WHERE cat_id = :cat_id AND pd_id <> :exclude_id ORDER BY pd_id DESC LIMIT :limit'
        );
        $statement->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':exclude_id', $excludeId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        while ($row = $statement->fetch()) {
            $product = new Product($this->db);
            $product->fillFromDB($row);
            $products[] = $product;
        }

        return $products;
    }
}
