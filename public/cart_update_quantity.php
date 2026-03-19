<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT27502\Project\Cart;

$item = new Cart($PDO);

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['quantity'])
    && isset($_POST['id_user']) && isset($_POST['id_pd'])
    && ($item->find((int) $_POST['id_user'], (int) $_POST['id_pd'], (string) ($_POST['pd_size'] ?? ''))) !== null
    ){

        $updated = (bool) $item->updateQuantity((int) $_POST['quantity'], (int) $_POST['id_user'], (int) $_POST['id_pd'], (string) ($_POST['pd_size'] ?? ''));
        if ($updated) {
            echo 'success';
            exit;
        }

        if ($item->getLastErrorCode() === 'stock_insufficient') {
            echo 'stock_insufficient';
            exit;
        }

        echo 'unsuccess';
        exit;
    
    }
    echo 'unsuccess';
