<?php
session_start();

require_once __DIR__ . '/../src/bootstrap.php';

if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin') {
    redirect('/');
}

use ct523\Project\User;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = (int)$_POST['id'];
    
    $user = new User($PDO);
    
    if($user->delete($userId)) {
        $_SESSION['flash_message'] = 'Xóa người dùng thành công.';
    } else {
        $_SESSION['flash_message'] = 'Không thể xóa người dùng.';
    }
}

redirect('user_list.php');
