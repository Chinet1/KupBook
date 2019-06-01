<?php
session_start();
require 'model.php';

require_once 'partials/header.php';
?>
    <title>KupBook - potwierdzenie</title>
    <meta name="description" content="KupBook - najlepsza księgarnia internetowa. Dobre książki, niskie ceny. Zajrzyj i przekonaj się!">
<?php require_once 'partials/menu.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Dziękujemy za zamówienie!</h1>
                <button class="btn-add mo" onclick="home()">Przejdź do strony głównej</button>
            </div>
        </div>
        <script>
            function home() {
                window.open('index.php', '_self');
            }
        </script>
    </div>
<?php require_once 'partials/footer.php'; ?>
