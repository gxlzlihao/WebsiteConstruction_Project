<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/reset.css" rel="stylesheet" />
        <link href="css/login.css" rel="stylesheet" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="js/login_action.js"></script>
        <title>Administrator Login</title>
    </head>
    <body>
        <div id="header">
            <img src="images/pizza1.jpg" alt="">
            <p>Please Input Your Personal Infor!</p>
        </div>
        <div id="main">
            <form>
                <fieldset>
                    <legend>Username and password</legend>
                    <span>Username:</span> <input id="username_input" type="text"><br>
                    <span>Password:</span> <input id="password_input" type="password"><br>
                    <input id="show_pass" type="checkbox" name="show_password"><span>show password</span>
                </fieldset>
            </form>
            <input id="login" type="button" value="Login">
            <input id="new_user" type="button" value="Register">
        </div>
        <div id="new_user_panel">
            <form>
                <fieldset>
                    <legend>New Customer`s Personal Information</legend>
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
            <input id="cancel" type="button" value="cancel">
            <div id="warning">
                <img src="images/warning.jpg" alt="">
                <p>Warning Message</p>
            </div>
        </div>
    </body>
</html>
