<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$prefix = $_SERVER['DOCUMENT_ROOT'] . '/';

function checkPizzaAvailable($pizza_name) {

    global $prefix;
    $pizza_filename = $prefix . 'pizza.xml';
    $sxe1 = simplexml_load_file($pizza_filename);

    foreach ($sxe1->children() as $pizza1) {
        if ((String) $pizza1->name[0] == $pizza_name) {
            //check its recipe
            global $prefix;
            $ingredient_filename = $prefix . 'ingredient.xml';
            $sxe2 = simplexml_load_file($ingredient_filename);
            foreach ($pizza1->recipe[0]->ingredient as $ingredient_unit) {
                $ingredient_name = (String) $ingredient_unit->name[0];
                $ingredient_quantity = (Int) $ingredient_unit->quantity[0];
                foreach ($sxe2->children() as $ing) {
                    if ((String) $ing->name[0] == $ingredient_name) {
                        if ((Int) $ing->quantity[0] < $ingredient_quantity) {
                            return false;
                        }
                    }
                }
            }
        }
    }

    return true;
}

function viewPizzas_content() {
    //
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'><table id=\'pizzasList\'>
                    <tr>
                        <th>Pizza`s name</th>
                        <th>Flavor</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Sold</th>
                        <th></th>
                    </tr>';
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $pizza) {
        $pizza_name = (String) $pizza->name[0];
        //check if this kind of pizza is available or not
        if (checkPizzaAvailable($pizza_name)) {

            echo '<tr>';
            echo '<td>' . $pizza_name . '</td>';
            echo '<td>' . (String) $pizza->flavor[0] . '</td>';
            echo '<td>' . (String) $pizza->price[0] . '</td>';
            echo '<td>' . (String) $pizza->description[0] . '</td>';
            echo '<td>' . (String) $pizza->soldout[0] . '</td>';
            echo '<td><input type=\'button\' value=\'buy\' name=' . $pizza_name . '_buy></td>';
            echo '</tr>';
        }
    }
    echo '</table>';

    echo '<div id="order_pizza_panel">
                    <form>
                        <fieldset>
                            <legend>Please input the pizza`s number you would like to buy</legend><br>
                            <span>Pizza Name:</span> <span id=\'name_input\'>The pizza`s name</span><br>
                            <span>Flavor:</span> <span id=\'flavor_input\'>The pizza`s flavor</span><br>
                            <span>Price:</span> <span id=\'price_input\'>The pizza`s price</span><br>
                            <span>Description:</span> <span id=\'description_input\'>The pizza`s description</span><br>
                            <span>Quantity:</span> <input id="quantity_input" type="text"><br>
                        </fieldset>
                    </form>
                    <input id="save" type="button" value="save">
                    <input id="cancel" type="button" value="cancel">
                    <div id="warning">
                        <img src="images/warning.jpg" alt="">
                        <p>Warning Message</p>
                    </div>
                </div>';
}

function checkOut_content() {
    echo '<div id="buy_order_panel">
                    <form>
                        <fieldset>
                            <legend>Shipping Information</legend><br>
                            <span>User Name:</span> <span id=username_input>';
    echo $_SESSION['username'] . '</span><br>
                            <span>Full Name:</span> <input type=text id=fullname_input><br>
                            <span>Address:</span> <input type=text id=address_input><br>
                            <span>Zip:</span> <input type=text id=zip_input><br>
                            <span>City:</span> <input id="city_input" type="text"><br>
                            <span>Email:</span> <input type=text id=email_input>
                        </fieldset>
                    </form>
                    <input id="purchase" type="button" value="purchase order">
                    <input id=\'reset\' type=\'button\' value=\'reset\'>
                    <input id="cancel" type="button" value="cancel">
                    <h1>The pizza list</h1>
                    <table id=\'pizzasList\'>
                        <tr>
                            <th>Pizza Name</th>
                            <th>Quantity</th>
                            <th></th>
                        </tr>';
    //iterate each pizza in the shopping cart
    $shoppingcart = $_SESSION['shoppingcart'];
    for ($i = 0; $i < count($shoppingcart); ++$i) {
        //
        echo '<tr>';
        echo '<td>' . (String) $shoppingcart[$i]['name'] . '</td>';
        echo '<td>' . (String) $shoppingcart[$i]['quantity'] . '</td>';
        echo '<td><input type=button name=' . (String) $shoppingcart[$i]['name'] . '_delete value=delete></td>';
        echo '</tr>';
    }

    echo '</table>
                </div>';
}
/*
function viewShoppingcart_content() {
    //output the shoppingcart
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'><table id=\'pizzasList\'>
                    <tr>
                        <th>Pizza`s name</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>';
    if (isset($_SESSION['shoppingcart'])) {
        $shoppingcart = $_SESSION['shoppingcart'];
        for ($i = 0; $i < count($shoppingcart); ++$i) {
            //
            echo '<tr>';
            echo '<td>' . (String) $shoppingcart[$i]['name'] . '</td>';
            echo '<td>' . (String) $shoppingcart[$i]['quantity'] . '</td>';
            echo '<td><input type=button value=delete name=' . (String) $shoppingcart[$i]['name'] . '_delete></td>';
            echo '</tr>';
        }
    }
    echo '</table>';
}*/
/*
function pizzasRank_content() {
    //
    //out put the pizzas rank
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'><table id=\'pizzasList\'>
                    <tr>
                        <th></th>
                        <th>Pizza`s name</th>
                        <th>Flavor</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Sold</th>
                    </tr>';
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename)->children();
    $rank = 0;

    //since the tablesorter doesn`t work, so I need to sort the data here manully
    $pizza_record_list = array();
    foreach ($sxe as $pizza) {
        //put each pizza record into a list and then sort them according to their soldout
        $pizza_record_list[$rank]['name'] = (String) $pizza->name[0];
        $pizza_record_list[$rank]['soldout'] = (Int) $pizza->soldout[0];
        $pizza_record_list[$rank]['flavor'] = (String) $pizza->flavor[0];
        $pizza_record_list[$rank]['price'] = (String) $pizza->price[0];
        $pizza_record_list[$rank]['description'] = (String) $pizza->description[0];
        $rank++;
    }
    //sort the pizza_record_list
    for ($i = 0; $i < count($pizza_record_list); ++$i) {
        //global $pizza_record_list;
        $max_index = $i;
        for ($j = $i; $j < count($pizza_record_list); ++$j) {
            if ($pizza_record_list[$j]['soldout'] > $pizza_record_list[$max_index]['soldout']) {
                $max_index = $j;
            }
        }
        //exchange
        $temp = $pizza_record_list[$i];
        $pizza_record_list[$i] = $pizza_record_list[$max_index];
        $pizza_record_list[$max_index] = $temp;
    }
    $rank = 1;
    foreach ($pizza_record_list as $pizza) {
        $pizza_name = (String) $pizza['name'];
        echo '<tr>';
        echo '<td>' . (String) $rank . '</td>';
        echo '<td>' . $pizza_name . '</td>';
        echo '<td>' . (String) $pizza['flavor'] . '</td>';
        echo '<td>' . (String) $pizza['price'] . '</td>';
        echo '<td>' . (String) $pizza['description'] . '</td>';
        echo '<td>' . (Int) $pizza['soldout'] . '</td>';
        echo '</tr>';
        $rank++;
    }
    echo '</table>';
}*/

function viewOrders_content() {
    if (!isset($_SESSION['username'])) {
        echo 'Please login first';
        return;
    }
    $username = $_SESSION['username'];
    global $prefix;
    $filename = $prefix . 'order.xml';
    $sxe = simplexml_load_file($filename);
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'>';
    foreach ($sxe->children() as $order) {
        //
        if ((String) $order->username[0] == $username) {
            echo '<table class=\'orderInfor\'>
                    <tr>
                        <th>Order ID</th>
                        <th>Full name</th>
                        <th>Address</th>
                        <th>Zip</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>';
            echo '<tr>';
            echo '<td>' . (String) $order->id[0] . '</td>';
            echo '<td>' . (String) $order->fullname[0] . '</td>';
            echo '<td>' . (String) $order->address[0] . '</td>';
            echo '<td>' . (String) $order->zip[0] . '</td>';
            echo '<td>' . (String) $order->city[0] . '</td>';
            echo '<td>' . (String) $order->email[0] . '</td>';
            echo '<td>' . (String) $order->status[0] . '</td>';
            echo '</tr>';
            echo '</table>';

            //output the pizzas list
            echo '<table class=\'orderInfor small\'>
                    <tr>
                        <th>Pizza Name</th>
                        <th>Quantity</th>
                    </tr>';
            foreach ($order->pizza as $pizzaInfor) {
                echo '<tr>';
                echo '<td>' . (String) $pizzaInfor->name[0] . '</td>';
                echo '<td>' . (String) $pizzaInfor->quantity[0] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<input type=button value=accept name='.(String)$order->id[0].'_accept>';
        }
    }
}

function home_content(){
    //output the content of the customer`s home page
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'>';
    //left panel
    echo '<div id=left>';
    
    echo '<table class=\'pizzasList\'>
                    <tr>
                        <th>Pizza`s name</th>
                        <th>Flavor</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Sold</th>
                        <th></th>
                    </tr>';
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $pizza) {
        $pizza_name = (String) $pizza->name[0];
        //check if this kind of pizza is available or not
        if (checkPizzaAvailable($pizza_name)) {

            echo '<tr>';
            //echo '<td>' . $pizza_name . '</td>';
            echo '<td>'.$pizza_name;
            //output the ingredients` list tooltip
            echo '<ul class=tooltip>';
            echo '<li>ingredients:</li>';
            foreach($pizza->recipe[0]->ingredient as $ingredient){
                echo '<li>'.$ingredient->name[0].'</li>';
            }
            echo '</ul>';
            echo '</td>';
            echo '<td>' . (String) $pizza->flavor[0] . '</td>';
            echo '<td>' . (String) $pizza->price[0] . '</td>';
            echo '<td>' . (String) $pizza->description[0] . '</td>';
            echo '<td>' . (String) $pizza->soldout[0] . '</td>';
            echo '<td><input type=\'button\' value=\'buy\' name=' . $pizza_name . '_buy></td>';
            echo '</tr>';
        }
    }
    echo '</table>';
    
    echo '<div id="order_pizza_panel">
                    <form>
                        <fieldset>
                            <legend>Please input the pizza`s number you would like to buy</legend><br>
                            <span>Pizza Name:</span> <span id=\'name_input\'>The pizza`s name</span><br>
                            <span>Flavor:</span> <span id=\'flavor_input\'>The pizza`s flavor</span><br>
                            <span>Price:</span> <span id=\'price_input\'>The pizza`s price</span><br>
                            <span>Description:</span> <span id=\'description_input\'>The pizza`s description</span><br>
                            <span>Quantity:</span> <input id="quantity_input" type="text"><br>
                        </fieldset>
                    </form>
                    <input id="save" type="button" value="save">
                    <input id="cancel" type="button" value="cancel">
                    <div id="warning">
                        <img src="images/warning.jpg" alt="">
                        <p>Warning Message</p>
                    </div>
                </div>';
    
    echo '</div>';
    //right panel
    echo '<div id=right>';
    echo '<h1>Shoppingcart</h1>';
    echo '<table class=\'pizzasList\'>
                    <tr>
                        <th>Pizza`s name</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>';
    if (isset($_SESSION['shoppingcart'])) {
        $shoppingcart = $_SESSION['shoppingcart'];
        for ($i = 0; $i < count($shoppingcart); ++$i) {
            //
            echo '<tr>';
            echo '<td>' . (String) $shoppingcart[$i]['name'] . '</td>';
            echo '<td>' . (String) $shoppingcart[$i]['quantity'] . '</td>';
            echo '<td><input type=button value=delete name=' . (String) $shoppingcart[$i]['name'] . '_delete></td>';
            echo '</tr>';
        }
    }
    echo '</table>';
    
    echo '<h1>Pizzas Rank</h1>';
    echo '<table class=\'pizzasList\'>
                    <tr>
                        <th></th>
                        <th>Pizza`s name</th>
                        <th>Sold</th>
                    </tr>';
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename)->children();
    $rank = 0;

    //since the tablesorter doesn`t work, so I need to sort the data here manully
    $pizza_record_list = array();
    foreach ($sxe as $pizza) {
        //put each pizza record into a list and then sort them according to their soldout
        $pizza_record_list[$rank]['name'] = (String) $pizza->name[0];
        $pizza_record_list[$rank]['soldout'] = (Int) $pizza->soldout[0];
        $pizza_record_list[$rank]['flavor'] = (String) $pizza->flavor[0];
        $pizza_record_list[$rank]['price'] = (String) $pizza->price[0];
        $pizza_record_list[$rank]['description'] = (String) $pizza->description[0];
        $rank++;
    }
    //sort the pizza_record_list
    for ($i = 0; $i < count($pizza_record_list); ++$i) {
        //global $pizza_record_list;
        $max_index = $i;
        for ($j = $i; $j < count($pizza_record_list); ++$j) {
            if ($pizza_record_list[$j]['soldout'] > $pizza_record_list[$max_index]['soldout']) {
                $max_index = $j;
            }
        }
        //exchange
        $temp = $pizza_record_list[$i];
        $pizza_record_list[$i] = $pizza_record_list[$max_index];
        $pizza_record_list[$max_index] = $temp;
    }
    $rank = 1;
    foreach ($pizza_record_list as $pizza) {
        $pizza_name = (String) $pizza['name'];
        echo '<tr>';
        echo '<td>' . (String) $rank . '</td>';
        echo '<td>' . $pizza_name . '</td>';
        echo '<td>' . (Int) $pizza['soldout'] . '</td>';
        echo '</tr>';
        $rank++;
    }
    echo '</table>';
    
    echo '</div>';
}

$action = $_GET['content'];
switch ($action) {
    case 'viewPizzas':
        viewPizzas_content();
        break;
    case 'checkOut':
        checkOut_content();
        break;
    case 'viewShoppingcart':
        viewShoppingcart_content();
        break;
    case 'pizzasRank':
        pizzasRank_content();
        break;
    case 'viewOrders':
        viewOrders_content();
        break;
    case 'home':
        home_content();
        break;
    default:
        break;
}
?>
