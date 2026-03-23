<?php
session_start();

require_once __DIR__ . '/../src/bootstrap.php';

if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin') {
    redirect('/');
}

use ct523\Project\Order;

$order = new Order($PDO);

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['order_code'])
    && ($order->find($_POST['order_code'])) !== null
) {
    
    $order->delete($_POST);
    $_SESSION['flash_message'] = 'Xóa đơn hàng thành công';
    redirect('order_list.php');
}
redirect('/');

