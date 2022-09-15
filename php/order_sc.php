<?php
    $Title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
    $Disc = filter_var(trim($_POST['disc']), FILTER_SANITIZE_STRING);

    if (!isset($_COOKIE['user'])) {
        echo "Вы не авторезированы";
        exit();
    }

    $UserID = $_COOKIE['id'];

    $name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $name = "../uploads/" . $name;
    move_uploaded_file($tmp_name, "../uploads/" . $name);
    
    $cat = $_POST['categories'];

    $conn = new mysqli('localhost', 'root', '', 'amogus');

    $conn->query("INSERT INTO `orders` (`User`, `Title`, `Description`, `Img`, `CatID`)
    VALUES('$UserID' ,'$Title', '$Disc', '$name', '$cat')");
    
    $conn->close();

    header('Location: /');
?>