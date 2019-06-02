<?php
session_start();
require 'model.php';
    if (isset($_GET['addToChart'])) {
        if (!isset($_SESSION['loggedin'])) {
            header('Location: login.php');
            die();
        }
        array_push($_SESSION['chart'], intval($_GET['addToChart']));
        header('Location: ksiazki.php');
    }
require_once 'partials/header.php';
?>
    <title>KupBook - książki</title>
    <meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Książki</h1>
            </div>
        </div>
        <div class="row">
            <form class="search-form" action="ksiazki.php" method="get">
                <input type="text" name="q" placeholder="Wyszukaj książke po tytule">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="row">
        <?php
        if (isset($_GET['q'])) {
            $query = $con->prepare("SELECT `Books`.`ID` as 'ID', concat(`Authors`.`name`, ' ', `Authors`.`last_name`) AS 'author', `title`, `price`, `cover`, `amount` FROM `Books` JOIN `Authors` ON `Books`.`author` = `Authors`.`ID` WHERE `title` LIKE ?");
            $param = "%". $_GET['q'] . "%";
            $query->bind_param('s', $param);
            $query->execute();
            $result = $query->get_result();
        } else {
            $query = $con->prepare("SELECT `Books`.`ID` as 'ID', concat(`Authors`.`name`, ' ', `Authors`.`last_name`) AS 'author', `title`, `price`, `cover`, `amount` FROM `Books` JOIN `Authors` ON `Books`.`author` = `Authors`.`ID`");
            $query->execute();
            $result = $query->get_result();
        }

        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='col-md-4'><div class='book'>";
            echo "<img src='img/covers/". $row['cover'] . "' alt='". $row['title'] . "'><br>";
            echo "<span class='title'>" . $row['title'] . "</span><br>";
            echo "<span class='author'>" . $row['author'] . "</span><br>";
            echo "<span class='price'>" . $row['price'] . " zł</span><br>";
            if ($row['amount'] === 0) {
                echo "<span class='btn-add disabled'>Niedostępna</span>";
            } else {
                echo "<a href='ksiazki.php?addToChart=". $row['ID'] ."' class='btn-add'>Dodaj do koszyka</a>";
            }
            echo "</div></div>";
        }
        $query->close();
        ?>
        </div>
    </div>
<?php require_once 'partials/footer.php'; ?>
