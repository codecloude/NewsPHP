<?php
    session_start();

    $OrdID = $_SESSION['order'];

    $conn = new mysqli('localhost', 'root', '', 'amogus');

    $conn->query("DELETE FROM orders
    WHERE OrdID = $OrdID");
    

    $conn->close();
    session_destroy();



    header('Location: /isadmin.php');