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
            <li><a href = 'collection.php'>Kolekcja</a></li>
            <li><a href = 'deck.php'>Talie</a></li>
            <li><a href = 'to_buy.php'>Do kupienia</a></li>
            <li><a href = 'to_sell.php'  class = 'act'>Do sprzedaży</a></li>
            <li><a href = 'global.php'>Baza kart</a></li>
            <li><a href = 'sell_offer.php'>Oferty sprzedaży</a></li>
            <li><a href = 'logout.php'>Wyloguj</a></li>
        </nav>
    <section class = 'add'>
        <h1>Karty, które <?php echo $uname ?> chce sprzedać</h1>
        <div class ='but'>
            <div class = "popup" id = "add_to_coll">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="add_to_coll()">&times;</div>
                    <h1>Dodaj kartę do sprzedaży</h1>
                    <p>W celu dodania do karty należy podać jej CID. CID karty można sprawdzić w zakładce <a href = 'collection.php'><b>Kolekcja</b></a>.</p>
                    <form name = 'selladd' method="get|post">
                        <input type='text' placeholder = 'CID karty' name = 'cid' id = 'cid' class = 'find'>
                        <button type = 'submit' id='sadd' name ='sadd' class ='button smaller'>Dodaj</button>
                    </form>
                </div>
            </div>
            <button onclick="add_to_coll()" class = 'button'>Dodaj kartę</button>

            <div class = "popup" id = "rem_from_coll">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="rem_from_coll()">&times;</div>
                    <h1>Usuń kartę do sprzedaży</h1>
                    <p>W celu usunięcia karty należy podać jej WTSID. ID karty można sprawdzić w zakładce <a href = 'to_sell.php'><b>Do sprzedaży</b></a>.</p>
                    <form name = 'sellrem' method="get|post">
                        <input type='text' placeholder = 'WTSID karty' name = 'wtsid' id = 'wtsid' class = 'find'>
                        <button type = 'submit' id='srem' name ='srem' class ='button smaller'>Usuń</button>
                    </form>
                </div>
            </div>
            <button onclick="rem_from_coll()" class = 'button'>Usuń kartę</button>
        </div>
    </section>
    
    <table class = 'table'>
        <tr>
            <th class = 'lt'>WTSID</th>
            <th>CID</th>
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
            $sql = "call user_want_to_sell('$uname')";
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result)>0) {
                while($row=mysqli_fetch_assoc($result)) {
                    echo "<tr>" . "<td>" . $row['WTSID'] . "</td>" . "<td>" . $row['cid'] . "</td>" . "<td>" . $row['gcid'] . "</td>" . "<td>" . $row['name'] . "</td>" . "<td>" . $row['colors'] . "</td>" . "<td>" . $row['manaValue'] . "</td>" . "<td>" . $row['text'] . "</td>" . "<td>" . $row['power'] . "</td>" . "<td>" . $row['toughness'] . "</td>" . "<td>" . $row['type'] . "</td>" . "</tr>";
                }
            }
        ?>
    </table>
    <script src="script.js"></script>
    </body>
</html>