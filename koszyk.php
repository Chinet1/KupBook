<?php
session_start();
require 'model.php';
if (!$_SESSION['loggedin']) {
    header('Location: index.php');
}
if (isset($_GET['remove'])) {
    array_splice($_SESSION['chart'], intval($_GET['remove']), 1);
    header('Location: koszyk.php');
}

require_once 'partials/header.php';
?>
<title>KupBook - koszyk</title>
<meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Koszyk</h1>
        </div>
    </div>
        <?php
            if (empty($_SESSION['chart'])) {
                echo "<div class='row'>Koszyk jest pusty!</div>";
            } else {
                $i = 0;
                $amount = 0;
                foreach ($_SESSION['chart'] as $id) {
                    $query = $con->prepare("SELECT `Books`.`ID` as 'ID', concat(`Authors`.`name`, ' ', `Authors`.`last_name`) AS 'author', `title`, `price`, `Publishers`.`name` as 'publisher', `cover` FROM `Books` JOIN `Authors` ON `Books`.`author` = `Authors`.`ID` JOIN `Publishers` ON `Publishers`.`ID` = `Books`.`publisher` WHERE `Books`.`ID` = ?");
                    $query->bind_param('i', $id);
                    $query->execute();
                    $result = mysqli_fetch_assoc($query->get_result());
                    echo "<div class='row chart-list'><div class='col-2'><img src='img/covers/". $result['cover'] ."' alt='". $result['title'] ."'></div><div class='col-6 book-info'>";
                    echo "<span class='title'>" . $result['title'] . "</span>";
                    echo "<span class='author'>" . $result['author'] . "</span>";
                    echo "<span class='author'>Wydawnictwo: " . $result['publisher'] . "</span>";
                    echo "</div><div class='col-3 book-info tac'><span class='price'>" . $result['price'] . " zł</span></div>"
                        ."<div class='col-1 book-info'><a class='remove-link' href='koszyk.php?remove=". $i ."'><i class='fas fa-times'></i></a></div></div>";
                    $amount += $result['price'];
                    $i++;
                }
                echo "<div class='row'><div class='col chart-amount'>Razem: ". number_format($amount, 2) ." zł</div></div>"
                    ."<div class='row'><div class='col'><a href='zamowienie.php' class='btn-add mo'>Złóż zamówienie</a></div></div></div>";
            }
        $query->close();
        ?>
</div>
<?php require_once 'partials/footer.php'; ?>
