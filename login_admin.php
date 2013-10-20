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
        <script src="js/login_action_admin.js"></script>
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
        </div>
    </body>
</html>
