<?php
    if(isset($_REQUEST['search'])) {
        $_SESSION['dname'] = $_REQUEST['deckname'];
    }
    else {
        $_SESSION['dname'] = '';
    }

?>