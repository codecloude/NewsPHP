<?php
    $Login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $UserName = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $UserPass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

    if(mb_strlen($Login) < 5 || mb_strlen($Login) > 90){
        echo "Недопустимая длина логина";
        exit();
    } else if (mb_strlen($UserName) < 2 || mb_strlen($UserName) > 50){
        echo "Недопустимая длина имени";
        exit();
    } else if(mb_strlen($UserPass) < 2 || mb_strlen($UserPass) > 10){
        echo "Недопустимая длина пароля (от 2 до 6 символов)";
        exit();
    }

    $UserPass = md5($pass."sdfghru849");

    $conn = new mysqli('localhost', 'root', '', 'amogus');
    $conn->query("INSERT INTO `users` (`Login`, `UserPass`, `UserName`)
    VALUES('$Login', '$UserPass', '$UserName')");

    $conn->close();

    header('Location: /auth.php');
    
?>