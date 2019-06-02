<?php
session_start();
require 'model.php';
if (!$_SESSION['loggedin']) {
    header('Location: index.php');
}
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
$query->close();

$from    = 'noreply@kupbook.pl';
$subject = 'KupBook - Potwierdzenie zamowienia';
$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
$message = '<p>Zamówienie w KupBook zostało wykonane porawnie. Możesz spokojnie czekać na kuriera :)</p>';
mail($_SESSION['email'], $subject, $message, $headers);

unset($_SESSION['amount']);
$_SESSION['chart'] = [];

echo "Proces zamówiania zakończony";

echo "<script>alert('Dodano zamówienie!')</script>";
header('Location: index.php');
