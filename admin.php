<?php
session_start();
require 'model.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");

}

if (isset($_POST['addBook'])) {
    if ($query = $con->prepare("INSERT INTO `Books`(`author`, `title`, `year`, `price`, `publisher`, `genre`, `cover`, `amount`) VALUES (?,?,?,?,?,?,?,?)")) {
        $query->bind_param('isidiisi', $_POST['author'], $_POST['title'], $_POST['year'], $_POST['price'], $_POST['publisher'], $_POST['genre'], $_POST['cover'], $_POST['amount']);
        $query->execute();
        header("Location: admin.php");
    }
}

if (isset($_POST['addAuthor'])) {
    if ($query = $con->prepare("INSERT INTO `Authors`(`name`, `last_name`) VALUES (?, ?)")) {
        $query->bind_param('ss', $_POST['name'], $_POST['last_name']);
        $query->execute();
        header("Location: admin.php");
    }
}

if (isset($_POST['addPublisher'])) {
    if ($query = $con->prepare("INSERT INTO `Publishers`(`name`) VALUES (?)")) {
        $query->bind_param('s', $_POST['name']);
        $query->execute();
        header("Location: admin.php");
    }
}

if (isset($_POST['addGenre'])) {
    if ($query = $con->prepare("INSERT INTO `Genre`(`name`) VALUES (?)")) {
        $query->bind_param('s', $_POST['name']);
        $query->execute();
        header("Location: admin.php");
    }
}

if (isset($_GET['rmb'])) {
    if ($query = $con->prepare("DELETE FROM `Books` WHERE `ID` = ?")) {
        $query->bind_param('i', intval($_GET['rmb']));
        $query->execute();
        header("Location: admin.php");
    }
}

if (isset($_GET['rmc'])) {
    if ($query = $con->prepare("DELETE FROM `Users` WHERE `ID` = ?")) {
        $query->bind_param('i', intval($_GET['rmc']));
        $query->execute();
        if ($query = $con->prepare("DELETE FROM `Clients` WHERE `user_id` = ?")) {
            $query->bind_param('i', intval($_GET['rmc']));
            $query->execute();
            header("Location: admin.php");
        }
    }
}

if (isset($_GET['rma'])) {
    if ($query = $con->prepare("DELETE FROM `Authors` WHERE `ID` = ?")) {
        $query->bind_param('i', intval($_GET['rma']));
        $query->execute();
        header("Location: admin.php");
    }
}

if (isset($_GET['rmp'])) {
    if ($query = $con->prepare("DELETE FROM `Publishers` WHERE `ID` = ?")) {
        $query->bind_param('i', intval($_GET['rmp']));
        $query->execute();
        header("Location: admin.php");
    }
}


if (isset($_GET['rmg'])) {
    if ($query = $con->prepare("DELETE FROM `Genre` WHERE `ID` = ?")) {
        $query->bind_param('i', intval($_GET['rmg']));
        $query->execute();
        header("Location: admin.php");
    }
}

if (isset($_GET['ctss'])) {
    if ($query = $con->prepare("UPDATE `Orders` SET `send_date`=?,`status`=? WHERE `ID` = ?")) {
        $date = "" . date("Y-m-d");
        $status = "wysłane";
        $query->bind_param('ssi', $date,$status, intval($_GET['ctss']));
        $query->execute();
        header("Location: admin.php?orders=t");
    }
}

require_once 'partials/header.php';
?>
    <title>KupBook - admin</title>
    <meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Panel administratora</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                Wybierz operacje:
                <ul>
                    <li><a href="admin.php?removeClient=t" class="del">Usuń klienta</a></li>
                    <li><a href="admin.php?addBook=t" class="add">Dodaj książkę</a></li>
                    <li><a href="admin.php?removeBook=t" class="del">Usuń książkę</a></li>
                    <li><a href="admin.php?addAuthor=t" class="add">Dodaj autora</a></li>
                    <li><a href="admin.php?removeAuthor=t" class="del">Usuń autora</a></li>
                    <li><a href="admin.php?addPublisher=t" class="add">Dodaj wydawnictwo</a></li>
                    <li><a href="admin.php?removePublisher=t" class="del">Usuń wydawnictwo</a></li>
                    <li><a href="admin.php?addGenre=t" class="add">Dodaj gatunek</a></li>
                    <li><a href="admin.php?removeGenre=t" class="del">Usuń gatunek</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <a href="admin.php?orders=t">Pokaż zamówienia</a>
            </div>
        </div>
        <?php
            if (isset($_GET['addBook'])) {
                $query = $con->prepare("SELECT `ID`, CONCAT(`name`, ' ', `last_name`) AS 'name' FROM `Authors`");
                $query->execute();
                $author = $query->get_result();

                $query = $con->prepare("SELECT `ID`, `name` FROM `Publishers`");
                $query->execute();
                $publisher = $query->get_result();

                $query = $con->prepare("SELECT `ID`, `name` FROM `Genre`");
                $query->execute();
                $genre = $query->get_result();

                echo "<div class='row'><div class='col tac'><h4>Dodaj książkę!</h4>";
                echo "<form action='admin.php' method='post' class='form-admin form-group'>";
                echo "<label for='title'>Tytuł</label><br><input class='form-control' type='text' name='title'><br>";
                echo "<label for='author'>Autor</label><br><select class='form-control' name='author'>";
                while ($row = mysqli_fetch_array($author)) {
                    echo "<option value='". $row['ID'] ."'>". $row['name'] ."</option>";
                }
                echo "</select><br>";
                echo "<label for='year'>Rok wydania</label><br><input class='form-control' type='text' name='year'><br>";
                echo "<label for='price'>Cena</label><br><input class='form-control' type='text' name='price'><br>";
                echo "<label for='publisher'>Wydawnictwo</label><br><select class='form-control' name='publisher'>";
                while ($row = mysqli_fetch_array($publisher)) {
                    echo "<option value='". $row['ID'] ."'>". $row['name'] ."</option>";
                }
                echo "</select><br>";
                echo "<label for='genre'>Gatunek</label><br><select class='form-control' name='genre'>";
                while ($row = mysqli_fetch_array($genre)) {
                    echo "<option value='". $row['ID'] ."'>". $row['name'] ."</option>";
                }
                echo "</select><br>";
                echo "<label for='cover'>Zdjęcie okładki</label><br><input class='form-control' type='text' name='cover'><br>";
                echo "<label for='amount'>Ilość na magazynie</label><br><input class='form-control' type='text' name='amount'><br>";
                echo "<input type='submit' name='addBook' value='Dodaj!' class='btn-add'><br><br>";
                echo "</form>";
                echo "</div></div>";
            } elseif (isset($_GET['removeBook'])) {
                $query = $con->prepare("SELECT `Books`.`ID`, CONCAT(`name`, ' ', `last_name`) as 'author', `title` FROM `Books` JOIN `Authors` ON `Books`.`author`=`Authors`.`ID`");
                $query->execute();
                $book = $query->get_result();
                echo "<h4 class='tac'>Usuń książkę!</h4><table class='table'><tr><th>Autor</th><th>Tytuł</th><th>Akcja</th></tr>";
                while ($row = mysqli_fetch_array($book)) {
                    echo "<tr><td>". $row['author'] ."</td><td>". $row['title'] ."</td><td><a href='admin.php?rmb=". $row['ID'] ."'>Usuń</a></td></tr>";
                }
                echo "</table>";
            } elseif (isset($_GET['removeClient'])) {
                $query = $con->prepare("SELECT `Users`.`ID` as 'ID', CONCAT(`Clients`.`name`, ' ', `Clients`.`last_name`) as 'name', `email` FROM `Clients` JOIN `Users` ON `Clients`.`user_id`=`Users`.`ID`");
                $query->execute();
                $client = $query->get_result();
                echo "<h4 class='tac'>Usuń klienta!</h4><table class='table'><tr><th>Imie i nazwisko</th><th>E-mail</th><th>Akcja</th></tr>";
                while ($row = mysqli_fetch_array($client)) {
                    echo "<tr><td>". $row['name'] ."</td><td>". $row['email'] ."</td><td><a href='admin.php?rmc=". $row['ID'] ."'>Usuń</a></td></tr>";
                }
                echo "</table>";
            } elseif (isset($_GET['addAuthor'])) {
                echo "<div class='row'><div class='col tac'><h4>Dodaj autora!</h4>";
                echo "<form action='admin.php' method='post' class='form-admin form-group'>";
                echo "<label for='name'>Imię</label><br><input class='form-control' type='text' name='name'><br>";
                echo "<label for='last_name'>Nazwisko</label><br><input class='form-control' type='text' name='last_name'><br>";
                echo "<input type='submit' name='addAuthor' value='Dodaj!' class='btn-add'><br><br>";
                echo "</form>";
                echo "</div></div>";
            } elseif (isset($_GET['removeAuthor'])) {
                $query = $con->prepare("SELECT `ID`, CONCAT(`name`, ' ', `last_name`) as 'author' FROM `Authors`");
                $query->execute();
                $author = $query->get_result();
                echo "<h4 class='tac'>Usuń autora!</h4><table class='table'><tr><th>Autor</th><th>Akcja</th></tr>";
                while ($row = mysqli_fetch_array($author)) {
                    echo "<tr><td>". $row['author'] ."</td><td><a href='admin.php?rma=". $row['ID'] ."'>Usuń</a></td></tr>";
                }
                echo "</table>";
            } elseif (isset($_GET['addPublisher'])) {
                echo "<div class='row'><div class='col tac'><h4>Dodaj wydawnictwo!</h4>";
                echo "<form action='admin.php' method='post' class='form-admin form-group'>";
                echo "<label for='name'>Nazwa</label><br><input class='form-control' type='text' name='name'><br>";
                echo "<input type='submit' name='addPublisher' value='Dodaj!' class='btn-add'><br><br>";
                echo "</form>";
                echo "</div></div>";
            } elseif (isset($_GET['removePublisher'])) {
                $query = $con->prepare("SELECT `ID`,`name` FROM `Publishers`");
                $query->execute();
                $publisher = $query->get_result();
                echo "<h4 class='tac'>Usuń wydawnictwo!</h4><table class='table'><tr><th>Nazwa</th><th>Akcja</th></tr>";
                while ($row = mysqli_fetch_array($publisher)) {
                    echo "<tr><td>". $row['name'] ."</td><td><a href='admin.php?rmp=". $row['ID'] ."'>Usuń</a></td></tr>";
                }
                echo "</table>";
            }  elseif (isset($_GET['addGenre'])) {
                echo "<div class='row'><div class='col tac'><h4>Dodaj gatunek!</h4>";
                echo "<form action='admin.php' method='post' class='form-admin form-group'>";
                echo "<label for='name'>Nazwa</label><br><input class='form-control' type='text' name='name'><br>";
                echo "<input type='submit' name='addGenre' value='Dodaj!' class='btn-add'><br><br>";
                echo "</form>";
                echo "</div></div>";
            } elseif (isset($_GET['removeGenre'])) {
                $query = $con->prepare("SELECT `ID`, `name`FROM `Genre`");
                $query->execute();
                $genre = $query->get_result();
                echo "<h4 class='tac'>Usuń gatunek!</h4><table class='table'><tr><th>Nazwa</th><th>Akcja</th></tr>";
                while ($row = mysqli_fetch_array($genre)) {
                    echo "<tr><td>". $row['name'] ."</td><td><a href='admin.php?rmg=". $row['ID'] ."'>Usuń</a></td></tr>";
                }
                echo "</table>";
            } elseif (isset($_GET['orders'])) {
                $query = $con->prepare("SELECT `Orders`.`ID` as 'ID', CONCAT(`name`, ' ', `last_name`) as 'user', `products`, `order_date`, `send_date`, `status`, `final_amount` FROM `Orders` JOIN `Clients` ON `Orders`.`user`=`Clients`.`user_id`");
                $query->execute();
                $genre = $query->get_result();
                echo "<h4 class='tac'>Wykaz zamówień</h4><table class='table'><tr><th>Klient</th><th>Produkty (ID)</th><th>Data zamówienia</th><th>Data wysłania</th><th>Status</th><th>Kwota</th><th>Zmiana statusu</th></tr>";
                while ($row = mysqli_fetch_array($genre)) {
                    echo "<tr><td>". $row['user'] ."</td><td>". $row['products'] ."</td><td>". $row['order_date'] ."</td><td>". $row['send_date'] ."</td><td>". $row['status'] ."</td><td>". $row['final_amount'] ." zł</td><td><a href='admin.php?ctss=". $row['ID'] ."'>Wysłane</a></td></tr>";
                }
                echo "</table>";
            }
        ?>
    </div>
<?php require_once 'partials/footer.php'; ?>
