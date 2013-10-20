<?php

session_start();
$prefix = $_SERVER['DOCUMENT_ROOT'] . '/';
$temp_record = $prefix . 'temp.xml';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function addPizzaIntoOrder() {
    if (isset($_SESSION['shoppingcart'])) {
        //
        $shoppingcart = $_SESSION['shoppingcart'];
        $number = count($shoppingcart);
        for ($i = 0; $i < $number; $i++) {
            if ($shoppingcart[$i]['name'] == $_GET['pizza_name']) {
                $shoppingcart[$i]['quantity'] = (Int) $shoppingcart[$i]['quantity'] + (Int) $_GET['pizza_quantity'];
                $_SESSION['shoppingcart'] = $shoppingcart;
                echo 'true';
                return;
            }
        }
        $shoppingcart[$number]['name'] = $_GET['pizza_name'];
        $shoppingcart[$number]['quantity'] = $_GET['pizza_quantity'];
        $_SESSION['shoppingcart'] = $shoppingcart;
    } else {
        //
        $tempcart = array();
        $tempcart[0]['name'] = $_GET['pizza_name'];
        $tempcart[0]['quantity'] = $_GET['pizza_quantity'];
        $_SESSION['shoppingcart'] = $tempcart;
    }
    echo 'true';
}

function delete_pizza() {
    $shoppingcart = $_SESSION['shoppingcart'];
    $pizza_name = $_GET['pizza_name'];

    //echo count($shoppingcart[0]['name']);
    //return;
    for ($i = 0; $i < count($shoppingcart); $i++) {
        if ((String) $shoppingcart[$i]['name'] == $pizza_name) {
            unset($shoppingcart[$i]);
            if (count($shoppingcart) != 0) {
                array_unshift($shoppingcart, array_shift($shoppingcart));
            }
            $_SESSION['shoppingcart'] = $shoppingcart;
            echo 'true';
            return;
        }
    }
    $_SESSION['shoppingcart'] = $shoppingcart;
    echo 'true';
}

function save_order() {
    if (!isset($_SESSION['username'])) {
        echo 'Please login first';
        return;
    }
    global $prefix;
    $filename = $prefix . 'order.xml';
    if (!file_exists($filename)) {
        //create a order.xml file
        $xml = new DOMDocument();
        $xml_root = $xml->createElement('ordersInformation');
        $xml->appendChild($xml_root);
        if ($xml->save($filename) == false) {
            echo 'false';
            return;
        };
    }

    $sxe = simplexml_load_file($filename);
    $ordersInfor = dom_import_simplexml($sxe);
    global $temp_record;
    $temp0 = simplexml_load_file($temp_record);
    $temp = $temp0->children();

    $order = new DOMElement('order');
    $id = new DOMElement('id', ((Int) $temp->order_count[0] + 1));
    $temp->order_count[0] = (Int) $temp->order_count[0] + 1;
    $temp0->saveXML($temp_record);
    $username = new DOMElement('username', $_SESSION['username']);
    $fullname = new DOMElement('fullname', $_GET['fullname']);
    $address = new DOMElement('address', $_GET['address']);
    $zip = new DOMElement('zip', $_GET['zip']);
    $city = new DOMElement('city', $_GET['city']);
    $email = new DOMElement('email', $_GET['email']);
    $status = new DOMElement('status', 'waiting');

    $ordersInfor->appendChild($order);
    $order->appendChild($id);
    $order->appendChild($username);
    $order->appendChild($fullname);
    $order->appendChild($address);
    $order->appendChild($zip);
    $order->appendChild($city);
    $order->appendChild($email);
    $order->appendChild($status);

    $shoppingcart;
    if (isset($_SESSION['shoppingcart'])) {
        //
        global $prefix;
        $pizza_filename = $prefix . 'pizza.xml';

        $pizza_sxe = simplexml_load_file($pizza_filename);
        $pizzasInfor = dom_import_simplexml($pizza_sxe);

        $shoppingcart = $_SESSION['shoppingcart'];
        for ($i = 0; $i < count($shoppingcart); $i++) {
            $tt0 = new DOMElement('pizza');
            $tt1 = new DOMElement('name', (String) $shoppingcart[$i]['name']);
            $tt2 = new DOMElement('quantity', (String) $shoppingcart[$i]['quantity']);
            $order->appendChild($tt0);
            $tt0->appendChild($tt1);
            $tt0->appendChild($tt2);

            //increase the sold out of the pizza
            $pizza_name = (String) $shoppingcart[$i]['name'];
            foreach ($pizza_sxe->children() as $pizzaRecord) {
                if ($pizzaRecord->name[0] == $pizza_name) {
                    $pizzaRecord->soldout[0] = (Int) $pizzaRecord->soldout[0] + (Int) $shoppingcart[$i]['quantity'];
                    $pizza_sxe->saveXML($pizza_filename);
                    break;
                }
            }
        }
    }

    $dom_pretty = new DOMDocument;
    $dom_pretty->preserveWhiteSpace = false;
    $dom_pretty->formatOutput = true;

    $dom_pretty->loadXML($sxe->asXML());
    $dom_pretty->save($filename);

    $_SESSION['shoppingcart'] = array();

    echo 'true';
}

function delete_order() {
    $order_id = $_GET['order_id'];
    global $prefix;
    $filename = $prefix . 'order.xml';
    $sxe = simplexml_load_file($filename);

    foreach ($sxe->children() as $order) {
        if ((String) $order->id[0] == (String) $order_id) {
            //delete this order
            $dom = dom_import_simplexml($order);
            $dom->parentNode->removeChild($dom);

            $sxe->saveXML($filename);
            echo 'true';
            return;
        }
    }
}

function logout() {
    unset($_SESSION['username']);
    $_SESSION['shoppingcart'] = array();
    echo 'true';
}

function checkPizzaQuantity() {
    //check if the pizza`s quantity is available
    $pizza_name = $_GET['pizza_name'];
    $pizza_quantity = $_GET['pizza_quantity'];
    global $prefix;
    $filename0 = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename0);
    
    $res = array();
    $count=0;
    foreach ($sxe->children() as $pizza) {
        if ((String) $pizza->name[0] == $pizza_name) {
            //succeed to find the pizza you want
            global $prefix;
            $ingredient_filename = $prefix . 'ingredient.xml';
            $sxe2 = simplexml_load_file($ingredient_filename);
            foreach ($pizza->recipe[0]->ingredient as $ingredient_unit) {
                //find the ingredient
                foreach($sxe2->children() as $ing_record){
                    if((String)$ing_record->name[0]==(String)$ingredient_unit->name[0]){
                        $stock = (Int)$ing_record->quantity[0];
                        $needed = (Int)$ingredient_unit->quantity[0];
                        $num = $stock / $needed;
                        $res[$count]=$num;
                        $count++;
                    }
                }
            }
        }
    }
    
    //find the minimum number
    $max=$res[0];
    for($i=0;$i<count($res);++$i){
        if((Int)$res[$i]<(Int)$max){
            $max=$res[$i];
        }
    }
    if($max>=$pizza_quantity){
        //the ingredients are enough
        $result['res']='true';
        echo json_encode($result);
    }else{
        //the ingredients are not enough
        $result['res']='false';
        $result['quantity']=$max;
        echo json_encode($result);
    }
}

$method = $_REQUEST['method'];
switch ($method) {
    case 'addPizzaIntoOrder':
        addPizzaIntoOrder();
        break;
    case 'delete_pizza':
        delete_pizza();
        break;
    case 'save_order':
        save_order();
        break;
    case 'delete_order':
        delete_order();
        break;
    case 'logout':
        logout();
        break;
    case 'checkPizzaQuantity':
        checkPizzaQuantity();
        break;
    default:
        break;
}
?>
