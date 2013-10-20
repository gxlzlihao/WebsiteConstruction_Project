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
                    window.location.href='admin.php';
                }else{
                    alert(res);
                }
            }
        };
        var username = $('#username_input').val();
        var password = $('#password_input').val();
        xmlhttp.open("POST", "dbu.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send('method=loginAdmin&username='+username+'&password='+password);
    });
});
