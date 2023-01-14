<?php
function login($con, $username, $password) {
    $existcheck = "select exists(select * from `users` where `Username` = '$username')";
    $res = mysqli_query($con, $existcheck);
    while($row = mysqli_fetch_array($res))
    {
    $x = $row[0];
    }
    if ( $x == '1') {
        $sql = "SELECT * from users where Username = '$username'";
        $query = mysqli_query($con, $sql);
        return $query;
    }
    else {
        return false;
    }
}

function password_ver($p1, $p2) {
    if($p1 === $p2) {
        return true;
    }
    else {
        return false;
    }
}

function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>