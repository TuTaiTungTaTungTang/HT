<?php 
require_once __DIR__ . '/../src/bootstrap.php';
use CT27502\Project\Cart;

$item = new Cart($PDO);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['themgiohang']) && isset($_POST['idsanpham']) && isset($_POST['iduser'])) {
    
    $quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

    $item->fill($_POST);
    if ($item->exist()) {
        $item->plus($quantity);
    } else {
        $item->save($quantity);
    }
    $id = $_POST['iduser'];
    redirect('cart.php?id='.$id.'');
}
redirect('/');
