<?php 
namespace CT27502\Project;

use PDO;

class Profile 
{

    private ?PDO $db;

    private int $id=-1;
    public $name;
    public $email;
    private string $avatar = '';
    public $birthday = '';
    public $gender = '';
    public $phone = '';
    public $address = '';
    public $contactEmail = '';
    public $website = '';
    private $psw;
    private $role;
    private array $errors=[];

    public function getID(): int {
        return $this->id;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function fill(array $data): Profile
    {
        ensure_user_profile_columns($this->db);

        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->psw = $data['psw'] ?? '';
        
        $statement = $this->db->prepare("SELECT * FROM users WHERE user_email = ? and user_psw = ?");
        $statement->execute([$this->email, $this->psw]);
    
        $result = $statement->fetch();
        
        if ($result && isset($result['role'])) {
            if($result['role'] == 'admin') 
                $this->role = 'admin';
            elseif ($result['role'] == 'user') 
                $this->role = 'user';
            else 
                $this->role = '';
        } else {
            $this->role = '';
        }

        $this->avatar = isset($result['user_avatar']) ? (string) $result['user_avatar'] : '';
        return $this;
    }

    public function getValidationErrors(): array
    {
        return $this->errors;
    }


    public function validateR(string $psw2):bool
    {
    
        $name = trim($this->name);
        if (!$name) {
            $this->errors['name'] = 'Tên không hợp lệ.';
        }

       
        $validEmail = preg_match("/^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i", $this->email);
        if(!$validEmail){
            $this->errors['email'] = "Email không hợp lệ.";
        }

        $statement = $this->db->prepare("SELECT * FROM users WHERE user_email = ?");
        $statement->execute([$this->email]);
        $result = $statement->fetch();
        if($result && count($result) > 0){
            $this->errors['email'] = "Email đã tồn tại.";
        }

        $validPsw = preg_match("/^.{8,32}$/", $this->psw);
        if(!$validPsw) {
            $this->errors['psw'] = "Mật khẩu không hợp lệ.";
        }

        if((string)$this->psw != $psw2)
            $this->errors['psw2'] = 'Mật khẩu không khớp';
        

        return empty($this->errors);
    }

    public function validateL():bool
    {
        ensure_user_profile_columns($this->db);
       
        $statement = $this->db->prepare("SELECT user_id, user_name, user_avatar, role FROM users WHERE user_email = :email and user_psw = :psw");
        $statement->execute([
            'email' =>$this->email,
            'psw'=> $this->psw
        ]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if(!$row)
            $this->errors['psw'] = "Mật khẩu hoặc email không chính xác."; 
        else  {
            
            $this->id = $row['user_id'];
            $this->name = $row['user_name'];
            $this->avatar = isset($row['user_avatar']) ? (string) $row['user_avatar'] : '';
            $this->role = isset($row['role']) ? (string) $row['role'] : 'user';

        }
        
        return empty($this->errors);
    }



    public function save(): bool
    {
        ensure_user_profile_columns($this->db);
        $result = false;
        
        $statement = $this->db->prepare(
            'insert into users (user_name,user_email,user_psw) values (:name, :email, :psw)'
        );
        $result = $statement->execute([
            'name' =>$this->name,
            'email' =>$this->email,
            'psw' =>$this->psw
        ]);

        if ($result) {
            $this->id = $this->db->lastInsertId();
        }
        return $result;
    }

    public function loadById(int $id): bool
    {
        ensure_user_profile_columns($this->db);

        $statement = $this->db->prepare('SELECT user_id, user_name, user_email, role, user_avatar, user_birthday, user_gender, user_phone, user_address, user_contact_email, user_website FROM users WHERE user_id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return false;
        }

        $this->id = (int) $row['user_id'];
        $this->name = (string) $row['user_name'];
        $this->email = (string) $row['user_email'];
        $this->role = (string) $row['role'];
        $this->avatar = isset($row['user_avatar']) ? (string) $row['user_avatar'] : '';
        $this->birthday = isset($row['user_birthday']) ? (string) $row['user_birthday'] : '';
        $this->gender = isset($row['user_gender']) ? (string) $row['user_gender'] : '';
        $this->phone = isset($row['user_phone']) ? (string) $row['user_phone'] : '';
        $this->address = isset($row['user_address']) ? (string) $row['user_address'] : '';
        $this->contactEmail = isset($row['user_contact_email']) ? (string) $row['user_contact_email'] : '';
        $this->website = isset($row['user_website']) ? (string) $row['user_website'] : '';

        return true;
    }

    public function updateAvatar(int $id, string $avatar): bool
    {
        ensure_user_profile_columns($this->db);

        $statement = $this->db->prepare('UPDATE users SET user_avatar = :avatar WHERE user_id = :id');
        $result = $statement->execute([
            'avatar' => $avatar,
            'id' => $id,
        ]);

        if ($result) {
            $this->avatar = $avatar;
        }

        return $result;
    }

    public function fillPersonalInfo(array $data): Profile
    {
        $this->name = trim((string) ($data['name'] ?? $this->name ?? ''));
        $this->birthday = trim((string) ($data['birthday'] ?? $this->birthday ?? ''));
        $this->gender = trim((string) ($data['gender'] ?? $this->gender ?? ''));
        $this->phone = trim((string) ($data['phone'] ?? $this->phone ?? ''));
        $this->address = trim((string) ($data['address'] ?? $this->address ?? ''));
        $this->contactEmail = trim((string) ($data['contact_email'] ?? $this->contactEmail ?? ''));
        $this->website = trim((string) ($data['website'] ?? $this->website ?? ''));

        return $this;
    }

    public function validatePersonalInfo(): bool
    {
        $this->errors = [];

        if ($this->name === '') {
            $this->errors['name'] = 'Họ và tên không được để trống.';
        }

        if ($this->birthday !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->birthday)) {
            $this->errors['birthday'] = 'Ngày sinh không hợp lệ.';
        }

        $validGender = ['', 'male', 'female', 'other'];
        if (!in_array($this->gender, $validGender, true)) {
            $this->errors['gender'] = 'Giới tính không hợp lệ.';
        }

        if ($this->phone !== '' && !preg_match('/^[0-9+\-\s]{8,20}$/', $this->phone)) {
            $this->errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

        if ($this->contactEmail !== '' && !filter_var($this->contactEmail, FILTER_VALIDATE_EMAIL)) {
            $this->errors['contact_email'] = 'Email liên hệ không hợp lệ.';
        }

        if ($this->website !== '' && !filter_var($this->website, FILTER_VALIDATE_URL)) {
            $this->errors['website'] = 'Website không đúng định dạng URL.';
        }

        return empty($this->errors);
    }

    public function updatePersonalInfo(int $id): bool
    {
        ensure_user_profile_columns($this->db);

        $statement = $this->db->prepare(
            'UPDATE users
            SET user_name = :name,
                user_birthday = :birthday,
                user_gender = :gender,
                user_phone = :phone,
                user_address = :address,
                user_contact_email = :contact_email,
                user_website = :website
            WHERE user_id = :id'
        );

        $birthday = $this->birthday === '' ? null : $this->birthday;

        return (bool) $statement->execute([
            'name' => $this->name,
            'birthday' => $birthday,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'contact_email' => $this->contactEmail,
            'website' => $this->website,
            'id' => $id,
        ]);
    }

}