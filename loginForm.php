<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>World Cup 2018 - Login</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container text-center">
    <h1>Zaloguj się na swoje konto</h1>
    <form method="POST" action="login.php">
        <div>
            <label for="nameField">Login:</label>
            <div>
                <input type="text" name="username" class="forms" id="nameField" placeholder="Login"/>
            </div>
        </div>
        <div>
            <label for="passwordField">Hasło:</label>
            <div>
                <input type="password" name="password" class="forms" id="passwordField" placeholder="Hasło"/>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-success button">Zaloguj się</button>
        </div>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error']. '</div>';
            unset($_SESSION['error']);
        }
        ?>
    </form>
    <hr/>
    <div class="row">
        <h4>Nie masz konta? <a href="registerForm.php" class="btn btn-info links">Zarejestruj się</a></h4>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>