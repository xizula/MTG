<?php
    if(isset($_REQUEST['findgc'])) {
        $_SESSION['gc'] = $_REQUEST['globcard'];
    }
    else {
        $_SESSION['gc'] = '';
    }
?>