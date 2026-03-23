<?php

require_once 'functions.php';
require_once __DIR__ .'/../libraries/Psr4AutoloaderClass.php';

$loader = new Psr4AutoloaderClass;
$loader -> register();

$loader->addNamespace('ct523\Project', __DIR__.'/classes');

try{
    $PDO = (new ct523\Project\PDOFactory())->create([
        'dbhost' =>'localhost',
        'dbname' => 'ct523-project',
        'dbuser' => 'root',
        'dbpass' => ''
    ]);
}catch(Exception $ex){
    echo 'Không thể kết nối tới MySQL, kiểm tra lại username/password.<br>',
    exit("<pre>$ex</pre>");

}

ensure_user_profile_columns($PDO);
ensure_product_size_stock_table($PDO);
ensure_cart_order_size_columns($PDO);