<?php
    include 'model.php';
    session_start();

    if ($_SESSION['loggedin']) {
        header('Location: index.php');
    }

    if (isset($_POST['submit'])) {

        if (mysqli_connect_errno()) {
            die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
        }

        if (empty($_POST['login']) || empty($_POST['password'])) {
            echo '<script>alert("Uzupełnij oba pola formularza logowania!")</script>';
        } else {
            if ($query = $con->prepare('SELECT id, password, role, activation_code FROM `Users` WHERE email = ?')) {
                $query->bind_param('s', $_POST['login']);
                $query->execute();
                $query->store_result();

                if ($query->num_rows > 0) {
                    $query->bind_result($id, $password, $role, $activation_code);
                    $query->fetch();
                    if (password_verify($_POST['password'], $password)) {
                        $query = $con->prepare('SELECT name, last_name FROM `Clients` WHERE ID = ?');
                        $query->bind_param('i', $id);
                        $query->execute();
                        $query->store_result();
                        $query->bind_result($name, $last_name);
                        $query->fetch();
                        if ($activation_code == 'activated') {
                            session_regenerate_id();
                            $_SESSION['loggedin'] = TRUE;
                            $_SESSION['email'] = $_POST['login'];
                            $_SESSION['name'] = $name . ' ' . $last_name;
                            $_SESSION['id'] = $id;
                            header('Location: index.php');
                        } else {
                            echo '<script>alert("Konto nie zostało jeszcze aktywowane!")</script>';
                        }
                    } else {
                        echo '<script>alert("Nieprawodiłowe hasło!")</script>';
                    }
                } else {
                    echo '<script>alert("Użytkownik o takim adresie e-mail nie istnieje!")</script>';
                }
                $query->close();
            }
        }
    }
require_once 'partials/header.php';
?>
<title>KupBook</title>
<meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Zaloguj się!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form class="login tac" action="login.php" method="post">
                <label for="login">Login <br>
                <input type="text" name="login"></label> <br>
                <label for="password"> Hasło <br>
                <input type="password" name="password"></label> <br>
                <input type="submit" name="submit" value="Zaloguj!">
            </form>
        </div>
    </div>
</div>
<?php require_once 'partials/footer.php'; ?>
