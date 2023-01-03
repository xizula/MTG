<?php
if(isset($_REQUEST['login'])) {
    $result = login($con, $username, $password);
    if ($result) {
        foreach($result as $r) {
            $pwd_check = password_ver($password, $r['Password']);
            if($pwd_check) {
                $_SESSION['username'] = $r['Username'];
                header('Location: static.php');
            }
            else {
                echo "Niepoprawne haslo";
            }
        }
    }
    else {
        echo "Użytkownik nie istnieje";
    }
}
?>