<?php
session_start();
require 'model.php';

if (empty($_SESSION['chart'])) {
    header('Location: index.php');
}

echo "Sumulacja płatonści online... <br>";

foreach ($_SESSION['chart'] as $id) {
    $query = $con->prepare("UPDATE `Books` SET `amount`=`amount`-1 WHERE `ID` = ?");
    $query->bind_param('i', $id);
    $query->execute();
}

if ($query = $con->prepare("INSERT INTO `Orders` (user, products, order_date, status, final_amount) VALUES (?, ?, ?, ?, ?)")) {
    $json = "" . json_encode($_SESSION['chart']);
    $date = "" . date("Y-m-d");
    $status = "opłacone";
    $query->bind_param('isssd', intval($_SESSION['id']), $json, $date, $status, $_SESSION['amount']);
    $query->execute();
}

unset($_SESSION['amount']);
$_SESSION['chart'] = [];

echo "Proces zamówiania zakończony";

echo "<script>alert('Dodano zamówienie!')</script>";
header('Location: index.php');
