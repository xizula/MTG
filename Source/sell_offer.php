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
            <li><a href = 'to_sell.php'>Na sprzedaż</a></li>
            <li><a href = 'global.php'>Baza kart</a></li>
            <li><a href = 'sell_offer.php' class = 'act'>Oferty sprzedaży</a></li>
            <li><a href = 'logout.php'>Wyloguj</a></li>
        </nav>
    <section class = 'add'>
        <h1>Karty na sprzedaż innych uzytkowników</h1>
    </section>
    
    <table class = 'table'>
        <tr>
            <th class = 'lt'>Username</th>
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
        $sql = "call all_to_sell('$uname')";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result)>0) {
            while($row=mysqli_fetch_assoc($result)) {
                echo "<tr>" . "<td>" . $row['username'] . "</td>" . "<td>" . $row['gcid'] . "</td>" . "<td>" . $row['name'] . "</td>" . "<td>" . $row['colors'] . "</td>" . "<td>" . $row['manaValue'] . "</td>" . "<td>" . $row['text'] . "</td>" . "<td>" . $row['power'] . "</td>" . "<td>" . $row['toughness'] . "</td>" . "<td>" . $row['type'] . "</td>" . "</tr>";
                
            }
        }
    ?>
    </table>
    <script src="script.js"></script>
    </body>
</html>