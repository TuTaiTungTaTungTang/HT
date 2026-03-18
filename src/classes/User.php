<?php

namespace CT27502\Project;

use PDO;

class User
{
    private ?PDO $db;

    private int $user_id = -1;
    public $user_name;
    public $user_email;
    public $user_role;
    public $user_avatar = '';
    public $user_birthday = '';
    public $user_gender = '';
    public $user_phone = '';
    public $user_address = '';
    public $user_contact_email = '';
    public $user_website = '';
    private $user_psw;
    private array $errors = [];

    public function getID(): int
    {
        return $this->user_id;
    }

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
        ensure_user_profile_columns($this->db);
    }

    public function fill(array $data): User
    {
        $this->user_name = $data['user_name'] ?? '';
        $this->user_email = $data['user_email'] ?? '';
        $this->user_role = $data['user_role'] ?? 'user';
        $this->user_phone = $data['user_phone'] ?? '';
        $this->user_address = $data['user_address'] ?? '';
        $this->user_contact_email = $data['user_contact_email'] ?? '';
        $this->user_website = $data['user_website'] ?? '';
        $this->user_birthday = $data['user_birthday'] ?? '';
        $this->user_gender = $data['user_gender'] ?? '';
        return $this;
    }

    public function getValidationErrors(): array
    {
        return $this->errors;
    }

    public function validate(): bool
    {
        $this->errors = [];
        
        $name = trim($this->user_name);
        if (!$name) {
            $this->errors['user_name'] = 'Tên không được để trống.';
        } elseif (strlen($name) < 3) {
            $this->errors['user_name'] = 'Tên phải có ít nhất 3 ký tự.';
        }

        $email = trim($this->user_email);
        if (!$email) {
            $this->errors['user_email'] = 'Email không được để trống.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['user_email'] = 'Email không hợp lệ.';
        }

        return empty($this->errors);
    }

    public function all(): array
    {
        $users = [];

        $statement = $this->db->prepare('SELECT user_id, user_name, user_email, role AS user_role, user_phone, user_avatar FROM users WHERE role != :role ORDER BY user_id DESC');
        $statement->execute(['role' => 'admin']);
        while ($row = $statement->fetch()) {
            $user = new User($this->db);
            $user->fillFromDB($row);
            $users[] = $user;
        }

        return $users;
    }

    protected function fillFromDB(array $row): User
    {
        [
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'user_role' => $this->user_role,
            'user_phone' => $this->user_phone,
            'user_avatar' => $this->user_avatar
        ] = $row;

        return $this;
    }

    public function find(int $id): ?User
    {
        $statement = $this->db->prepare('SELECT * FROM users WHERE user_id = :id');
        $statement->execute(['id' => $id]);

        if ($row = $statement->fetch()) {
            $this->fillFromDB($row);
            $this->user_birthday = $row['user_birthday'] ?? '';
            $this->user_gender = $row['user_gender'] ?? '';
            $this->user_address = $row['user_address'] ?? '';
            $this->user_contact_email = $row['user_contact_email'] ?? '';
            $this->user_website = $row['user_website'] ?? '';
            return $this;
        }

        return null;
    }

    public function update(int $id): bool
    {
        $statement = $this->db->prepare('UPDATE users SET user_name = :name, user_email = :email, role = :role, user_phone = :phone, user_address = :address, user_contact_email = :contact_email, user_website = :website, user_birthday = :birthday, user_gender = :gender WHERE user_id = :id');
        
        return $statement->execute([
            'id' => $id,
            'name' => $this->user_name,
            'email' => $this->user_email,
            'role' => $this->user_role,
            'phone' => $this->user_phone,
            'address' => $this->user_address,
            'contact_email' => $this->user_contact_email,
            'website' => $this->user_website,
            'birthday' => $this->user_birthday,
            'gender' => $this->user_gender
        ]);
    }

    public function delete(int $id): bool
    {
        $statement = $this->db->prepare('DELETE FROM users WHERE user_id = :id');
        return $statement->execute(['id' => $id]);
    }
}
