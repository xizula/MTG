<?php
session_start();
include "db.php";
include "getdeck.php";
include "actions.php";
$uname = $_SESSION['username'];
$dname = $_SESSION['dname'];
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
            <li><a href = 'deck.php' class = 'act'>Talie</a></li>
            <li><a href = 'to_buy.php'>Do kupienia</a></li>
            <li><a href = 'to_sell.php'>Do sprzedaży</a></li>
            <li><a href = 'global.php'>Baza kart</a></li>
            <li><a href = 'sell_offer.php'>Oferty sprzedaży</a></li>
            <li><a href = 'logout.php'>Wyloguj</a></li>
        </nav>
    <section class = 'add'>
        <h1>Talie <?php echo $uname ?></h1>
        <form name = 'decksearch' method="get|post" class = 'but' >
            <input type='text' placeholder = 'Nazwa Talii' name ='deckname' id ='deckname' class='find'>
            <button type = 'submit' id='search' name ='search' class ='button smaller'>Szukaj</button>
        </form>
        <div class = 'but'>
            <div class = "popup" id = "add_to_coll">
                    <div class="overlay"></div>
                    <div class="content">
                        <div class="close-btn" onclick="add_to_coll()">&times;</div>
                        <h1>Dodaj kartę do talii</h1>
                        <p>W celu dodania do karty talii należy podać nazwę talii, do której karta ma zostać dodana oraz CID karty z kolekcji. CID karty można sprawdzić w zakładce <a href = collection.php><b>Kolekcja</b></a>.</p>
                        <form name = 'deckadd' method="get|post">
                            <input type='text' placeholder = 'Nazwa talii' name = 'dname' id = 'dname' class = 'find block'>
                            <input type='text' placeholder = 'CID karty' name = 'cid' id = 'cid' class = 'find block'>
                            <button type = 'submit' id='dadd' name ='dadd' class ='button smaller block'>Dodaj</button>
                        </form>
                    </div>
                </div>
                <button onclick="add_to_coll()" class = 'button'>Dodaj do talii</button>

                <div class = "popup" id = "rem_from_coll">
                    <div class="overlay"></div>
                    <div class="content">
                        <div class="close-btn" onclick="rem_from_coll()">&times;</div>
                        <h1>Usuń kartę z talii</h1>
                        <p>W celu usunięcia karty z talii należy podać nazwę talii, z której karta ma zostać usunięta oraz DID karty. DID karty można sprawdzić w zakładce <a href = deck.php><b>Talie</b></a> poprzez wpisanie odpowiedniej nazwy talii.</p>
                        <form name = 'deckrem' method="get|post">
                            <input type='text' placeholder = 'Nazwa talii' name = 'drname' id = 'drname' class = 'find block'>
                            <input type='text' placeholder = 'DID karty' name = 'did' id = 'did' class = 'find block'>
                            <button type = 'submit' id='drem' name ='drem' class ='button smaller block'>Usuń</button>
                        </form>
                    </div>
                </div>
                <button onclick="rem_from_coll()" class = 'button'>Usuń z talii</button>
        </div>
    </section>
    
    <?php
        $sql = "call user_deck('$uname', '$dname')";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result)>0) {
            echo "<table>" . "<tr>" . 
            "<th class = 'lt'>" . "DID" . "</th>" .
            "<th>" . "GCID" . "</th>" . 
            "<th>" . "Name" . "</th>" .
            "<th>" . "Colors" . "</th>" .
            "<th>" . "Mana Value" . "</th>" .
            "<th>" . "Text" . "</th>" .
            "<th>" . "Power" . "</th>" .
            "<th>" . "Toughness" . "</th>" .
            "<th class = 'rt'>" . "Type" . "</th>" .
            "</tr>";
            while($row=mysqli_fetch_assoc($result)) {
                
                echo "<tr>" . "<td>" . $row['did'] . "</td>" . "<td>" . $row['gcid'] . "</td>" . "<td>" . $row['name'] . "</td>" . "<td>" . $row['colors'] . "</td>" . "<td>" . $row['manaValue'] . "</td>" . "<td>" . $row['text'] . "</td>" . "<td>" . $row['power'] . "</td>" . "<td>" . $row['toughness'] . "</td>" . "<td>" . $row['type'] . "</td>" . "</tr>";
            }
        }
        else {
            echo "<h1> Podaj nazwę talii </h1>";
        }
    ?>
    </table>
    <script src="script.js"></script>
    </body>
</html>