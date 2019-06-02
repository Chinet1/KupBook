</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-36">
    <a class="navbar-brand" href="index.php">
        <img src="img/logo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Strona Główna <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ksiazki.php">Przeglądaj zasoby</a>
            </li>
            <?php
            if ($_SESSION['role'] === 'admin') {
                echo "<li class='nav-item'>
                    <a class='nav-link' href='admin.php'>Administracja</a>
                </li>";
            }
            if ($_SESSION['loggedin']) {
                echo '
                        <li class="nav-item">
                        <a class="nav-link"  href="koszyk.php">Koszyk ('. sizeof($_SESSION['chart']) .')</a>
                        </li>
                           <li class="nav-item active">
                              <a class="nav-link" href="profile.php">Zalogowany jako ' . $_SESSION['name'] . '</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="logout.php">Wyloguj</a>
                          </li>';
            } else {
                echo '<li class="nav-item">
                            <a class="nav-link" href="login.php">Zaloguj się</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Zarejestruj się</a>
                        </li>';
            }
            ?>
        </ul>
    </div>
</nav>
