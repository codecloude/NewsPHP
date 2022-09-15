<?php
    $Login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $UserPass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

    $UserPass = md5($pass."sdfghru849");


    $conn = new mysqli('localhost', 'root', '', 'amogus');
    $result1 = $conn->query("SELECT * FROM `users` WHERE `Login` = '$Login'
    AND `UserPass` = '$UserPass'");

    $user = $result1->fetch_assoc();
    if (count($user) == 0) {
        echo "Такой пользователь не найден";
        exit();
    } 

    setcookie('user', $user['Login'], time() + 10000, "/");
    setcookie('id', $user['UserID'], time() + 10000, "/");
    setcookie('userRole', $user['UserRole'], time() + 10000, "/");
    $conn->close();

    header('Location: /mainpage.php');
?>