<?php
    session_start();

    $OrdID = $_SESSION['order'];
    $Status = $_POST['status'];
    $conn = new mysqli('localhost', 'root', '', 'amogus');
    $conn->query("UPDATE `orders` SET StatusReq = $Status WHERE OrdID = $OrdID");

    $conn->close();
    session_destroy();

    header('Location: /isadmin.php');
?>