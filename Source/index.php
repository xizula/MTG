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
        <style> @import url('https://fonts.googleapis.com/css2?family=Cinzel&display=swap'); </style>
    </head>
    <body>
        <section class = 'center'>
            <img src = 'mtg.png'/>
            <h1 class ='title'>MTG Manager</h1>
            <div class = "popup" id = "add_to_coll">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="add_to_coll()">&times;</div>
                    <h1>Zaloguj się</h1>
                    <form name = 'loginform' method ='post'>
                        <input type = "text" placeholder="Nazwa Użytkownika" name="username" id="username" class= 'block find'>
                        <input type = "password" placeholder="Hasło" name ="password" id="password" class= 'block find'>
                        <button type = "submit" id = "login" name = "login" class= 'block button'>Login</button>
                    </form>
                </div>
            </div>
            <button onclick="add_to_coll()" class = 'log'>Logowanie</button>

            <div class = "popup" id = "rem_from_coll">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="rem_from_coll()">&times;</div>
                    <h1>Zarejestruj się</h1>
                    <form name = 'loginform' method ='post'>
                        <input type = "text" placeholder="Nazwa Użytkownika (max. 50 znaków)" name="uname" id="uname" class= 'block find'>
                        <input type = "password" placeholder="Hasło" name ="passwd" id="passwd" class= 'block find'>
                        <input type = "password" placeholder="Powtórz hasło" name ="passwd2" id="passwd2" class= 'block find'>
                        <button type = "submit" id = "register" name = "register" class= 'block button'>Rejestracja</button>
                    </form>
                </div>
            </div>
            <button onclick="rem_from_coll()" class = 'log'>Rejestracja</button>
        </section>    

        <script src="script.js"></script>
    </body>
</html>

