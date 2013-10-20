/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
//
    sendRequest('Home');
});
function logout() {
    window.location.href = 'index.php';
}

function newAdmin_actions() {
//add relative actions to new admin panel
    $('#password_confirm_input').keyup(function() {
//when the user input in the password confirm field
        if ($('#password_new_input').val() != '') {
//when the password input field is not empty
            var pass1 = $('#password_new_input').val();
            var pass2 = $('#password_confirm_input').val();
            if (pass1.indexOf(pass2) < 0) {
//the confirmed password is correct
                $('#warning p').text('The confirmed password is not correct!');
                $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
            } else {
//the confirmed password is correct
                if ($('#warning').css('opacity') == '1') {
                    $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                }
            }
        }
    });
    $('#password_new_input').keyup(function() {
//when the user input in the new password field
        if ($('#password_confirm_input').val() != '') {
            var pass1 = $('#password_new_input').val();
            var pass2 = $('#password_confirm_input').val();
            if (pass2.indexOf(pass1) < 0) {
//the confirmed password is correct
                $('#warning p').text('The confirmed password is not correct!');
                $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
            } else {
//the confirmed password is correct
                if ($('#warning').css('opacity') == '1') {
                    $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                }
            }
        }
    });
    $('#username_new_input').keyup(function() {
//when the user input in the new username field
        var current_username = $(this).val();
        //check if the user table exists, otherwise create a new one
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
//when the response is ready
                if (xmlhttp.responseText === 'false') {
//the current input username has been used
                    $('#warning p').text('The current username has been registered');
                    $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                } else if (xmlhttp.responseText === 'true') {
//the current input username is available
                    if ($('#warning').css('opacity') == '1') {
                        $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                    }
                }
            }
        };
        xmlhttp.open("GET", "dbu.php?method=checkUsername&username=" + current_username, false);
        xmlhttp.send();
    });
    $('#reset').click(function() {
        $('div#new_user_panel form fieldset input').each(function() {
            $(this).val('');
        });
    });
    function checkEmptyInput() {
        var res = true;
        $('div#new_user_panel form fieldset input').each(function() {
            if ($(this).val() === '') {
                res = false;
                return res;
            }
        });
        return res;
    }

    $('#register').click(function() {
//register a new user
        if ($('#warning').css('opacity') === '1') {
            return false;
        }

        var empty_input = false;
        $('div#new_user_panel form fieldset input').each(function() {
            if ($(this).val() === '') {
                empty_input = true;
                if ($('#warning').css('opacity') === '0') {
                    $('#warning p').text('Please fill in the empty spaces');
                    $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                }
                $(this).keyup(function() {
                    if (checkEmptyInput()) {
                        $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                    }
                });
            }
        });
        if (empty_input === true) {
            return false;
        }
//register the new user
        var username = $('#username_new_input').val();
        var password = $('#password_new_input').val();
        var fullname = $('#fullname_input').val();
        var address = $('#address_input').val();
        var zip = $('#zip_input').val();
        var city = $('#city_input').val();
        var email = $('#email_input').val();
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                if (xmlhttp.responseText === 'true') {
//
                    alert('succeed registering the new user');
                    $('#new_user_panel form fieldset input').each(function() {
                        $(this).val('');
                    });
                    $('#new_user_panel').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false, 'complete': function() {
                            $('#new_user_panel').css({'display': 'none'});
                            $('#header').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                            $('#main').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                        }});
                }
                else {
//
                    alert(xmlhttp.responseText);
                }
            }
        };
        xmlhttp.open("POST", "dbu.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("method=registerAdmin&fullname=" + fullname + "&username=" + username + "&password=" + password + "&address=" + address + "&zip=" + zip + "&city=" + city + '&email=' + email);
    });
}
;
function newIngredient_actions() {
    //append all relative actions to elements
    $('#name_input').keyup(function() {
        //when the user input in the new username field
        var current_name = $(this).val();
        //check if the user table exists, otherwise create a new one
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                //when the response is ready
                if (xmlhttp.responseText === 'false') {
                    //the current input username has been used
                    $('#warning p').text('The current ingredient`s name has been registered');
                    $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                } else if (xmlhttp.responseText === 'true') {
                    //the current input username is available
                    if ($('#warning').css('opacity') === '1') {
                        $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                    }
                }
            }
        };
        xmlhttp.open("GET", "dbu.php?method=checkIngredientname&name=" + current_name, false);
        xmlhttp.send();
    });
    $('#quantity_input').keyup(function() {
        //check if the quantity input is negative
        var quantity = parseInt($(this).val());
        if (quantity < 0) {
            $('#warning p').text('The quantity should not be negative');
            $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
        } else {
            if ($('#warning').css('opacity') === '1') {
                $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
            }
        }
        if (!isNaN($(this).val())) {
            if ($('#warning').css('opacity') === '1') {
                $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
            }
        }
        else {
            $('#warning p').text('The quantity should be number');
            $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
        }
    });
    $('#price_input').keyup(function() {
        //check if the price is number
        var price = $(this).val();
        if (!isNaN(price)) {
            if ($('#warning').css('opacity') === '1') {
                $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
            }
        }
        else {
            $('#warning p').text('The price should be number');
            $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
        }
    });
    function checkEmptyInput() {
        var res = true;
        $('div#new_ingredient_panel form fieldset input').each(function() {
            if ($(this).val() === '') {
                res = false;
                return res;
            }
        });
        if ($('div#new_ingredient_panel textarea').val() === '') {
            res = false;
            return res;
        }
        return res;
    }

    $('#save').click(function() {
        //save the new ingredient`s information to ingredient.xml
        if ($('#warning').css('opacity') === '1') {
            return false;
        }

        var empty_input = false;
        $('div#new_ingredient_panel form fieldset input').each(function() {
            if ($(this).val() === '') {
                empty_input = true;
                if ($('#warning').css('opacity') === '0') {
                    $('#warning p').text('Please fill in the empty spaces.');
                    $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                }
                $(this).keyup(function() {
                    if (checkEmptyInput()) {
                        $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                    }
                });
            }
        });
        if ($('div#new_ingredient_panel textarea').val() === '') {
            empty_input = true;
            if ($('#warning').css('opacity') === '0') {
                $('#warning p').text('Please fill in the empty spaces.');
                $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
            }
            $('div#new_ingredient_panel textarea').keyup(function() {
                if (checkEmptyInput()) {
                    $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                }
            });
        }
        if (empty_input === true) {
            return false;
        }

        //save the new ingredient into the xml file
        var name = $('#name_input').val();
        var quantity = $('#quantity_input').val();
        var price = $('#price_input').val();
        var description = $('#description_input').val();
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                var res = xmlhttp.responseText;
                if (res === 'true') {
                    //
                    $('#content').html('<h1>Succeed Saving The New Ingredient</h1>');
                } else {
                    alert(res);
                }
            }
        };
        xmlhttp.open("POST", "dbu.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("method=registerIngredient&name=" + name + '&quantity=' + quantity + '&price=' + price + '&description=' + description);
    });
}

function part_actions() {
    $('input[name$=_minus]').click(function() {
        var name = $(this).attr('name').toString().replace('_minus', '');
        var quantity = parseInt($(this).siblings('input[type=text]').val());
        if (quantity <= 0) {
            return false;
        } else if (quantity > 0) {
//
            var new_number = quantity - 1;
            $(this).siblings('input[type=text]').val(new_number);
            var request = $.ajax({
                type: 'GET',
                url: 'dbu.php',
                data: {'name': name, 'method': 'change_ingredient_quantity', 'quantity': new_number + ''},
                dataType: 'text'
            });
            request.done(function(response) {
                if (response != 'true') {
                    alert(response);
                }
            });
        }
    });

    $('input[name$=_plus]').click(function() {
        var name = $(this).attr('name').toString().replace('_plus', '');
        var quantity = parseInt($(this).siblings('input[type=text]').val());
        var new_number = quantity + 1;
        $(this).siblings('input[type=text]').val(new_number);
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': name, 'method': 'change_ingredient_quantity', 'quantity': new_number + ''},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response != 'true') {
                alert(response);
            }
        });
    });

    $('input[type=text]').not('input.name_input, input.price_input, input.quantity_input, input.description_input').focusout(function() {
//
        var name = $(this).parent().siblings(':first-child').text();
        var quantity = $(this).val();
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': name, 'method': 'change_ingredient_quantity', 'quantity': quantity},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response != 'true') {
                alert(response);
            }
        });
    });

    $('input[name$=_delete]').click(function() {
//
        var name = $(this).attr('name').toString().replace('_delete', '');
        //notify the server to delete the content of relative xml files
        $(this).parent().parent().remove();
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': name, 'method': 'delete_ingredient'},
            dataType: 'text',
            'async': false
        });
        request.done(function(response) {
            if (response === 'true') {
                //
            } else {
                alert(response);
            }
        });
    });

    $('input[name$=_edit]').click(function() {
//
        var name = $(this).attr('name').toString().replace('_edit', '');
        var price_edit = $(this).parent().siblings('td:nth-child(2)');
        var ori_price = price_edit.text();
        var description_edit = $(this).parent().siblings('td:nth-child(3)');
        var ori_description = description_edit.text();
        price_edit.html('<input type=text value=' + ori_price + '>');
        description_edit.html('<textarea>' + ori_description.replace(/ /g, '&ensp;') + '</textarea>');
        $(this).siblings('input[name$=_delete]').before('<input type=button name=' + name + '_save value=save>');
        //$(this).remove();
        $(this).css({'display': 'none'});
        var old_button = $(this);
        $('input[name$=_save]').click(function() {
//save the latest data
            var price_edit = $(this).parent().siblings('td:nth-child(2)');
            var description_edit = $(this).parent().siblings('td:nth-child(3)');
            var new_price = price_edit.children().val();
            var new_description = description_edit.children().val();
            var self = $(this);
            //notify the server to change the content of relative xml files
            var request = $.ajax({
                type: 'GET',
                url: 'dbu.php',
                data: {'name': name, 'new_price': new_price, 'method': 'change_ingredient_infor', 'new_description': new_description},
                dataType: 'text',
                async: false
            });
            request.done(function(response) {
                if (response === 'true') {
//succeed changing the server
                    price_edit.html(new_price);
                    description_edit.html(new_description);
                    self.remove();
                    old_button.css({'display': 'inline-block'});
                }
            });
        });
    });
}

function new_elements_actions(row) {
    row.children('td').children('input[name$=_minus]').click(function() {
        var name = $(this).attr('name').toString().replace('_minus', '');
        var quantity = parseInt($(this).siblings('input[type=text]').val());
        if (quantity <= 0) {
            return false;
        } else if (quantity > 0) {
//
            var new_number = quantity - 1;
            $(this).siblings('input[type=text]').val(new_number);
            var request = $.ajax({
                type: 'GET',
                url: 'dbu.php',
                data: {'name': name, 'method': 'change_ingredient_quantity', 'quantity': new_number + ''},
                dataType: 'text'
            });
            request.done(function(response) {
                if (response != 'true') {
                    alert(response);
                }
            });
        }
    });

    row.children('td').children('input[name$=_plus]').click(function() {
        var name = $(this).attr('name').toString().replace('_plus', '');
        var quantity = parseInt($(this).siblings('input[type=text]').val());
        var new_number = quantity + 1;
        $(this).siblings('input[type=text]').val(new_number);
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': name, 'method': 'change_ingredient_quantity', 'quantity': new_number + ''},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response != 'true') {
                alert(response);
            }
        });
    });

    row.children('td').children('input[type=text]').focusout(function() {
//
        var name = $(this).parent().siblings(':first-child').text();
        var quantity = $(this).val();
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': name, 'method': 'change_ingredient_quantity', 'quantity': quantity},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response != 'true') {
                alert(response);
            }
        });
    });
    row.children('td').children('input[name$=_delete]').click(function() {
//
        var name = $(this).attr('name').toString().replace('_delete', '');
        //notify the server to delete the content of relative xml files
        $(this).parent().parent().remove();
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': name, 'method': 'delete_ingredient'},
            dataType: 'text',
            'async': false
        });
        request.done(function(response) {
            if (response === 'true') {
                //
            } else {
                alert(response);
            }
        });
    });

    row.children('td').children('input[name$=_edit]').click(function() {
//
        var name = $(this).attr('name').toString().replace('_edit', '');
        var price_edit = $(this).parent().siblings('td:nth-child(2)');
        var ori_price = price_edit.text();
        var description_edit = $(this).parent().siblings('td:nth-child(3)');
        var ori_description = description_edit.text();
        price_edit.html('<input type=text value=' + ori_price + '>');
        description_edit.html('<textarea>' + ori_description.replace(/ /g, '&ensp;') + '</textarea>');
        $(this).siblings('input[name$=_delete]').before('<input type=button name=' + name + '_save value=save>');
        //$(this).remove();
        $(this).css({'display': 'none'});
        var old_button = $(this);
        $('input[name$=_save]').click(function() {
//save the latest data
            var price_edit = $(this).parent().siblings('td:nth-child(2)');
            var description_edit = $(this).parent().siblings('td:nth-child(3)');
            var new_price = price_edit.children().val();
            var new_description = description_edit.children().val();
            var self = $(this);
            //notify the server to change the content of relative xml files
            var request = $.ajax({
                type: 'GET',
                url: 'dbu.php',
                data: {'name': name, 'new_price': new_price, 'method': 'change_ingredient_infor', 'new_description': new_description},
                dataType: 'text',
                async: false
            });
            request.done(function(response) {
                if (response === 'true') {
//succeed changing the server
                    price_edit.html(new_price);
                    description_edit.html(new_description);
                    self.remove();
                    old_button.css({'display': 'inline-block'});
                }
            });
        });
    });
}

function ingredientsList_actions() {

    part_actions();
//append relative actions to elements
    $('input[name=add_new]').click(function() {
//add a new row to let manager to fill in the information of the new ingredient
        var new_content = '<tr>';
        new_content += '<td><input type=text class=name_input></td>';
        new_content += '<td><input type=text class=price_input></td>';
        new_content += '<td><input type=text class=description_input></td>';
        new_content += '<td><input type=text class=quantity_input></td>';
        new_content += '<td><input type=button class=save_new value=save><input type=button class=delete_new value=delete></td>';
        new_content += '</tr>';
        $('table#ingredientsList tr:last-child').after(new_content);
        //make the new elements smart
        $('input.name_input').keyup(function() {
//when the user input in the new username field
            var current_name = $(this).val();
            //check if the user table exists, otherwise create a new one
            var request = $.ajax({
                'type': 'GET',
                'url': 'dbu.php',
                'async': false,
                'dataType': 'text',
                'data': {'method': 'checkIngredientname', 'name': current_name}
            });
            request.done(function(response) {
//when the response is ready
                if (response === 'false') {
//the current input username has been used
                    $('#warning p').text('The current ingredient`s name has been registered');
                    $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                } else if (response === 'true') {
//the current input username is available
                    if ($('#warning').css('opacity') === '1') {
                        $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                    }
                }
            });
        });
        $('input.quantity_input').keyup(function() {
//check if the quantity input is negative
            var quantity = parseInt($(this).val());
            if (quantity < 0) {
                $('#warning p').text('The quantity should not be negative');
                $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
            } else {
                if ($('#warning').css('opacity') === '1') {
                    $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                }
            }
            if (!isNaN($(this).val())) {
                if ($('#warning').css('opacity') === '1') {
                    $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                }
            }
            else {
                $('#warning p').text('The quantity should be number');
                $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
            }
        });
        $('input.price_input').keyup(function() {
//check if the price is number
            var price = $(this).val();
            if (!isNaN(price)) {
                if ($('#warning').css('opacity') === '1') {
                    $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                }
            }
            else {
                $('#warning p').text('The price should be number');
                $('#warning').stop().animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
            }
        });
        //append the actions to buttons of the new row
        $('input.save_new').click(function() {
            if ($('#warning').css('opacity') === '1') {
                return false;
            }
//check the empty elements
            var empty_input = false;
            var tr = $(this).parent().parent().children('td');
            if (tr.children('input.name_input').val() === ''
                    || tr.children('input.price_input').val() === ''
                    || tr.children('input.description_input').val() === ''
                    || tr.children('input.quantity_input').val() === '') {
                if ($('#warning').css('opacity') === '0') {
                    $('#warning p').text('Please fill in the empty spaces.');
                    $('#warning').animate({'opacity': '1'}, {'duration': 'slow', 'queue': false});
                    tr.children('input').keyup(function() {
                        var tr = $(this).parent().parent().children('td');
                        if (tr.children('input.name_input').val() != ''
                                && tr.children('input.price_input').val() != ''
                                && tr.children('input.description_input').val() != ''
                                && tr.children('input.quantity_input').val() != '') {
//no empty text input exists in this row
                            $('#warning').animate({'opacity': '0'}, {'duration': 'slow', 'queue': false});
                        }
                    });
                }
                return false;
            }

//save the information of the new ingredient into the database
            var tr = $(this).parent().parent();
            var name_input = tr.children('td').children('input.name_input').val();
            var price_input = tr.children('td').children('input.price_input').val();
            var description_input = tr.children('td').children('input.description_input').val();
            var quantity_input = tr.children('td').children('input.quantity_input').val();
            var request = $.ajax({
                type: 'POST',
                url: 'dbu.php',
                data: {'name': name_input, 'method': 'registerIngredient', 'quantity': quantity_input, 'price': price_input, 'description': description_input},
                dataType: 'text',
                async: false
            });
            request.done(function(response) {
                if (response === 'true') {
//succeed registering the new ingredient
                    tr.children('td:first-child').text(name_input);
                    tr.children('td:nth-child(2)').text(price_input);
                    tr.children('td:nth-child(3)').html(description_input);
                    tr.children('td:nth-child(4)').html('<input type=button value=\'-\' name=' + name_input + '_minus><input type=text value=' + quantity_input + '><input type=button value=\'+\' name=' + name_input + '_plus>');
                    tr.children('td:nth-child(5)').html('<input type=button value=edit name=' + name_input + '_edit><input type=button value=delete name=' + name_input + '_delete>');
                    //append the action to the new elements
                    new_elements_actions(tr);
                    //end of the actions part
                } else {
                    alert(response);
                }
            });
        });
        $('input.delete_new').click(function() {
            if($('#warning').css('opacity')==='1'){
                $('#warning').animate({'opacity':'0'},{'duration':'slow','queue':false});
            }
            $(this).parent().parent().remove();
        });
    });

}

function newPizza_actions() {
    
    //
    $('input[name$=_number]').focusout(function(){
        //calculate the price automaticly
        
        var sum = 0.0;
        var correct = true;
        $('input[name$=_number]').each(function() {
            var single_price = parseFloat($(this).parent().siblings('td:nth-child(3)').text());
            var number = $(this).val();
            if (isNaN(number)) {
                alert('The quantity you input should be number');
                correct = false;
                return false;
            } else if (parseInt(number) < 0) {
                alert('The quantity you input should be opsitive');
                correct = false;
                return false;
            }
            sum += single_price * parseInt(number);
        });
        if (sum === 0.0) {
            return false;
        }
        if(correct===false){
            return false;
        }
        sum = sum.toFixed(1);
        $('#price_input').val(sum);
    });

    $('#calculate_price').click(function() {
        var sum = 0.0;
        $('input[name$=_number]').each(function() {
            var single_price = parseFloat($(this).parent().siblings('td:nth-child(3)').text());
            var number = $(this).val();
            if (isNaN(number)) {
                alert('The quantity you input should be number');
                return false;
            } else if (parseInt(number) < 0) {
                alert('The quantity you input should be opsitive');
                return false;
            }
            sum += single_price * parseInt(number);
        });
        if (sum === 0.0) {
            return false;
        }
        sum = sum.toFixed(1);
        $('#price_input').val(sum);
    });
    $('#reset').click(function() {
        $('div#new_pizza_panel form input[type=text]').val('');
        $('div#new_pizza_panel textarea').val('');
    });
    $('#save').click(function() {
//when the user click on the save button

//check if the pizza`s name is available
        var pizza_name = $('#name_input').val();
        if (pizza_name === '') {
            alert('Please input the pizza`s name');
            return false;
        }
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': pizza_name, 'method': 'check_pizzaname'},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response === 'true') {
//the current pizza`s name is available
//check if the empty spaces exist
                if ($('#flavor_input').val() === '') {
                    alert('Please input the flavor of the pizza');
                    return false;
                }
                if ($('#price_input').val() === '') {
                    calculate();
                } else {
                    var temp_price = parseFloat($('#price_input').val());
                    if (temp_price < 0) {
                        alert('Please input non-negative price');
                        return false;
                    }
                }
                if ($('#description_input').val() === '') {
                    alert('Please input the description of the pizza');
                    return false;
                }
                var pizza_price = $('#price_input').val();
                var pizza_flavor = $('#flavor_input').val();
                var description = $('#description_input').val();
                var soldout = 0;
                //recipes
                var recipe = '<recipe>';
                $('table#ingredientsList input[type=text]').each(function() {
                    var number = parseInt($(this).val());
                    if (number != 0) {
                        recipe += '\<ingredient\>';
                        var ingredient_name = $(this).parent().siblings('td:first-child').text();
                        recipe += ('\<name\>' + ingredient_name + '\</name\>');
                        recipe += ('\<quantity\>' + number + '\</quantity\>');
                        recipe += '\</ingredient\>';
                    }
                });
                recipe += '</recipe>';
                var request = $.ajax({
                    type: 'GET',
                    url: 'dbu.php',
                    data: {'name': pizza_name, 'method': 'save_pizza', 'price': pizza_price, 'flavor': pizza_flavor, 'description': description, 'soldout': soldout, 'recipe': recipe},
                    dataType: 'text'
                });
                request.done(function(response) {
                    if (response === 'true') {
//succeed installing the new pizza
                        sendRequest('viewPizzas');
                        
                        //set the new pizza`s background color to green
                        $('table#pizzasList tr').each(function(){
                            if($(this).children('td:first-child').text()===pizza_name){
                                $(this).css({'background-color':'green'});
                            }
                        });
                    }
                    else {
                        alert(response);
                    }
                });
            } else if (response === 'false') {
                alert('The pizza`s name has been registered');
            }
        });
    });
}

function pizzasList_actions() {
//
    $('input[name$=_delete]').click(function() {
        var pizza_name = $(this).attr('name').toString().replace('_delete', '');
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': pizza_name, 'method': 'delete_pizza'},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response === 'true') {
//succeed changing the server
                sendRequest('viewPizzas');
            }
        });
    });
    $('input[name$=_edit]').click(function() {
//jump the page to pizza`s information edition part
        sendRequest('editPizza');
        //retrieve pizza`s information from xml file
        var pizza_name = $(this).attr('name').toString().replace('_edit', '');
        //retrieve the pizza`s information from the xml file
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': pizza_name, 'method': 'infor_pizza'},
            dataType: 'json'
        });
        request.done(function(response) {
//alert(response.name);
//fill in the information into the related areas
            $('#name_input').text(response.name);
            $('#flavor_input').val(response.flavor);
            $('#price_input').val(response.price);
            $('#description_input').val(response.description);
            var recipe = response.recipe;
            for (var index in recipe) {
                $('table#ingredientsList input[name=' + recipe[index].name + '_number]').val(recipe[index].quantity);
            }
        });
    });
}

function editPizza_actions() {
//


    $('#calculate_price').click(function() {
        //calculate the total price of the new pizza
        var sum = 0.0;
        $('input[name$=_number]').each(function() {
            var single_price = parseFloat($(this).parent().siblings('td:nth-child(3)').text());
            var number = $(this).val();
            if (isNaN(number)) {
                alert('The quantity you input should be number');
                return false;
            } else if (parseInt(number) < 0) {
                alert('The quantity you input should be opsitive');
                return false;
            }
            sum += single_price * parseInt(number);
        });
        sum = sum.toFixed(1);
        $('#price_input').val(sum);
    });

    $('#cancel').click(function() {
        sendRequest('viewPizzas');
    });
    $('#reset').click(function() {
        $('div#new_pizza_panel form input[type=text]').val('');
        $('div#new_pizza_panel textarea').val('');
        $('table#ingredientsList input[name$=_number]').val('0');
    });
    $('#save').click(function() {
//when the user click on the save button

//check if the pizza`s name is available
        var pizza_name = $('#name_input').text();
        if ($('#flavor_input').val() === '') {
            alert('Please input the flavor of the pizza');
            return false;
        }
        if ($('#price_input').val() === '') {
            calculate();
        } else {
            var temp_price = parseFloat($('#price_input').val());
            if (temp_price < 0) {
                alert('Please input non-negative price');
                return false;
            }
        }
        if ($('#description_input').val() === '') {
            alert('Please input the description of the pizza');
            return false;
        }
        var pizza_price = $('#price_input').val();
        var pizza_flavor = $('#flavor_input').val();
        var description = $('#description_input').val();
        //recipes
        var recipe = '<recipe>';
        $('table#ingredientsList input[type=text]').each(function() {
            var number = parseInt($(this).val());
            if (number != 0) {
                recipe += '\<ingredient\>';
                var ingredient_name = $(this).parent().siblings('td:first-child').text();
                recipe += ('\<name\>' + ingredient_name + '\</name\>');
                recipe += ('\<quantity\>' + number + '\</quantity\>');
                recipe += '\</ingredient\>';
            }
        });
        recipe += '</recipe>';
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'name': pizza_name, 'method': 'change_pizza_infor', 'price': pizza_price, 'flavor': pizza_flavor, 'description': description, 'recipe': recipe},
            dataType: 'text'
        });
        request.done(function(response) {
            if (response === 'true') {
//succeed installing the new pizza
                sendRequest('viewPizzas');
            }
            else {
                alert(response);
            }
        });
    });
}

function pizzasRank_actions() {
//sort the pizzas rank according to its soldout
//it seems quite strange that tablesorter doesn`t work in the pizzas rank page
//$('table#pizzasList').tablesorter({sortList: [[2,1]]});
}

function viewOrders_actions() {
//
    $('input[name$=_delivery]').click(function() {
//delete order
        var order_id = $(this).attr('name').toString().replace('_delivery', '');
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'order_id': order_id, 'method': 'delivery_order'},
            dataType: 'text'
        });
        request.done(function(response) {
//
            if (response === 'true') {
                alert('succeed deliverying the order');
                //sendRequest('viewOrders');
                sendRequest('Home');
            }
            else {
                alert(response);
            }
        });
    });
    $('input[name$=_cook]').click(function() {
//when the administrator clicks on the cook button
        var order_id = $(this).attr('name').toString().replace('_cook', '');
        //check if the ingredients are enough
        var request = $.ajax({
            type: 'GET',
            url: 'dbu.php',
            data: {'order_id': order_id, 'method': 'check_ingredients'},
            dataType: 'text',
            async: false
        });
        request.done(function(response0) {
            if (response0 === 'true') {
//it is ok to cook this order`s pizzas
                alert('begin to cook');
                //reduce related ingredient
                var request1 = $.ajax({
                    type: 'GET',
                    url: 'dbu.php',
                    data: {'order_id': order_id, 'method': 'cook_pizzas'},
                    dataType: 'text',
                    async: false
                });
                request1.done(function(response1) {
                    if (response1 === 'true') {
//$(this).after('<input type=button value=delivery name=' + $(this).attr('name').toString().replace('_cook', '_delivery') + '>');
                        //$(this).remove();
                        //alert('refresh the page');
                        sendRequest('Home');
                        $('input[name$=_delivery]').click(function() {
//delete order
                            var request2 = $.ajax({
                                type: 'GET',
                                url: 'dbu.php',
                                data: {'order_id': order_id, 'method': 'delivery_order'},
                                dataType: 'text',
                                async: false
                            });
                            request2.done(function(response2) {
//
                                if (response2 === 'true') {
//sendRequest('viewOrders');
                                    sendRequest('Home');
                                }
                                else {
                                    alert(response2);
                                }
                            });
                        });
                    }
                    else {
                        alert(response1);
                    }
                });
            }
            else {
                alert(response0);
            }
        });
    });
}

function Home_actions() {
//the home page for manage entry
    viewOrders_actions();
}

function sendRequest(action) {
//send request for relative content
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
//when the response is ready
            $('#content').html(xmlhttp.responseText);
            switch (action) {
                case 'newAdmin':
                    //append relative actions
                    newAdmin_actions();
                    break;
                case 'newIngredient':
                    //append relative actions
                    newIngredient_actions();
                    break;
                case 'viewIngredients':
                    ingredientsList_actions();
                    break;
                case 'viewAdministrators':
                    break;
                case 'newPizza':
                    newPizza_actions();
                    break;
                case 'viewPizzas':
                    pizzasList_actions();
                    break;
                case 'editPizza':
                    editPizza_actions();
                    break;
                case 'pizzasRank':
                    pizzasRank_actions();
                    break;
                case 'viewOrders':
                    viewOrders_actions();
                    break;
                case 'Home':
                    Home_actions();
                    break;
                default:
                    break;
            }
            ;
        }
    };
    xmlhttp.open("GET", "content_control.php?content=" + action, false);
    xmlhttp.send();
}
;
