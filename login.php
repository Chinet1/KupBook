<?php
    include 'model.php';
    session_start();

    if ($_SESSION['loggedin']) {
        header('Location: index.php');
    }

    if (isset($_POST['submitted'])) {

        if (mysqli_connect_errno()) {
            die ('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
        }

        if (empty($_POST['login']) || empty($_POST['password'])) {
            die ('Uzupełnij oba pola formularza logowania!');
        }

        if ($query = $con->prepare('SELECT id, password, role FROM `Users` WHERE email = ?')) {
            $query->bind_param('s', $_POST['login']);
            $query->execute();
            $query->store_result();

            if ($query->num_rows > 0) {
                $query->bind_result($id, $password, $role);
                $query->fetch();
                if (password_verify($_POST['password'], $password)) {
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $_POST['login'];
                    $_SESSION['id'] = $id;
                    echo 'Welcome ' . $_SESSION['name'] . '!';
                } else {
                    echo 'Nieprawodiłowe hasło!';
                }
            } else {
                echo 'Użytkownik o takim adresie e-mail nie istnieje!';
            }
            $query->close();
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
                <input type="hidden" name="submitted">
                <input type="submit" value="Zaloguj!">
            </form>
        </div>
    </div>
</div>
</body>
</html>
