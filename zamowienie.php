<?php
session_start();
require 'model.php';

if (empty($_SESSION['chart'])) {
    header('Location: index.php');
}

require_once 'partials/header.php';
?>
<title>KupBook - zamówienie</title>
<meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Zamówienie</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span>Zamówione pozycje:</span>
            <ul>
        <?php
        $i = 0;
        $amount = 0;
        foreach ($_SESSION['chart'] as $id) {
            $query = $con->prepare("SELECT concat(`Authors`.`name`, ' ', `Authors`.`last_name`) AS 'author', `title`, `price` FROM `Books` JOIN `Authors` ON `Books`.`author` = `Authors`.`ID` WHERE `Books`.`ID` = ?");
            $query->bind_param('i', $id);
            $query->execute();
            $result = mysqli_fetch_assoc($query->get_result());
            echo "<li>". $result['author'] . " - ". $result['title'] . " - ". $result['price'] ." zł</li>";
            $amount += $result['price'];
            $i++;
        }
        ?>
            </ul>
            <span>Razem <?php echo $amount;?> zł</span><br><br>
            <span>Zamówienie zostanie wysłane na adres:</span><br>
            <?php
            $query = $con->prepare("SELECT `address` FROM `Clients` WHERE `user_id` = ?");
            $query->bind_param('i', $_SESSION['id']);
            $query->execute();
            $result = mysqli_fetch_assoc($query->get_result());
            echo $_SESSION['name'];
            echo "<br>";
            echo $result['address'];
            ?>
            <br><br>
            <span>Koszt wysyłki kurierem - 15 zł</span><br><br>
            <?php
                $amount += 15;
                $_SESSION['amount'] = $amount;
                echo "<span>Kwota końcowa: ". $amount ." zł</span>"
            ?>
            <a class="btn-add mo" href="order.php">Zamów</a>
        </div>
    </div>
</div>
<?php
$query->close();
require_once 'partials/footer.php'; ?>
