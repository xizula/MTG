<?php
session_start();
include "db.php";
include "actions.php";
$uname = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <style> @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap'); </style>
    </head>
    <body>
        <nav>
            <li><a href = 'collection.php' class = 'act'>Kolekcja</a></li>
            <li><a href = 'deck.php'>Talie</a></li>
            <li><a href = 'to_buy.php'>Do kupienia</a></li>
            <li><a href = 'to_sell.php'>Na sprzedaż</a></li>
            <li><a href = 'global.php'>Baza kart</a></li>
            <li><a href = 'sell_offer.php'>Oferty sprzedaży</a></li>
            <li><a href = 'logout.php'>Wyloguj</a></li>
        </nav>
    <section class = 'add'>
        <h1>Kolekcja <?php echo $uname ?></h1>

        <div class ='but'>
            <div class = "popup" id = "add_to_coll">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="add_to_coll()">&times;</div>
                    <h1>Dodaj kartę do kolekcji</h1>
                    <p>W celu dodania do karty kolekcji należy podać jej GCID. GCID karty można sprawdzić w zakładce <a href = global.php><b>Baza Kart</b></a> poprzez wpisanie nazwy karty.</p>
                    <form name = 'colladd' method="get|post">
                        <input type='text' placeholder = 'GCID karty' name = 'gcid' id = 'gcid' class = 'find'>
                        <button type = 'submit' id='add' name ='add' class ='button smaller'>Dodaj</button>
                    </form>
                </div>
            </div>
            <button onclick="add_to_coll()" class = 'button'>Dodaj do kolekcji</button>
            
            <div class = "popup" id = "rem_from_coll">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="rem_from_coll()">&times;</div>
                    <h1>Usuń kartę</h1>
                    <p>W celu usunięcia karty z kolekcji należy podać jej CID. CID karty można sprawdzić w zakładce <a href = 'collection.php'><b>Kolekcja</b></a>.</p>
                    <form name = 'collrem' method="get|post">
                        <input type='text' placeholder = 'CID karty' name = 'cid' id = 'cid' class = 'find'>
                        <button type = 'submit' id='rem' name ='rem' class ='button smaller'>Usuń</button>
                    </form>
                </div>
            </div>
            <button onclick="rem_from_coll()" class = 'button'>Usuń z kolekcji</button> 

            <div class = "popup" id = "send">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="send()">&times;</div>
                    <h1>Wyślij kartę</h1>
                    <p>W celu wysłania karty z kolekcji należy podać nazwę uzytkownika, któremu zostanie wysłana karta oraz CID karty, która ma zostać wysłana. CID karty można sprawdzić w zakładce <a href = collection.php><b>Kolekcja</b></a>.</p>
                    <form name = 'collsend' method="get|post">
                        <input type='text' placeholder = 'Nazwa użytkownika' name = 'rname' id = 'rname' class = 'find block'>
                        <input type='text' placeholder = 'CID karty' name = 'scid' id = 'scid' class = 'find block'>
                        <button type = 'submit' id='send' name ='send' class ='button smaller block'>Wyślij</button>
                    </form>
                </div>
            </div>
            <button onclick="send()" class = 'button'>Wyślij kartę</button> 
 
        </div>
    </section>

    <table class = 'table'>
        <tr>
            <th class = 'lt'>CID</th>
            <th>GCID</th>
            <th>Name</th>
            <th>Color</th>
            <th>Mana Value</th>
            <th>Text</th>
            <th>Power</th>
            <th>Toughness</th>
            <th class = 'rt'>Type</th>
        </tr>
        <?php
            $sql = "call user_collection('$uname')";
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result)>0) {
                while($row=mysqli_fetch_assoc($result)) {
                    echo "<tr>" . "<td>" . $row['cid'] . "</td>" . "<td>" . $row['gcid'] . "</td>" . "<td>" . $row['name'] . "</td>" . "<td>" . $row['colors'] . "</td>" . "<td>" . $row['manaValue'] . "</td>" . "<td>" . $row['text'] . "</td>" . "<td>" . $row['power'] . "</td>" . "<td>" . $row['toughness'] . "</td>" . "<td>" . $row['type'] . "</td>" . "</tr>";
                }
            }
        ?>
    </table>
    <script src="script.js"></script>
    </body>
</html>