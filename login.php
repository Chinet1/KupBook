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

?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KupBook</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-36">
    <a class="navbar-brand" href="#">
        <img src="img/logo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Strona Główna <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Zaloguj się</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Zarejestruj się</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Przeglądaj zasoby</a>
            </li>
        </ul>
    </div>
</nav>
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
</body>
</html>
