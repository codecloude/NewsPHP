<?php
    session_start();
    $_SESSION['vkidd']=$_GET['uid'];
    $_SESSION['vkname']=$_GET['first_name'];
    // $_SESSION['vkfam']=$_GET['last_name'];

    $VkID = $_SESSION['vkidd'];
    $VkName = $_SESSION['vkname'];
    // $VkFam = $_SESSION['vkfam'];

    $conn = new mysqli('localhost', 'root', '', 'amogus');

    $result1 = $conn->query("SELECT * FROM `users` WHERE `Login` = '$VkName'
    AND `UserID` = '$VkID'");

    $user = $result1->fetch_assoc();
    if (count($user) == 0) {
        $conn->query("INSERT INTO `users` (`Login`, `UserID`, `UserName`)
        VALUES('$VkName', '$VkID', '$VkName')");
        $conn->close();
    } 


    setcookie('user', $_SESSION['vkname'], time() + 10000, "/");
    setcookie('id', $_SESSION['vkidd'], time() + 10000, "/");
    setcookie('userRole', $user['UserRole'], time() + 10000, "/");
    // setcookie('user', $user['Login'], time() + 10000, "/");
    // setcookie('id', $user['UserID'], time() + 10000, "/");
    // setcookie('userRole', $user['UserRole'], time() + 10000, "/");
    $conn->close();
    session_destroy();

    header('Location: /mainpage.php');

    

