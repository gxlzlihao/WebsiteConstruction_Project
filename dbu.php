<?php

session_start();
$prefix = $_SERVER['DOCUMENT_ROOT'] . '/';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function checkUsername() {

    //check the current username is available or not
    $current_username = $_GET['username'];
    global $prefix;
    $filename = $prefix . 'user.xml';
    if (!file_exists($filename)) {
        //when the user table doesn`t exist
        $xml = new DOMDocument();
        $xml_root = $xml->createElement('userInformation');
        $xml->appendChild($xml_root);
        if ($xml->save($filename) == false) {
            echo 'false';
            return;
        };
    }

    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $user) {
        if ((String) $user->username[0] == $current_username) {
            echo 'false';
            return;
        }
    }
    echo 'true';
    return;
}

function checkIngredientname() {
    //check the current ingredient`s name is available or not
    $current_name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'ingredient.xml';

    if (!file_exists($filename)) {
        //when the user table doesn`t exist
        $xml = new DOMDocument();
        $xml_root = $xml->createElement('IngredientsInfor');
        $xml->appendChild($xml_root);
        if ($xml->save($filename) == false) {
            echo 'false';
            return;
        };
    }

    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $ingredient) {
        if ((String) $ingredient->name[0] == $current_name) {
            echo 'false';
            return;
        }
    }
    echo 'true';
    return;
}

function register($rolename) {
    //register a new user
    global $prefix;
    $filename = $prefix . 'user.xml';
    $sxe = simplexml_load_file($filename);
    $userInfor = dom_import_simplexml($sxe);

    $user = new DOMElement('user');
    $username = new DOMElement('username', $_POST['username']);
    $password = new DOMElement('password', $_POST['password']);
    $fullname = new DOMElement('fullname', $_POST['fullname']);
    $address = new DOMElement('address', $_POST['address']);
    $zip = new DOMElement('zip', $_POST['zip']);
    $city = new DOMElement('city', $_POST['zip']);
    $email = new DOMElement('email', $_POST['email']);
    $role = new DOMElement('role', $rolename);

    $userInfor->appendChild($user);
    $user->appendChild($username);
    $user->appendChild($password);
    $user->appendChild($fullname);
    $user->appendChild($address);
    $user->appendChild($zip);
    $user->appendChild($city);
    $user->appendChild($email);
    $user->appendChild($role);

    $dom_pretty = new DOMDocument;
    $dom_pretty->preserveWhiteSpace = false;
    $dom_pretty->formatOutput = true;

    $dom_pretty->loadXML($sxe->asXML());
    $dom_pretty->save($filename);

    echo 'true';
}

function login($rolename) {
    //

    global $prefix;
    $filename = $prefix . 'user.xml';
    $sxe = simplexml_load_file($filename);
    foreach ($sxe->children() as $user) {
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];
        if ((String) $user->username[0] == $input_username) {
            if ((String) $user->password[0] != $input_password) {
                echo 'Your password is not correct';
                return;
            } else if ((String) $user->role[0] != $rolename) {
                echo 'You have no enough authority to access';
                return;
            } else {
                //if (!isset($_SESSION['username']))
                    $_SESSION['username'] = $input_username;
                echo 'true';
                return;
            }
        }
    }
    echo 'The user name you input has not been registered';
}

function newIngredient() {
    //save the new ingredient information into the xml file
    global $prefix;
    $filename = $prefix . 'ingredient.xml';
    $sxe = simplexml_load_file($filename);
    $ingredientsInfor = dom_import_simplexml($sxe);

    $ingredient = new DOMElement('ingredient');
    $name = new DOMElement('name', $_POST['name']);
    $quantity = new DOMElement('quantity', $_POST['quantity']);
    $price = new DOMElement('price', $_POST['price']);
    $description = new DOMElement('description', $_POST['description']);

    $ingredientsInfor->appendChild($ingredient);
    $ingredient->appendChild($name);
    $ingredient->appendChild($quantity);
    $ingredient->appendChild($price);
    $ingredient->appendChild($description);

    $dom_pretty = new DOMDocument;
    $dom_pretty->preserveWhiteSpace = false;
    $dom_pretty->formatOutput = true;

    $dom_pretty->loadXML($sxe->asXML());
    $dom_pretty->save($filename);

    echo 'true';
}

function change_ingredient_quantity() {
    $new_number = $_GET['quantity'];
    $new_name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'ingredient.xml';
    $sxe = simplexml_load_file($filename);
    foreach ($sxe->children() as $ingredient) {
        if ((String) $ingredient->name[0] == $new_name) {
            $ingredient->quantity[0] = $new_number;
            $sxe->saveXML($filename);
            echo 'true';
        }
    }
}

function change_ingredient_infor() {
    //
    $new_price = $_GET['new_price'];
    $new_description = $_GET['new_description'];
    $name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'ingredient.xml';
    $sxe = simplexml_load_file($filename);
    foreach ($sxe->children() as $ingredient) {
        if ((String) $ingredient->name[0] == $name) {
            $ingredient->price[0] = $new_price;
            $ingredient->description[0] = $new_description;
            $sxe->saveXML($filename);
            echo 'true';
        }
    }
}

function delete_ingredient() {
    $name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'ingredient.xml';
    $sxe = simplexml_load_file($filename);

    foreach ($sxe->children() as $ingredient) {
        if ((String) $ingredient->name[0] == $name) {

            $dom = dom_import_simplexml($ingredient);
            $dom->parentNode->removeChild($dom);

            $sxe->saveXML($filename);
            echo 'true';
            return;
        }
    }
    echo 'false';
}

function check_pizzaname() {
    $pizza_name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    if (!file_exists($filename)) {
        $xml = new DOMDocument();
        $xml_root = $xml->createElement('pizzasInfor');
        $xml->appendChild($xml_root);
        if ($xml->save($filename) == false) {
            echo 'false';
            return;
        };
    }

    $sxe = simplexml_load_file($filename)->children();
    foreach ($sxe as $pizza) {
        if ((String) $pizza->name[0] == $pizza_name) {
            echo 'false';
            return;
        }
    }
    echo 'true';
    return;
}

function save_pizza() {
    //save the new pizza`s infor into xml file
    global $prefix;
    $filename = $prefix . 'pizza.xml';

    $sxe = simplexml_load_file($filename);
    $pizzasInfor = dom_import_simplexml($sxe);

    $pizza = new DOMElement('pizza');
    $name = new DOMElement('name', $_GET['name']);
    $flavor = new DOMElement('flavor', $_GET['flavor']);
    $price = new DOMElement('price', $_GET['price']);
    $description = new DOMElement('description', $_GET['description']);
    $soldout = new DOMElement('soldout', $_GET['soldout']);
    //$recipe = new DOMElement('recipe', $_GET['recipe']);
    $temp = simplexml_load_string($_GET['recipe']);
    $recipe = dom_import_simplexml($temp);
    $re = $pizzasInfor->ownerDocument;
    $recipe = $re->importNode($recipe, true);

    $pizzasInfor->appendChild($pizza);
    $pizza->appendChild($name);
    $pizza->appendChild($flavor);
    $pizza->appendChild($price);
    $pizza->appendChild($description);
    $pizza->appendChild($soldout);
    $pizza->appendChild($recipe);

    $dom_pretty = new DOMDocument;
    $dom_pretty->preserveWhiteSpace = false;
    $dom_pretty->formatOutput = true;

    $dom_pretty->loadXML($sxe->asXML());
    $dom_pretty->save($filename);
    echo 'true';
}

function delete_pizza() {
    //delete specific pizza
    $name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'pizza.xml';

    $sxe = simplexml_load_file($filename);

    foreach ($sxe->children() as $pizza) {
        if ((String) $pizza->name[0] == $name) {

            $dom = dom_import_simplexml($pizza);
            $dom->parentNode->removeChild($dom);

            $sxe->saveXML($filename);
            echo 'true';
            return;
        }
    }
    echo 'false';
}

function infor_pizza() {
    //return the pizza`s infor according to pizza`s name
    $pizza_name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $sxe = simplexml_load_file($filename);
    $result = array();
    foreach ($sxe->children() as $pizza) {
        if ((String) $pizza->name[0] == $pizza_name) {
            $result['name'] = (String) $pizza->name[0];
            $result['price'] = (String) $pizza->price[0];
            $result['flavor'] = (String) $pizza->flavor[0];
            $result['description'] = (String) $pizza->description[0];

            //retrieve recipe information
            $index = 0;
            $recipe = array();
            foreach ($pizza->recipe[0]->children() as $ingredient) {
                $recipe[$index]['name'] = (String) $ingredient->name[0];
                $recipe[$index]['quantity'] = (String) $ingredient->quantity[0];
                $index++;
            }
            $result['recipe'] = $recipe;
        }
    }
    echo json_encode($result);
}

function change_pizza_infor() {
    $pizza_name = $_GET['name'];
    global $prefix;
    $filename = $prefix . 'pizza.xml';
    $pizza_price = $_GET['price'];
    $pizza_flavor = $_GET['flavor'];
    $pizza_description = $_GET['description'];
    $pizza_recipe = $_GET['recipe'];

    $sxe = simplexml_load_file($filename);
    $pizzasInfor = dom_import_simplexml($sxe);
    foreach ($sxe->children() as $pizza) {
        if ((String) $pizza->name[0] == $pizza_name) {
            $pizza->price[0] = $pizza_price;
            $pizza->flavor[0] = $pizza_flavor;
            $pizza->description[0] = $pizza_description;
            $dom = dom_import_simplexml($pizza->recipe[0]);
            $dom->parentNode->removeChild($dom);

            //$sxe->saveXML($filename);
            //change the recipe list
            $recipe = dom_import_simplexml(simplexml_load_string($pizza_recipe));
            $recipe = $pizzasInfor->ownerDocument->importNode($recipe, true);

            dom_import_simplexml($pizza)->appendChild($recipe);

            $dom_pretty = new DOMDocument;
            $dom_pretty->preserveWhiteSpace = false;
            $dom_pretty->formatOutput = true;

            $dom_pretty->loadXML($sxe->asXML());
            $dom_pretty->save($filename);
        }
    }

    echo 'true';
}

function check_ingredients() {
    $order_id = $_GET['order_id'];
    global $prefix;
    $filename = $prefix . 'order.xml';
    $sxe = simplexml_load_file($filename);
    foreach ($sxe->children() as $order) {
        if ((String) $order->id[0] === $order_id) {
            //
            global $prefix;
            $pizza_filename = $prefix . 'pizza.xml';
            $sxe1 = simplexml_load_file($pizza_filename);

            foreach ($order->pizza as $pizza) {
                $pizza_name = $pizza->name[0];
                $pizza_number_required = (Int) $pizza->quantity[0];

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
                                    if ((Int) $ing->quantity[0] < $pizza_number_required * $ingredient_quantity) {
                                        echo $ingredient_name . ' is not enough!';
                                        return;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    echo 'true';
}

function cook_pizzas() {
    //cook the pizzas in the list and reduce the amount of ingredients
    $order_id = $_GET['order_id'];
    global $prefix;
    $filename = $prefix . 'order.xml';
    $sxe = simplexml_load_file($filename);
    foreach ($sxe->children() as $order) {
        if ((String) $order->id[0] === $order_id) {
            //
            global $prefix;
            $pizza_filename = $prefix . 'pizza.xml';
            $sxe1 = simplexml_load_file($pizza_filename);

            foreach ($order->pizza as $pizza) {
                $pizza_name = $pizza->name[0];
                $pizza_number_required = (Int) $pizza->quantity[0];

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
                                    $ing->quantity[0] = (Int) $ing->quantity[0] - (Int) $pizza_number_required * (Int) $ingredient_quantity;
                                    $sxe2->saveXML($ingredient_filename);
                                }
                            }
                        }
                    }
                }
            }
            $order->status[0]='ready';
            $sxe->saveXML($filename);
            
            echo 'true';
            return;
        }
    }
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

function delivery_order(){
    $order_id = $_GET['order_id'];
    global $prefix;
    $filename = $prefix . 'order.xml';
    $sxe = simplexml_load_file($filename);

    foreach ($sxe->children() as $order) {
        if ((String) $order->id[0] == (String) $order_id) {
            //delete this order
            $order->status[0]='deliverying';

            $sxe->saveXML($filename);
            echo 'true';
            return;
        }
    }
}

$method_name = $_REQUEST['method'];
switch ($method_name) {
    case 'checkUsername':
        checkUsername();
        break;
    case 'registerCustomer':
        register('customer');
        break;
    case 'registerAdmin':
        register('admin');
        break;
    case 'loginCustomer':
        login('customer');
        break;
    case 'loginAdmin':
        login('admin');
        break;
    case 'checkIngredientname':
        checkIngredientname();
        break;
    case 'registerIngredient':
        newIngredient();
        break;
    case 'change_ingredient_quantity':
        change_ingredient_quantity();
        break;
    case 'change_ingredient_infor':
        change_ingredient_infor();
        break;
    case 'delete_ingredient':
        delete_ingredient();
        break;
    case 'check_pizzaname':
        check_pizzaname();
        break;
    case 'save_pizza':
        save_pizza();
        break;
    case 'delete_pizza':
        delete_pizza();
        break;
    case 'infor_pizza':
        infor_pizza();
        break;
    case 'change_pizza_infor':
        change_pizza_infor();
        break;
    case 'check_ingredients':
        check_ingredients();
        break;
    case 'cook_pizzas':
        cook_pizzas();
        break;
    case 'delete_order':
        delete_order();
        break;
    case 'delivery_order':
        delivery_order();
        break;
    default:
        break;
}
?>
