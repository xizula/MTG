<?php
session_start();
include "db.php";
include "getgc.php";
$uname = $_SESSION['username'];
$gcname = $_SESSION['gc'];
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <style> @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap'); </style>
    </head>
    <body>
        <nav>
            <li><a href = 'collection.php'>Kolekcja</a></li>
            <li><a href = 'deck.php'>Talie</a></li>
            <li><a href = 'to_buy.php'>Do kupienia</a></li>
            <li><a href = 'to_sell.php'>Do sprzedaży</a></li>
            <li><a href = 'global.php' class = 'act'>Baza kart</a></li>
            <li><a href = 'sell_offer.php'>Oferty sprzedaży</a></li>
            <li><a href = 'logout.php'>Wyloguj</a></li>
        </nav>
    <section class = 'add'>
        <h1>Baza kart MTG</h1>
        <form name = 'cardsearch' method="get|post" class = 'but' >
            <input type='text' placeholder = 'Nazwa karty' name ='globcard' id ='globcard' class='find'>
            <button type = 'submit' id='findgc' name ='findgc' class ='button smaller'>Szukaj</button>
        </form>
    </section>
 

    <?php

        $sql = "call find_global_card('$gcname')";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result)>0) {
            echo "<table>" . "<tr>" . 
            "<th class = 'lt'>" . "GCID" . "</th>" . 
            "<th>" . "Name" . "</th>" .
            "<th>" . "Colors" . "</th>" .
            "<th>" . "Mana Value" . "</th>" .
            "<th>" . "Text" . "</th>" .
            "<th>" . "Power" . "</th>" .
            "<th>" . "Toughness" . "</th>" .
            "<th class = 'rt'>" . "Type" . "</th>" .
            "</tr>";
            while($row=mysqli_fetch_assoc($result)) {
                echo "<tr>" . "<td>" . $row['gcid'] . "</td>" . "<td>" . $row['name'] . "</td>" . "<td>" . $row['colors'] . "</td>" . "<td>" . $row['manaValue'] . "</td>" . "<td>" . $row['text'] . "</td>" . "<td>" . $row['power'] . "</td>" . "<td>" . $row['toughness'] . "</td>" . "<td>" . $row['type'] . "</td>" . "</tr>";
                
            }
        }
        else {
            echo "<h1> Podaj nazwę karty </h1>";
        }
    ?>
    </table>
    </body>
</html>