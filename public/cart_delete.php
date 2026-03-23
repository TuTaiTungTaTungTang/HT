<?php
require_once __DIR__ . '/../src/bootstrap.php';

use ct523\Project\Cart;

$item = new Cart($PDO);

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id_user']) && isset($_POST['id_pd'])
    && ($item->find((int) $_POST['id_user'], (int) $_POST['id_pd'], (string) ($_POST['pd_size'] ?? ''))) !== null
) {
    $id = $_POST['id_user'];
    $deleted = $item->delete();

    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower((string) $_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    if ($isAjax) {
        echo $deleted ? 'success' : 'unsuccess';
        exit;
    }

    redirect('cart.php?id='.$id.'');
}
redirect('/');
