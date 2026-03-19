<?php 
require_once __DIR__ . '/../src/bootstrap.php';
use CT27502\Project\Cart;

$item = new Cart($PDO);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['themgiohang']) && isset($_POST['idsanpham']) && isset($_POST['iduser'])) {
    
    $quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

    $item->fill($_POST);
    $result = false;
    $responseCode = 'unsuccess';
    if ($item->exist()) {
        $result = (bool) $item->plus($quantity);
    } else {
        $result = (bool) $item->save($quantity);
    }

    if ($result) {
        $responseCode = 'success';
    } elseif ($item->getLastErrorCode() === 'stock_insufficient') {
        $responseCode = 'stock_insufficient';
    }

    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower((string) $_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    if ($isAjax) {
        echo $responseCode;
        exit;
    }

    $id = $_POST['iduser'];
    redirect('cart.php?id='.$id.'');
}
redirect('/');
