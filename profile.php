<?php
require 'model.php';
session_start();
if (!$_SESSION['loggedin']) {
    header('Location: login.php');
}

if ($query = $con->prepare('SELECT `address` FROM `Clients` WHERE `user_id` =  (?)')) {
    $query->bind_param('i', $_SESSION['id']);
    $query->execute();
    $query->store_result();
    $query->bind_result($address);
    $query->fetch();
} else {
    die("Wystąpił błąd");
}

require_once 'partials/header.php';
?>
    <title>KupBook</title>
    <meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Witaj <?php echo $_SESSION['name']; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php if (strcmp($_SESSION['role'], 'admin')) echo "Jesteś administratorem! <br>";?>
                Twój e-mail: <?php echo $_SESSION['email']; ?> <br>
                Adres: <?php echo $address; ?>
            </div>
        </div>
    </div>
<?php require_once 'partials/footer.php'; ?>
