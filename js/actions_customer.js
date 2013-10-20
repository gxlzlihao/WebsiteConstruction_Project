/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    //
    sendRequest('home');
});

function logout() {
    //execute loging out action
    var request = $.ajax({
        type: 'GET',
        url: 'dbu_customer.php',
        data: {'method': 'logout'},
        dataType: 'text'
    });
    request.done(function(response){
        if(response==='true'){
            window.location.href='index.php';
        }
    });
}

function viewPizzas_actions() {
    //
    $('input[name$=_buy]').click(function() {
        //when the user wants to buy one pizza
        var pizza_name = $(this).attr('name').toString().replace('_buy', '');
        var pizza_price = $(this).parent().siblings('td:nth-child(3)').text();
        var pizza_flavor = $(this).parent().siblings('td:nth-child(2)').text();
        var pizza_description = $(this).parent().siblings('td:nth-child(4)').text();

        //pop out the pizza order panel
        $('div#left table.pizzasList').animate({'opacity': '0.1'}, {'duration': 'slow', 'queue': false});
        $('div#order_pizza_panel span#name_input').text(pizza_name);
        $('div#order_pizza_panel span#price_input').text(pizza_price);
        $('div#order_pizza_panel span#flavor_input').text(pizza_flavor);
        $('div#order_pizza_panel span#description_input').text(pizza_description);
        $('div#order_pizza_panel').css({'display': 'block'}).animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
    });

    $('#cancel').click(function() {
        if ($('div#order_pizza_panel').css('opacity') === '1') {
            $('div#left table.pizzasList').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
            $('div#order_pizza_panel').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false, 'complete': function() {
                    $('div#order_pizza_panel').css({'display': 'none'});
                    $('input#quantity_input').val('');
                    $('#warning').animate({'opacity':'0'},{'duration':'slow','queue':false});
                }});
        }
    });

    $('#save').click(function() {
        //when the user wants to save the pizza order into the shopping cart
        if ($('div#order_pizza_panel').css('opacity') === '1') {
            //
            var pizza_name = $('#name_input').text();
            if ($('input#quantity_input').val() === '') {
                $('#warning p').text('Please input the pizza`s number you would like to purchase');
                $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                return false;
            }
            //check if the quantity user input is correct
            var pizza_quantity = $('input#quantity_input').val();
            if (isNaN(pizza_quantity)) {
                $('#warning p').text('The quantity you input should be number');
                $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                return false;
            } else if (parseInt(pizza_quantity) < 0) {
                $('#warning p').text('The quantity you input should be non negative');
                $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                return false;
            }
            //use ajax to check if the number of pizzas is ok to cook or not
            var available = true;
            var check = $.ajax({
                type:'GET',
                url:'dbu_customer.php',
                data:{'method':'checkPizzaQuantity','pizza_name':pizza_name, 'pizza_quantity':pizza_quantity},
                dataType:'json',
                async:false
            });
            check.done(function(response_check){
                //
                if(response_check.res==='false'){
                    //the number the customer order is too many
                    $('#warning p').text('Sorry! We can not cook so many pizzas, only '+parseInt(response_check.quantity)+ ' are available!');
                    $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                    available = false;
                    return false;
                }else if(response_check.res==='true'){
                    //
                    if($('#warning').css('opacity')==='1'){
                        $('#warning').animate({'opacity':'0'},{'duration':'slow','queue':false});
                    }
                }
            });
            if(available===false){
                return false;
            }

            //use ajax to save the order
            var request = $.ajax({
                type: 'GET',
                url: 'dbu_customer.php',
                data: {'method': 'addPizzaIntoOrder', 'pizza_name': pizza_name, 'pizza_quantity': pizza_quantity},
                dataType: 'text',
                async:false
            });
            request.done(function(response) {
                if (response === 'true') {
                    $('table#left table.pizzasList').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                    $('div#order_pizza_panel').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false, 'complete': function() {
                            $('div#order_pizza_panel').css({'display': 'none'});
                            $('input#quantity_input').val('');
                            sendRequest('home');
                        }});
                }
            });
        }
    });
}

function checkOut_actions() {
    //
    $('input[name$=_delete]').click(function() {
        var pizza_name = $(this).attr('name').toString().replace('_delete', '');
        var fullname = $('#fullname_input').val();
        var address = $('#address_input').val();
        var zip = $('#zip_input').val();
        var city = $('#city_input').val();
        var email = $('#email_input').val();

        var request = $.ajax({
            type: 'GET',
            url: 'dbu_customer.php',
            data: {'method': 'delete_pizza', 'pizza_name': pizza_name},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response === 'true') {
                sendRequest('checkOut');

                $('#fullname_input').val(fullname);
                $('#address_input').val(address);
                $('#zip_input').val(zip);
                $('#city_input').val(city);
                $('#email_input').val(email);
            } else {
                alert(response);
            }
        });
    });

    $('#cancel').click(function() {
        //cancel the checkout process and continue shopping
        sendRequest('viewPizzas');
    });

    $('#reset').click(function() {
        //set each input area to empty
        $('div#buy_order_panel input[type=text]').val('');
    });

    $('#purchase').click(function() {
        //
        var stop=false;
        $('div#buy_order_panel input[type=text]').each(function() {
            if ($(this).val() === '') {
                var tt = $(this).attr('id').toString().replace('_input', '');
                alert('Please input the ' + tt);
                stop=true;
                return false;
            }
        });
        if(stop){
            return false;
        }
        //
        var fullname = $('input#fullname_input').val();
        var address = $('input#address_input').val();
        var zip = $('input#zip_input').val();
        var city = $('input#city_input').val();
        var email = $('input#email_input').val();

        var request = $.ajax({
            type: 'GET',
            url: 'dbu_customer.php',
            data: {'method': 'save_order', 'fullname': fullname, 'address': address, 'zip': zip, 'city': city, 'email': email},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response === 'true') {
                //succeed saving the order
                alert('Succeed saving the order');
                //sendRequest('viewOrders');
                sendRequest('home');
            }
            else
                alert(response);
        });
    });
}

function viewShoppingcart_actions() {
    //
    $('input[name$=_delete]').click(function() {
        var pizza_name = $(this).attr('name').toString().replace('_delete', '');
        var request = $.ajax({
            type: 'GET',
            url: 'dbu_customer.php',
            data: {'method': 'delete_pizza', 'pizza_name': pizza_name},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response === 'true') {
                //succeed saving the order
                //sendRequest('viewShoppingcart');
                sendRequest('home');
            }
            else
                alert(response);
        });
    });
}

function pizzasRank_actions() {
    //
}

function viewOrders_actions() {
    //view orders page actions
    $('input[name$=_accept]').click(function() {
        //the customer accepts the order
        var order_id = $(this).attr('name').toString().replace('_accept', '');
        var request = $.ajax({
            type: 'GET',
            url: 'dbu_customer.php',
            data: {'method': 'delete_order', 'order_id': order_id},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response === 'true') {
                sendRequest('viewOrders');
            } else {
                alert(response);
            }
        });
    });
}

function home_actions(){
    //add actions to relative elements in the home page
    var tooltip;
    //adding tooltip when mouse hover over the small pictures
    $('td:first-child').hover(function(e) {
        tooltip = $(this).children('ul.tooltip');

        var mousex = e.pageX;
        var mousey = e.pageY;
        var left = $(this).position().left;
        var top = $(this).position().top;
        //tooltip.css({'top': mousey-500, 'left': mousex});
        tooltip.css({'top':top+50,'left':left+100});

        tooltip.show();
    }, function() {
        tooltip.hide();
    }).mousemove(function(e) {
        //set the location of the tooltip
        var mousex = e.pageX;
        var mousey = e.pageY;
        //tooltip.css({'top': mousey-500, 'left': mousex});
    });
    
    viewPizzas_actions();
    pizzasRank_actions();
    viewShoppingcart_actions();
}

function sendRequest(action) {
    //refresh the content of the page
    var request = $.ajax({
        type: 'GET',
        url: 'content_customer.php',
        data: {'content': action},
        dataType: 'text'
    });
    request.done(function(response) {
        $('#content').html(response);

        switch (action) {
            /*case 'viewPizzas':
                viewPizzas_actions();
                break;*/
            case 'checkOut':
                checkOut_actions();
                break;
            /*case 'viewShoppingcart':
                viewShoppingcart_actions();*/
                break;
            /*case 'pizzasRank':
                pizzasRank_actions();*/
                break;
            case 'viewOrders':
                viewOrders_actions();
                break;
            case 'home':
                home_actions();
                break;
            default:
                break;
        }
    });
}

