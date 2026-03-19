<?php 
namespace CT27502\Project;

use PDO;

class Cart
{
    private ?PDO $db;

    
    private $user_id;
    private $pd_id;
    public $pd_name;
    public $pd_price;
    public $pd_image;
    public $pd_size = '';
    public $pd_quantity;
    public $total;
    public $address;
    public $phone;
    private array $errors=[];
    private string $lastErrorCode = '';


    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getIDUser(): int{
    return $this->user_id;
    }

    public function getIDPro(): int{
        return $this->pd_id;
        }

    public function getSize(): string{
        return (string) $this->pd_size;
    }

    public function getLastErrorCode(): string
    {
        return $this->lastErrorCode;
    }

    public function fill(array $data): Cart
    {
        $this->pd_id = $data['idsanpham'] ?? '';;
        $this->user_id = $data['iduser'] ?? '';;
        $requestedSize = isset($data['pd_size']) ? trim((string) $data['pd_size']) : '';
        $this->pd_size = $this->resolveSizeForProduct((int) $this->pd_id, $requestedSize);
        return $this;
    }

    private function resolveSizeForProduct(int $productId, string $requestedSize = ''): string
    {
        $allowedSizes = Product::allowedSizes();
        $requestedSize = trim($requestedSize);
        if ($requestedSize !== '' && in_array($requestedSize, $allowedSizes, true)) {
            return $requestedSize;
        }

        if ($productId <= 0) {
            return 'Freezie';
        }

        $statement = $this->db->prepare('SELECT pd_sizes FROM products WHERE pd_id = :pd_id');
        $statement->execute(['pd_id' => $productId]);
        if (!$row = $statement->fetch(PDO::FETCH_ASSOC)) {
            return 'Freezie';
        }

        $sizes = array_filter(array_map('trim', explode(',', (string) ($row['pd_sizes'] ?? ''))));
        foreach ($sizes as $size) {
            if (in_array($size, $allowedSizes, true)) {
                return $size;
            }
        }

        return 'Freezie';
    }

    public function fillUser(array $data): Cart
    {
        $this->user_id = $data['id'] ?? '';;
        return $this;
    }

    public function fillInfo(array $data): Cart
    {
        $this->address= $data['address'] ?? '';;
        $this->phone = $data['phone'] ?? '';;
        $this->user_id = $data['thanhtoan_id_user'];
        return $this;
    }

    public function exist(): int{
        $statement = $this->db->prepare("SELECT pd_id FROM carts WHERE pd_id = ? and user_id = ? and pd_size = ?");
        $statement->execute([$this->pd_id, $this->user_id, $this->pd_size]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if(!$row) return 0;
        else return 1;
    }
    public function save(int $quantity = 1) : int {
        $result = 0;
        $qty = max(1, $quantity);
        if (!$this->canUseQuantity($qty)) {
            return 0;
        }

        $statement = $this->db->prepare("insert into carts (user_id, pd_id, pd_size, pd_quantity) values (:user, :pd, :size, :quantity)");
        $result = $statement->execute([
            'user' =>$this->user_id,
            'pd' =>$this->pd_id,
            'size' => $this->pd_size,
            'quantity' => $qty
        ]);
        if($result)
            $this->pd_quantity = $qty;
        
        return $result;    
        
    }

    public function plus(int $n) : int{
        $result = 0;

        $n = max(1, $n);
        $currentQuantity = $this->getCartQuantity((int) $this->user_id, (int) $this->pd_id, (string) $this->pd_size);
        $nextQuantity = $currentQuantity + $n;
        if (!$this->canUseQuantity($nextQuantity)) {
            return 0;
        }

        $statement = $this->db->prepare("update carts set pd_quantity= pd_quantity + :n where user_id= :user and pd_id= :pd and pd_size = :size");
        $result = $statement->execute([
            'n' => $n,
            'user' =>$this->user_id,
            'pd' =>$this->pd_id,
            'size' => $this->pd_size
            
        ]);
        if($result)
            $this->pd_quantity += $n;

        return $result;    
    }

    public function updateQuantity(int $n, int $u, int $p, string $size = '') : int{
        $result = 0;
        $n = max(1, $n);
        $size = trim($size) !== '' ? trim($size) : $this->pd_size;
        if ($size === '') {
            $size = 'Freezie';
        }

        $this->pd_id = $p;
        $this->user_id = $u;
        $this->pd_size = $this->resolveSizeForProduct((int) $p, $size);
        if (!$this->canUseQuantity($n)) {
            return 0;
        }

        $statement = $this->db->prepare("update carts set pd_quantity=? where user_id= ? and pd_id= ? and pd_size = ?");
        $result = $statement->execute([$n, $u, $p, $this->pd_size]);
        $statement = $this->db->prepare('SELECT * FROM carts where user_id = ? and pd_id = ? and pd_size = ?');
        $statement->execute([$u, $p, $this->pd_size]);
        if ($row = $statement->fetch()) {
            $this->fillFromDB($row);
        }
        return $result;    
    }


    public function all(): array
    {
        $items = [];

        $statement = $this->db->prepare('SELECT * FROM carts where user_id = ?');
        $statement->execute([$this->user_id]);
        while ($row = $statement->fetch()) {
            $item = new Cart($this->db);
            $item->fillFromDB($row);
            $items[] = $item;
        }

        return $items;
    }

    protected function fillFromDB(array $row): Cart
    {
        [
            'user_id' => $this->user_id,
            'pd_id' => $this->pd_id,
            'pd_size' => $this->pd_size,
            'pd_quantity' => $this->pd_quantity
        ] = $row;

        $statement = $this->db->prepare('SELECT pd_name, pd_price, pd_image FROM products where pd_id = ?');
        $statement->execute([$this->pd_id ]);
        
        while ($row = $statement->fetch()) {
           
            $this->pd_name = $row['pd_name']; 
            $this->pd_price = $row['pd_price']; 
            $this->pd_image = $row['pd_image'];
            $this->total = $this->pd_price *  $this->pd_quantity;
        }

        
        return $this;
    }

    public function delete(): bool {
        $statement = $this->db->prepare('DELETE FROM carts WHERE pd_id = ? and user_id = ? and pd_size = ?');
        return $statement->execute([$this->pd_id, $this->user_id, $this->pd_size]);
    }

    public function deleteToAddOrder($user, $pd, string $size = ''): bool {
        $size = trim($size) !== '' ? trim($size) : $this->pd_size;
        if ($size === '') {
            $size = 'Freezie';
        }

        $statement = $this->db->prepare('DELETE FROM carts WHERE pd_id = ? and user_id = ? and pd_size = ?');
        return $statement->execute([$pd, $user, $size]);
    }

    public function clearByUser(int $userId): bool
    {
        $statement = $this->db->prepare('DELETE FROM carts WHERE user_id = ?');
        return $statement->execute([$userId]);
    }

    public function find(int $iduser, int $idpd, string $size = ''): ?Cart
    {
        $size = trim($size);
        if ($size !== '') {
            $statement = $this->db->prepare('select * from carts where user_id = :user and pd_id = :pd and pd_size = :size');
            $statement->execute([
                'user' => $iduser,
                'pd' => $idpd,
                'size' => $size,
            ]);
        } else {
            $statement = $this->db->prepare('select * from carts where user_id = :user and pd_id = :pd order by pd_size limit 1');
            $statement->execute([
                'user' => $iduser,
                'pd' => $idpd,
            ]);
        }

        if ($row = $statement->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }

    public function getValidationErrors(): array
    {
        return $this->errors;
    }

    private function resetLastError(): void
    {
        $this->lastErrorCode = '';
        unset($this->errors['stock']);
    }

    private function setStockError(int $available): void
    {
        $this->lastErrorCode = 'stock_insufficient';
        $this->errors['stock'] = 'Số lượng vượt quá tồn kho hiện tại cho size đã chọn (còn ' . max(0, $available) . ').';
    }

    private function canUseQuantity(int $desiredQuantity): bool
    {
        $this->resetLastError();
        if ($desiredQuantity <= 0) {
            $this->setStockError(0);
            return false;
        }

        $available = $this->getAvailableStock((int) $this->pd_id, (string) $this->pd_size);
        if ($desiredQuantity > $available) {
            $this->setStockError($available);
            return false;
        }

        return true;
    }

    private function getCartQuantity(int $userId, int $productId, string $size): int
    {
        $statement = $this->db->prepare('SELECT pd_quantity FROM carts WHERE user_id = :user_id AND pd_id = :pd_id AND pd_size = :pd_size LIMIT 1');
        $statement->execute([
            'user_id' => $userId,
            'pd_id' => $productId,
            'pd_size' => $size,
        ]);

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            return max(0, (int) ($row['pd_quantity'] ?? 0));
        }

        return 0;
    }

    private function getAvailableStock(int $productId, string $size): int
    {
        if ($productId <= 0 || trim($size) === '') {
            return 0;
        }

        $statement = $this->db->prepare('SELECT quantity FROM product_size_stock WHERE pd_id = :pd_id AND size_code = :size_code LIMIT 1');
        $statement->execute([
            'pd_id' => $productId,
            'size_code' => $size,
        ]);

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            return max(0, (int) ($row['quantity'] ?? 0));
        }

        return 0;
    }


    public function validateInfo(): bool
    { 
        $address = trim($this->address);
        if (!$address) {
            $this->errors['address'] = 'Địa chỉ không hợp lệ.';
        }

        $validPhone = preg_match(
            '/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/',
            $this->phone
        );

        if (!$validPhone) {
            $this->errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

        return empty($this->errors);
    }


}
?>