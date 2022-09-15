<?php
    setcookie('user', $user['Login'], time() - 10000, "/");
    setcookie('id', $user['UserID'], time() - 10000, "/");
    setcookie('userRole', $user['UserRole'], time() - 10000, "/");

    header('Location: /mainpage.php');