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
        <link href="css/admin.css" rel="stylesheet">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="js/__jquery.tablesorter/jquery.tablesorter.js"></script>
        <script src="js/actions_admin.js"></script>
        <title>Administration Page</title>
    </head>
    <body>
        <div id="header">
            <img src="images/uulogo.jpg" alt="">
            <img src="images/header_background.jpg" alt="">
        </div>
        <div id="main">
            <div id="menu">
                <ul>
                    <li><a href="javascript:void(0)" onclick=javascript:sendRequest('Home')>Home</a></li>
                    <li><a href="javascript:void(0)">User</a>
                        <ul>
                            <li><a href="javascript:void(0)">Administrator</a>
                                <ul>
                                    <li><a href="javascript:void(0)" onclick=javascript:sendRequest('newAdmin')>New Administrator</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)" onclick=javascript:sendRequest('viewAdministrators')>View Current Administrator</a></li>
                            <li><a href='javascript:void(0)' onclick=javascript:logout()>Log Out</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)">Pizza</a>
                        <ul>
                            <li><a href="javascript:void(0)" onclick=javascript:sendRequest('viewIngredients')>Ingredient</a><!--
                                <ul>
                                    <li><a href="javascript:void(0)" onclick=javascript:sendRequest('newIngredient')>New Ingredient</a></li>
                                    <li><a href="javascript:void(0)" onclick=javascript:sendRequest('viewIngredients')>View All Ingredients</a></li>
                                </ul>-->
                            </li>
                            <li><a href="javascript:void(0)">Pizza</a>
                                <ul>
                                    <li><a href='javascript:void(0)' onclick=javascript:sendRequest('newPizza')>New Pizza</a></li>
                                    <li><a href='javascript:void(0)' onclick=javascript:sendRequest('viewPizzas')>View All Pizzas</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!--<li><a href='javascript:void(0)' onclick=javascript:sendRequest('pizzasRank')>Pizza Rank</a></li>-->
                </ul>
            </div>
            <div id="content">
                <!--the required content-->
                <!--the default content here should be the orders` list-->
            </div>
        </div>
        <div id="footer">
            <p>author: Li Hao</p>
            <p>Time: July 2013</p>
            <p>Email: gxlzlihao@gmail.com Telephone;+46-0739051551</p>
        </div>
    </body>
</html>
