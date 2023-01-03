<?php
session_start();
include "db.php";
include "getlogindata.php";
include "functions.php";
include "log.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <form name = 'loginform' method ='post'>
            <input type = "text" placeholder="Username" name="username" id="username">
            <input type = "password" placeholder="Password" name ="password" id="password">
            <button type = "submit" id = "login" name = "login">Login</button>
        </form>
    </body>
</html>

