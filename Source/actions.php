<?php
include 'db.php';
include 'functions.php';
    if(isset($_REQUEST['add'])) {
        $gcid = $_REQUEST['gcid'];
        $name = $_SESSION['username'];
        $sql = "call add_to_collection('$name', $gcid)";
        try {
            unset($gcid);
            mysqli_query($con, $sql);
            function_alert("Karta dodana do kolekcji");
        }
        catch (Exception $e) {
            unset($gcid);
            function_alert("Dodawanie karty nie powiodło się");
        }
    }
    
    if(isset($_REQUEST['rem'])) {
        $cid = $_REQUEST['cid'];
        $name = $_SESSION['username'];
        $sql = "call delete_from_collection('$name', $cid)";
        try {
            unset($cid);
            mysqli_query($con, $sql);
            function_alert("Karta usunięta z kolekcji");
        }
        catch (Exception $e) {
            unset($cid);
            function_alert("Usuwanie karty nie powiodło się");
        }
    }

    if(isset($_REQUEST['send'])) {
        $cid = $_REQUEST['scid'];
        $rname = $_REQUEST['rname'];
        $name = $_SESSION['username'];
        $sql = "call send_card('$name', '$rname', $cid)";
        try {
            unset($cid);
            unset($rname);
            mysqli_query($con, $sql);
            function_alert("Karta pomyslnie wysłana");
        }
        catch (Exception $e) {
            unset($cid);
            unset($rname);
            function_alert("Wysyłanie karty nie powiodło się");
        }
    }

    if(isset($_REQUEST['dadd'])) {
        $cid = $_REQUEST['cid'];
        $dname = $_REQUEST['dname'];
        $name = $_SESSION['username'];
        $sql = "call add_to_deck('$name', '$dname', $cid)";
        try {
            unset($cid);
            unset($dname);
            mysqli_query($con, $sql);
            function_alert("Karta dodana do talii");
        }
        catch (Exception $e) {
            unset($cid);
            unset($dname);
            function_alert("Dodawanie karty nie powiodło się");
        }
    }

    if(isset($_REQUEST['drem'])) {
        $did = $_REQUEST['did'];
        $dname = $_REQUEST['drname'];
        $name = $_SESSION['username'];
        $sql = "call delete_from_deck('$name', '$dname', $did)";
        try {
            unset($cid);
            unset($dname);
            mysqli_query($con, $sql);
            function_alert("Karta usunięta z talii");
        }
        catch (Exception $e) {
            unset($did);
            unset($dname);
            function_alert("Usuwanie karty nie powiodło się");
        }
    }

    if(isset($_REQUEST['badd'])) {
        $gcid = $_REQUEST['bgcid'];
        $name = $_SESSION['username'];
        $sql = "call add_to_buy('$name', $gcid)";
        try {
            unset($gcid);
            mysqli_query($con, $sql);
            function_alert("Karta dodana");

        }
        catch (Exception $e) {
            unset($gcid);
            function_alert("Dodawanie karty nie powiodło się");
        }
    }

    if(isset($_REQUEST['brem'])) {
        $wtbid = $_REQUEST['wtbid'];
        $name = $_SESSION['username'];
        $sql = "call delete_from_buy('$name', $wtbid)";
        try {
            unset($wtbid);
            mysqli_query($con, $sql);
            function_alert("Karta usunięta");
        }
        catch (Exception $e) {
            unset($wtbid);
            function_alert("Usuwanie karty nie powiodło się");
        }
    }

    if(isset($_REQUEST['sadd'])) {
        $cid = $_REQUEST['cid'];
        $name = $_SESSION['username'];
        $sql = "call add_to_sell('$name', $cid)";
        try {
            unset($cid);
            mysqli_query($con, $sql);
            function_alert("Karta dodana");
        }
        catch (Exception $e) {
            unset($cid);
            function_alert("Dodawanie karty nie powiodło się");
        }
    }

        if(isset($_REQUEST['srem'])) {
            $wtsid = $_REQUEST['wtsid'];
            $name = $_SESSION['username'];
            $sql = "call delete_from_sell('$name', $wtsid)";
            try {
                unset($wtsid);
                mysqli_query($con, $sql);
                function_alert("Karta usunięta");
            }
            catch (Exception $e) {
                unset($wtsid);
                function_alert("suwanie karty nie powiodło się");
            }
    }

?>