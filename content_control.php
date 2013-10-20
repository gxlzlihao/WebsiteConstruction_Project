<?php

$prefix = $_SERVER['DOCUMENT_ROOT'] . '/';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function newAdmin_content() {
    //return the content required for new admin`s registering
    echo '<div id="new_user_panel">
                    <form>
                        <fieldset>
                            <legend>New Administrator`s Personal Information</legend>
                            <span>User Name:</span> <input id="username_new_input" type="text"><br>
                            <span>Password:</span> <input id="password_new_input" type="password"><br>
                            <span>Confirm Password:</span> <input id="password_confirm_input" type="password"><br>
                            <span>Full name:</span> <input id="fullname_input" type="text"><br>
                            <span>Street and number:</span> <input id="address_input" type="text"><br>
                            <span>Postal code:</span> <input id="zip_input" type="text"><br>
                            <span>City:</span> <input id="city_input" type="text"><br>
                            <span>Email:</span> <input id="email_input" type="text">
                        </fieldset>
                    </form>
                    <input id="register" type="button" value="register">
                    <input id="reset" type="button" value="reset">
                    <div id="warning">
                        <img src="images/warning.jpg" alt="">
                        <p>Warning Message</p>
                    </div>
                </div>';
}

function newIngredient_content() {
    echo '<div id="new_ingredient_panel">
                    <form>
                        <fieldset>
                            <legend>New Ingredient`s Information</legend>
                            <span>Ingredient`s Name:</span> <input id="name_input" type="text"><br>
                            <span>Quantity:</span> <input id="quantity_input" type="text"><br>
                            <span>Price:</span> <input id="price_input" type="text"><br>
                            <span id=\'des\'>Description:</span> <textarea id="description_input" col=20></textarea>
                        </fieldset>
                    </form>
                    <input id="save" type="button" value="save">
                    <input id="reset" type="button" value="reset">
                    <div id="warning">
                        <img src="images/warning.jpg" alt="">
                        <p>Warning Message</p>
                    </div>
                </div>';
}

function ingredientsList_content() {
    //
    global $prefix;
    $filename = $prefix . 'ingredient.xml';

    echo '<table id=\'ingredientsList\'>
                    <tr>
                        <th>Ingredient`s name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Operation</th>
                    </tr>';

    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $ingredient) {
        $name0 = (String) $ingredient->name[0];
        echo '<tr>';
        echo '<td>' . (String) $ingredient->name[0] . '</td>';
        echo '<td>' . (String) $ingredient->price[0] . '</td>';
        echo '<td>' . (String) $ingredient->description[0] . '</td>';
        echo '<td><input type=button value=\'-\' name=' . $name0 . '_minus><input type=text value=' . (String) $ingredient->quantity[0] . '><input type=button value=\'+\' name=' . $name0 . '_plus></td>';
        echo '<td><input type=button value=edit name=' . $name0 . '_edit><input type=button value=delete name=' . $name0 . '_delete></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<input type=button value=\'new ingredient\' name=add_new>';
    
    //output the warning sign
    echo '<div id="warning">
                        <img src="images/warning.jpg" alt="">
                        <p>Warning Message</p>
                    </div>';
}

function administratorsList_content() {
    global $prefix;
    $filename = $prefix . 'user.xml';
    $sxe = simplexml_load_file($filename)->children();
    echo '<table id=\'administratorsList\'>
                    <tr>
                        <th>User name</th>
                        <th>Full name</th>
                        <th>Address</th>
                        <th>Zip</th>
                        <th>City</th>
                        <th>Email</th>
                    </tr>';
    foreach ($sxe as $user) {
        if ((String) $user->role[0] === 'admin') {
            echo '<tr>';
            echo '<td>' . (String) $user->username[0] . '</td>';
            echo '<td>' . (String) $user->fullname[0] . '</td>';
            echo '<td>' . (String) $user->address[0] . '</td>';
            echo '<td>' . (String) $user->zip[0] . '</td>';
            echo '<td>' . (String) $user->city[0] . '</td>';
            echo '<td>' . (String) $user->email[0] . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';
}

function newPizza_content(){
    global $prefix;
    $filename = $prefix . 'ingredient.xml';
    
    echo '<div id="new_pizza_panel">
                    <img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'>
                    <form>
                        <fieldset>
                            <legend>New Pizza`s Information</legend>
                            <span>Pizza`s Name:</span> <input id="name_input" type="text"><br>
                            <span>Flavor:</span> <input id="flavor_input" type="text"><br>
                            <span>Price:</span> <input id="price_input" type="text"><br>
                            <span id=\'des\'>Description:</span> <textarea id="description_input" col=20></textarea>
                        </fieldset>
                    </form>
                    <input id="save" type="button" value="save">
                    <input id="reset" type="button" value="reset">
                    <input id=\'calculate_price\' type=\'button\' value=\'calculate_price\'>
                    <h1>Please choose the recipes</h1>
                    <table id=\'ingredientsList\'>
                        <tr>
                            <th>name</th>
                            <th>stock</th>
                            <th>price</th>
                            <th>description</th>
                            <th>quantity</th>
                        </tr>';
    //echo ingredients` list
    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $ingredient) {
        $name0 = (String) $ingredient->name[0];
        echo '<tr>';
        echo '<td>' . (String) $ingredient->name[0] . '</td>';
        echo '<td>' . (String) $ingredient->quantity[0].'</td>';
        echo '<td>' . (String) $ingredient->price[0] . '</td>';
        echo '<td>' . (String) $ingredient->description[0] . '</td>';
        echo '<td><input type=text value=0 name='.$name0.'_number></td>';
        echo '</tr>';
    }
    
    echo '</table>
                </div>';
}

function editPizza_content(){
    global $prefix;
    $filename = $prefix . 'ingredient.xml';
    
    echo '<div id="new_pizza_panel">
                    <img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'>
                    <form>
                        <fieldset>
                            <legend>New Pizza`s Information</legend>
                            <span>Pizza`s Name:</span> <span id="name_input"></span><br>
                            <span>Flavor:</span> <input id="flavor_input" type="text"><br>
                            <span>Price:</span> <input id="price_input" type="text"><br>
                            <span id=\'des\'>Description:</span> <textarea id="description_input" col=20></textarea>
                        </fieldset>
                    </form>
                    <input id="save" type="button" value="save">
                    <input id="reset" type="button" value="reset">
                    <input id="cancel" type="button" value="cancel">
                    <input id=\'calculate_price\' type=\'button\' value=\'calculate_price\'>
                    <h1>Please choose the recipes</h1>
                    <table id=\'ingredientsList\'>
                        <tr>
                            <th>name</th>
                            <th>stock</th>
                            <th>price</th>
                            <th>description</th>
                            <th>quantity</th>
                        </tr>';
    //echo ingredients` list
    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $ingredient) {
        $name0 = (String) $ingredient->name[0];
        echo '<tr>';
        echo '<td>' . (String) $ingredient->name[0] . '</td>';
        echo '<td>' . (String) $ingredient->quantity[0].'</td>';
        echo '<td>' . (String) $ingredient->price[0] . '</td>';
        echo '<td>' . (String) $ingredient->description[0] . '</td>';
        echo '<td><input type=text value=0 name='.$name0.'_number></td>';
        echo '</tr>';
    }
    
    echo '</table>
                </div>';
}

function pizzasList_content(){
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'><table id=\'pizzasList\'>
                    <tr>
                        <th>Pizza`s name</th>
                        <th>Flavor</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Sold</th>
                        <th>Operation</th>
                    </tr>';
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename)->children();
    foreach($sxe as $pizza){
        $pizza_name = (String)$pizza->name[0];
        echo '<tr>';
        echo '<td>'.$pizza_name.'</td>';
        echo '<td>'.(String)$pizza->flavor[0].'</td>';
        echo '<td>'.(String)$pizza->price[0].'</td>';
        echo '<td>'.(String)$pizza->description[0].'</td>';
        echo '<td>'.(String)$pizza->soldout[0].'</td>';
        echo '<td><input type=\'button\' value=\'edit\' name='.$pizza_name.'_edit><input type=button value=delete name='.$pizza_name.'_delete></td>';
        echo '</tr>';
    }
    echo '</table>';
}

function pizzasRank_content(){
    //out put the pizzas rank
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'><table id=\'pizzasList\'>
                    <tr>
                        <th></th>
                        <th>Pizza`s name</th>
                        <th>Flavor</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Soldout</th>
                    </tr>';
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename)->children();
    $rank=0;
    
    //since the tablesorter doesn`t work, so I need to sort the data here manully
    $pizza_record_list = array();
    foreach($sxe as $pizza){
        //put each pizza record into a list and then sort them according to their soldout
        $pizza_record_list[$rank]['name']=(String)$pizza->name[0];
        $pizza_record_list[$rank]['soldout']=(Int)$pizza->soldout[0];
        $pizza_record_list[$rank]['flavor']=(String)$pizza->flavor[0];
        $pizza_record_list[$rank]['price']=(String)$pizza->price[0];
        $pizza_record_list[$rank]['description']=(String)$pizza->description[0];
        $rank++;
    }
    //sort the pizza_record_list
    for($i=0;$i<count($pizza_record_list);++$i){
        //global $pizza_record_list;
        $max_index = $i;
        for($j=$i;$j<count($pizza_record_list);++$j){
            if($pizza_record_list[$j]['soldout']>$pizza_record_list[$max_index]['soldout']){
                $max_index = $j;
            }
        }
        //exchange
        $temp = $pizza_record_list[$i];
        $pizza_record_list[$i]=$pizza_record_list[$max_index];
        $pizza_record_list[$max_index]=$temp;
    }
    $rank=1;
    foreach($pizza_record_list as $pizza){
        $pizza_name = (String)$pizza['name'];
        echo '<tr>';
        echo '<td>'.(String)$rank.'</td>';
        echo '<td>'.$pizza_name.'</td>';
        echo '<td>'.(String)$pizza['flavor'].'</td>';
        echo '<td>'.(String)$pizza['price'].'</td>';
        echo '<td>'.(String)$pizza['description'].'</td>';
        echo '<td>'.(Int)$pizza['soldout'].'</td>';
        echo '</tr>';
        $rank++;
    }
    echo '</table>';
}

function viewOrders_content(){
    //
    global $prefix;
    $filename = $prefix . 'order.xml';
    $sxe = simplexml_load_file($filename);
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'>';
    foreach ($sxe->children() as $order) {
        //
        if ($order->status[0]!='deliverying') {
            echo '<table class=\'orderInfor\'>
                    <tr>
                        <th>Order ID</th>
                        <th>User name</th>
                        <th>Full name</th>
                        <th>Address</th>
                        <th>Zip</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>';
            echo '<tr>';
            echo '<td>'.(String)$order->id[0].'</td>';
            $order_id = (String)$order->id[0];
            echo '<td>'.(String)$order->username[0].'</td>';
            echo '<td>'.(String)$order->fullname[0].'</td>';
            echo '<td>'.(String)$order->address[0].'</td>';
            echo '<td>'.(String)$order->zip[0].'</td>';
            echo '<td>'.(String)$order->city[0].'</td>';
            echo '<td>'.(String)$order->email[0].'</td>';
            echo '<td>'.(String)$order->status[0].'</td>';
            echo '</tr>';
            echo '</table>';
            
            //output the pizzas list
            echo '<table class=\'orderInfor small\'>
                    <tr>
                        <th>Pizza Name</th>
                        <th>Quantity</th>
                    </tr>';
            foreach($order->pizza as $pizzaInfor){
                echo '<tr>';
                echo '<td>'.(String)$pizzaInfor->name[0].'</td>';
                echo '<td>'.(String)$pizzaInfor->quantity[0].'</td>';
                echo '</tr>';
            }
            echo '</table>';
            if((String)$order->status[0]=='waiting')
                echo '<input type=button value=cook name='.$order_id.'_cook>';
            elseif((String)$order->status[0]=='ready')
                echo '<input type=button value=delivery name='.$order_id.'_delivery>';
        }
    }
}

function home_content(){
    //output the home page`s content
    
    echo '<img id=\'pizza_background\' src=\'images/pizza_weitress.jpg\' alt=\'\'>';
    echo '<div id=left>';
    //the left panel consists of the orders list
    global $prefix;
    $filename = $prefix . 'order.xml';
    $sxe = simplexml_load_file($filename);
    foreach ($sxe->children() as $order) {
        //
        if ($order->status[0]!='deliverying') {
            echo '<table class=\'orderInfor\'>
                    <tr>
                        <th>Order ID</th>
                        <th>User name</th>
                        <th>Full name</th>
                        <th>Address</th>
                        <th>Zip</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>';
            echo '<tr>';
            echo '<td>'.(String)$order->id[0].'</td>';
            $order_id = (String)$order->id[0];
            echo '<td>'.(String)$order->username[0].'</td>';
            echo '<td>'.(String)$order->fullname[0].'</td>';
            echo '<td>'.(String)$order->address[0].'</td>';
            echo '<td>'.(String)$order->zip[0].'</td>';
            echo '<td>'.(String)$order->city[0].'</td>';
            echo '<td>'.(String)$order->email[0].'</td>';
            echo '<td>'.(String)$order->status[0].'</td>';
            echo '</tr>';
            echo '</table>';
            
            //output the pizzas list
            echo '<table class=\'orderInfor small\'>
                    <tr>
                        <th>Pizza Name</th>
                        <th>Quantity</th>
                    </tr>';
            foreach($order->pizza as $pizzaInfor){
                echo '<tr>';
                echo '<td>'.(String)$pizzaInfor->name[0].'</td>';
                echo '<td>'.(String)$pizzaInfor->quantity[0].'</td>';
                echo '</tr>';
            }
            echo '</table>';
            if((String)$order->status[0]=='waiting')
                echo '<input type=button value=cook name='.$order_id.'_cook>';
            elseif((String)$order->status[0]=='ready')
                echo '<input type=button value=delivery name='.$order_id.'_delivery>';
        }
    }
    
    echo '</div>';
    echo '<div id=right>';
    //the right panel consists of the ingredients list and the pizzas rank
    $ingredient_filename = $prefix . 'ingredient.xml';
    echo '<h1>Ingredients` List</h1>';
    echo '<table id=\'ingredientsList\'>
                    <tr>
                        <th>Ingredient`s name</th>
                        <th>Quantity</th>
                    </tr>';

    $sxe = simplexml_load_file($ingredient_filename)->children();
    foreach ($sxe as $ingredient) {
        $name0 = (String) $ingredient->name[0];
        echo '<tr>';
        echo '<td>' . (String) $ingredient->name[0] . '</td>';
        echo '<td>' . (String) $ingredient->quantity[0] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    //pizzas rank
    echo '<h1>Pizzas` Rank</h1>';
    echo '<table id=\'pizzasList\'>
                    <tr>
                        <th></th>
                        <th>Pizza`s name</th>
                        <th>Sold</th>
                    </tr>';
    $pizza_filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($pizza_filename)->children();
    $rank=0;
    
    //since the tablesorter doesn`t work, so I need to sort the data here manully
    $pizza_record_list = array();
    foreach($sxe as $pizza){
        //put each pizza record into a list and then sort them according to their soldout
        $pizza_record_list[$rank]['name']=(String)$pizza->name[0];
        $pizza_record_list[$rank]['soldout']=(Int)$pizza->soldout[0];
        $pizza_record_list[$rank]['flavor']=(String)$pizza->flavor[0];
        $pizza_record_list[$rank]['price']=(String)$pizza->price[0];
        $pizza_record_list[$rank]['description']=(String)$pizza->description[0];
        $rank++;
    }
    //sort the pizza_record_list
    for($i=0;$i<count($pizza_record_list);++$i){
        //global $pizza_record_list;
        $max_index = $i;
        for($j=$i;$j<count($pizza_record_list);++$j){
            if($pizza_record_list[$j]['soldout']>$pizza_record_list[$max_index]['soldout']){
                $max_index = $j;
            }
        }
        //exchange
        $temp = $pizza_record_list[$i];
        $pizza_record_list[$i]=$pizza_record_list[$max_index];
        $pizza_record_list[$max_index]=$temp;
    }
    $rank=1;
    foreach($pizza_record_list as $pizza){
        $pizza_name = (String)$pizza['name'];
        echo '<tr>';
        echo '<td>'.(String)$rank.'</td>';
        echo '<td>'.$pizza_name.'</td>';
        echo '<td>'.(Int)$pizza['soldout'].'</td>';
        echo '</tr>';
        $rank++;
    }
    echo '</table>';
    
    echo '</div>';
}

$content = $_GET['content'];
switch ($content) {
    case 'newAdmin':
        newAdmin_content();
        break;
    case 'newIngredient':
        newIngredient_content();
        break;
    case 'viewIngredients':
        ingredientsList_content();
        break;
    case 'viewAdministrators':
        administratorsList_content();
        break;
    case 'newPizza':
        newPizza_content();
        break;
    case 'viewPizzas':
        pizzasList_content();
        break;
    case 'editPizza':
        editPizza_content();
        break;
    case 'pizzasRank':
        pizzasRank_content();
        break;
    case 'viewOrders':
        viewOrders_content();
        break;
    case 'Home':
        home_content();
        break;
    default:
        break;
}
?>
