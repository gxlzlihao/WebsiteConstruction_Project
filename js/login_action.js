/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#show_pass').click(function(){
        //
        var thisCheck = $(this);
        if (thisCheck.is(':checked'))
        {
            //the check box is checked
            $('#password_input').attr('type', 'text');
        }
        else {
            //the check box is not checked
            $('#password_input').attr('type', 'password');
        }
    });
    
    //the functions below are only used in customer login interface
    
    $('#new_user').click(function(){
        //when the customer has not registered in the webshop
        $('#header').animate({'opacity':'0'},{'duration':'slow','queue':false});
        $('#main').animate({'opacity':'0'},{'duration':'slow','queue':false});
        $('#new_user_panel').css({'display':'block','opacity':'0'}).animate({'opacity':'1'},{'duration':'slow','queue':false});
    });
    
    $('#cancel').click(function(){
        //when the user click on the cancel button
        $('#new_user_panel').animate({'opacity':'0'},{'duration':'slow','queue':false,'complete':function(){
                $('#new_user_panel').css({'display':'none'});
                $('#header').animate({'opacity':'1'},{'duration':'slow','queue':false});
                $('#main').animate({'opacity':'1'},{'duration':'slow','queue':false});
        }});
    });
    
    $('#password_confirm_input').keyup(function(){
        //when the user input in the password confirm field
        if($('#password_new_input').val()!=''){
            //when the password input field is not empty
            var pass1 = $('#password_new_input').val();
            var pass2 = $('#password_confirm_input').val();
            if(pass1.indexOf(pass2)<0){
                //the confirmed password is correct
                $('#warning p').text('The confirmed password is not correct!');
                $('#warning').stop().animate({'opacity':'1'},{'duration':'slow','queue':false});
            }else{
                //the confirmed password is correct
                if($('#warning').css('opacity')=='1'){
                    $('#warning').animate({'opacity':'0'},{'duration':'slow','queue':false});
                }
            }
        }
    });
    
    $('#password_new_input').keyup(function(){
        //when the user input in the new password field
        if($('#password_confirm_input').val()!=''){
            var pass1 = $('#password_new_input').val();
            var pass2 = $('#password_confirm_input').val();
            if(pass2.indexOf(pass1)<0){
                //the confirmed password is correct
                $('#warning p').text('The confirmed password is not correct!');
                $('#warning').stop().animate({'opacity':'1'},{'duration':'slow','queue':false});
            }else{
                //the confirmed password is correct
                if($('#warning').css('opacity')=='1'){
                    $('#warning').animate({'opacity':'0'},{'duration':'slow','queue':false});
                }
            }
        }
    });
    
    $('#username_new_input').keyup(function(){
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
                if(xmlhttp.responseText==='false'){
                    //the current input username has been used
                    $('#warning p').text('The current username has been registered');
                    $('#warning').stop().animate({'opacity':'1'},{'duration':'slow','queue':false});
                }else if(xmlhttp.responseText==='true'){
                    //the current input username is available
                    if($('#warning').css('opacity')=='1'){
                        $('#warning').animate({'opacity':'0'},{'duration':'slow','queue':false});
                    }
                }
            }
        };
        xmlhttp.open("GET", "dbu.php?method=checkUsername&username=" + current_username, false);
        xmlhttp.send();
    });
    
    function checkEmptyInput(){
        var res = true;
        $('div#new_user_panel form fieldset input').each(function(){
            if($(this).val()===''){
                res = false;
                return res;
            }
        });
        return res;
    }
    
    $('#register').click(function(){
        //register a new user
        if($('#warning').css('opacity')==='1'){
            return false;
        }

        var empty_input = false;
        $('div#new_user_panel form fieldset input').each(function(){
            if($(this).val()===''){
                if($('#warning').css('opacity')==='0'){
                    $('#warning').text('Please fill in the empty spaces');
                    $('#warning').animate({'opacity':'1'},{'duration':'slow','queue':false});
                }
                $(this).keyup(function(){
                    if(checkEmptyInput()){
                        $('#warning').animate({'opacity':'0'},{'duration':'slow','queue':false});
                    }
                });
            }
        });
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
                if(xmlhttp.responseText==='true'){
                    //
                    alert('succeed registering the new user');
                    $('#new_user_panel form fieldset input').each(function(){
                        $(this).val('');
                    });
                    $('#new_user_panel').animate({'opacity':'0'},{'duration':'slow','queue':false,'complete':function(){
                        $('#new_user_panel').css({'display':'none'});
                        $('#header').animate({'opacity':'1'},{'duration':'slow','queue':false});
                        $('#main').animate({'opacity':'1'},{'duration':'slow','queue':false});
                    }});
                }
                else{
                    //
                    alert(xmlhttp.responseText);
                }
            }
        };
        xmlhttp.open("POST", "dbu.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("method=registerCustomer&name="+fullname+"&username="+username+"&password="+password+"&address="+address+"&zip="+zip+"&city="+city+'&email='+email);
    });
    
    $('#login').click(function(){
        //login in the the customer
        $('#main form fieldset input').each(function(){
            if($(this).val()===''){
                alert('Please do not leave '+($(this).attr('id')==='username_input'?'username':'password')+' empty!');
                return false;
            }
        });
        
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
                if(res==='true'){
                    //the command below does not work in the safari brower
                    //this bug should be fixed latter
                    window.location.href='shopping.php';
                }else{
                    alert(res);
                }
            }
        };
        var username = $('#username_input').val();
        var password = $('#password_input').val();
        xmlhttp.open("POST", "dbu.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send('method=loginCustomer&username='+username+'&password='+password);
    });
});

