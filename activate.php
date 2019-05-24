<?php
require 'model.php';
session_start();

if ($_SESSION['loggedin']) {
    header('Location: index.php');
}

if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $con->prepare('SELECT * FROM `Users` WHERE email = ? AND activation_code = ?')) {
        $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            if ($stmt = $con->prepare('UPDATE `Users` SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                echo '<script>alert("Konto aktywowane propawnie, możesz się zalogować!")</script>';
                header('Location: login.php');
            }
        } else {
            echo '<script>alert("Błąd, konto aktywowane lub nie istnieje!")</script>';
            header('Location: index.php');
        }
    }
}
