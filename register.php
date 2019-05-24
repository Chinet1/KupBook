<?php
include 'model.php';
session_start();
header("Content-Type: text/html; charset=utf-8");
if ($_SESSION['loggedin']) {
    header('Location: index.php');
}

if (isset($_POST['submit'])) {

    if (mysqli_connect_errno()) {
        die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
    }

    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['name']) || empty($_POST['lastname']) || empty($_POST['address1']) || empty($_POST['password1'])) {
        echo '<script>alert("Uzupełnij pola formularza logowania!")</script>';
    } else {
        if (strcmp($_POST['password'], $_POST['password1'])) {
            echo '<script>alert("Podane hasła różnią się!")</script>';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Adres e-mail jest nieprawidłowy!")</script>';
        } elseif (strlen($_POST['name']) > 30) {
            echo '<script>alert("Imie nie może być dłuższe niż 30 znaków!")</script>';
        } elseif (strlen($_POST['lastname']) > 30) {
            echo '<script>alert("Nazwisko nie może być dłuższe niż 30 znaków!")</script>';
        } elseif (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            echo '<script>alert("Hasło musi zawierać od 5 do 20 znaków!")</script>';
        } else {
            if ($query = $con->prepare('SELECT id, password FROM `Users` WHERE email = ?')) {
                $query->bind_param('s', $_POST['email']);
                $query->execute();
                $query->store_result();
                if ($query->num_rows > 0) {
                    echo '<script>alert("Konto z podanym adresem e-mail już istnieje")</script>';
                } else {
                    if ($query = $con->prepare('INSERT INTO `Users` (email, password, role, activation_code) VALUES (?, ?, ?, ?)')) {
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $uniqid = uniqid();
                        $role = "user";
                        $query->bind_param('ssss', $_POST['email'], $password, $role, $uniqid);
                        $query->execute();
                        $id = $query->insert_id;
                        if ($query2 = $con->prepare('INSERT INTO `Clients` (name, last_name, address, user_id) VALUES (?, ?, ?, ?)')) {
                            $address = $_POST['address1'] . ", " . $_POST['address2'];
                            $query2->bind_param('sssi', $_POST['name'], $_POST['lastname'], $address, $id);
                            $query2->execute();
                            $from    = 'noreply@mateuszzbylut.com';
                            $subject = 'KupBook - Link aktywacyjny';
                            $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
                            $activate_link = 'http://localhost/KupBook/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
                            $message = '<p>Wersja Localhost <br>Kliknij w następujący link by aktyowawać konto: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
                            mail($_POST['email'], $subject, $message, $headers);
                            echo '<script>alert("Sprawdź swoją skrzynkę, wiadomość z linkiem aktywacyjnym została wysłana.")</script>';
                        } else {
                            echo '<script>alert("Wystąpił problem przy tworzeniu konta, spróbuj jeszcze raz!"' . $query2->error .')</script>';
                        }
                        $query2->close();
                    } else {
                        echo '<script>alert("Wystąpił problem przy tworzeniu konta, spróbuj jeszcze raz!" ' . $query->error .')</script>';
                    }
                }
                $query->close();
            } else {
                echo '<script>alert("Wystąpił problem przy tworzeniu konta, spróbuj jeszcze raz!" ' . $query->error .')</script>';
            }
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
                <a class="nav-link" href="#">Przeglądaj zasoby</a>
            </li>
        </ul>
        <ul class="navbar-nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="#">Zaloguj się</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Zarejestruj się</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Zarejestruj się!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form class="login tac" action="register.php" method="post">
                <label for="email">E-mail <br>
                    <input type="email" name="email" required></label> <br>
                <label for="name">Imię <br>
                    <input type="text" name="name" required></label> <br>
                <label for="lastname">Nazwisko <br>
                    <input type="text" name="lastname" required></label> <br>
                <label for="address1">Adres <br>
                    <input type="text" name="address1" required></label> <br>
                <label for="address1">Adres cd <br>
                    <input type="text" name="address2"></label> <br>
                <label for="password">Hasło <br>
                    <input type="password" name="password" required></label> <br>
                <label for="password1">Powtórz hasło <br>
                    <input type="password" name="password1" required></label> <br>
                <input type="submit" name="submit" value="Zarejestruj!">
            </form>
        </div>
    </div>
</div>
</body>
</html>
