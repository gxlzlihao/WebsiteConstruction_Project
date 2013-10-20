<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/reset.css" rel="stylesheet" />
        <link href="css/common_style.css" rel="stylesheet" />
        <link href="css/customer.css" rel="stylesheet">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="js/actions_customer.js"></script>
        <title>Enjoy Your Shopping!</title>
    </head>
    <body>
        <div id="header">
            <img src="images/uulogo.jpg" alt="">
            <img src="images/header_background.jpg" alt="">
        </div>
        <div id="main">
            <div id="menu">
                <ul>
                    <li><a href="javascript:void(0)" onclick=javascript:sendRequest('home')>Order Pizza</a></li>
                    <li><a href='javascript:void(0)' onclick=javascript:sendRequest('checkOut')>Check out</a></li>
                    <li><a href="javascript:void(0)" onclick=javascript:sendRequest('viewOrders')>Orders</a></li>
                    <li><a href='javascript:void(0)' onclick=javascript:logout()>Log out</a></li>
                </ul>
            </div>
            <div id='content'>
                <!--the content-->
            </div>
        </div>
        <div id="footer">
            <p>author: Li Hao</p>
            <p>Time: July 2013</p>
            <p>Email: gxlzlihao@gmail.com Telephone;+46-0739051551</p>
        </div>
    </body>
</html>
