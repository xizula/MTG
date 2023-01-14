<?php
if(isset($_REQUEST['login'])) {
    $result = login($con, $username, $password);
    if ($result) {
        foreach($result as $r) {
            $pwd_check = password_ver(hash('sha512', $password), $r['Password']);
            if($pwd_check) {
                $_SESSION['username'] = $r['Username'];
                header('Location: collection.php');
            }
            else {
                function_alert("Nieprawidłowe hasło");
            }
        }
    }
    else {
        function_alert("Użytkownik nie istnieje");
    }
}

if (isset($_REQUEST['register'])) {
    $login = $_REQUEST['uname'];
    $pass = $_REQUEST['passwd'];
    $pass2 = $_REQUEST['passwd2'];
    if ($pass === $pass2) {
        $p = hash('sha512', $pass);
        try {
            $sql = "call add_to_users('$login', '$p')";
            mysqli_query($con, $sql);
            function_alert("Pomyślnie zarejestrowano, zaloguj się");
        }
        catch (Exception $e) {
            function_alert("Wprowadzona nazwa użytkownika jest niepoprawna");
        }
    }
    else {
        function_alert("Hasła nie są ze sobą zgodne");
    }
}
?>