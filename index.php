<?php
session_start();
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
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Strona Główna <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Przeglądaj zasoby</a>
            </li>
            <?php
                if ($_SESSION['loggedin']) {
                    echo '<li class="nav-item active">
                              <a class="nav-link" href="#">Zalogowany jako ' . $_SESSION['name'] . '</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="logout.php">Wyloguj</a>
                          </li>';
                } else {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="login.php">Zaloguj się</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Zarejestruj się</a>
                        </li>';
                }

            ?>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Księgarnia internetowa</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">Wydawnictwo Mg</div>
        <div class="col">Wydawnictwo MUZA S.A.</div>
        <div class="col">Wydawnictwo Albatros</div>
    </div>
</div>
</body>
</html>
