<?php
    session_start();

    $OrdID = $_SESSION['order'];
    
    $Title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
    $Disc = filter_var(trim($_POST['disc']), FILTER_SANITIZE_STRING);
    // $Status = $_POST['status'];

    $name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    
    move_uploaded_file($tmp_name, "../uploads/" . $name);
    $picName = "../uploads/" . $name;
    
    $Cat = $_POST['categories'];

    $conn = new mysqli('localhost', 'root', '', 'amogus');


    if (!empty($name)) {
        $sql = "UPDATE `orders` SET `Img` = '$picName' WHERE `OrdID` = '$OrdID'";
        $conn->query($sql);
    }

    if (!empty($Title)) {
        $sql = "UPDATE `orders` SET `Title` = '$Title' WHERE `OrdID` = '$OrdID'";
        $conn->query($sql);
    }

    if (!empty($Disc)) {
        $sql = "UPDATE `orders` SET `Description` = '$Disc' WHERE `OrdID` = '$OrdID'";
        $conn->query($sql);
    }

    if (!empty($Cat)) {
        $sql = "UPDATE `orders` SET `CatID` = '$Cat' WHERE `OrdID` = '$OrdID'";
        $conn->query($sql);
    }
    
    

    $conn->close();
    session_destroy();



    header('Location: http://mysite1bckup/myOrd.php?u='.$_COOKIE['id']);
?>