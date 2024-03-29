<?php
session_start();
require 'model.php';

require_once 'partials/header.php';
?>
<title>KupBook</title>
<meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Księgarnia internetowa</h1>
        </div>
    </div>
    <div class="row">
        <?php
        $query = $con->prepare("SELECT `Books`.`ID` as 'ID', concat(`Authors`.`name`, ' ', `Authors`.`last_name`) AS 'author', `title`, `price`, `cover`, `amount` FROM `Books` JOIN `Authors` ON `Books`.`author` = `Authors`.`ID` LIMIT 3");
        $query->execute();
        $result = $query->get_result();
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='col-md-4'><div class='book'>";
            echo "<img src='img/covers/". $row['cover'] . "' alt='". $row['title'] . "'><br>";
            echo "<span class='title'>" . $row['title'] . "</span><br>";
            echo "<span class='author'>" . $row['author'] . "</span><br>";
            echo "<span class='price'>" . $row['price'] . " zł</span><br>";
            echo "</div></div>";
        }
        $query->close();
        ?>
    </div>
    <div class="row">
        <div class="col">
            <a href="ksiazki.php" class="btn-add mo">ZOBACZ WIĘCEJ</a>
        </div>
    </div>
</div>
<?php require_once 'partials/footer.php'; ?>
