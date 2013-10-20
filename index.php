<?php
$prefix = $_SERVER['DOCUMENT_ROOT'] . '/';
$user_file = $prefix . 'user.xml';
$pizza_file = $prefix . 'pizza.xml';
$temp_file = $prefix . 'temp.xml';
$order_file = $prefix . 'order.xml';
$ingredient_file = $prefix . 'ingredient.xml';
if (!file_exists($user_file)) {
    $xml = new DOMDocument();
    $xml_root = $xml->createElement('userInformation');
    $xml->appendChild($xml_root);
    $xml->save($user_file);
}
if(!file_exists($pizza_file)){
    $xml = new DOMDocument();
    $xml_root = $xml->createElement('pizzasInfor');
    $xml->appendChild($xml_root);
    $xml->save($pizza_file);
}
if(!file_exists($order_file)){
    $xml = new DOMDocument();
    $xml_root = $xml->createElement('ordersInformation');
    $xml->appendChild($xml_root);
    $xml->save($order_file);
}
if(!file_exists($ingredient_file)){
    $xml = new DOMDocument();
    $xml_root = $xml->createElement('IngredientsInfor');
    $xml->appendChild($xml_root);
    $xml->save($ingredient_file);
}
if(!file_exists($temp_file)){
    $xml = new DOMDocument();
    $xml_root = $xml->createElement('temp');
    $order_count = $xml->createElement('order_count','0');
    $xml->appendChild($xml_root);
    $xml_root->appendChild($order_count);
    $xml->save($temp_file);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/reset.css" rel="stylesheet" />
        <link href="css/general_style.css" rel="stylesheet" />
        <title>Welcome to Pizzeria!</title>
    </head>
    <body>
        <div id="header">
            <img src="images/uulogo.jpg" alt="">
            <img src="images/uppsala_university.jpg" alt="">
        </div>
        <div id="main">
            <h1>Welcome to Hao`s Pizzeria!</h1>
            <a href="login.php">Customer`s Entry</a><br>
            <a href="login_admin.php">Administrator`s Entry</a>
        </div>
        <div id="footer">
            <p>author: Li Hao</p>
            <p>Time: July 2013</p>
            <p>Email: gxlzlihao@gmail.com Telephone;+46-0739051551</p>
        </div>
    </body>
</html>
