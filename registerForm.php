<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>World Cup 2018 - Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="container text-center">
    <h1>World Cup 2018 - stwórz darmowe konto</h1>
    <div class="row">
        <h3>Masz konto?</h3>
        <h4><a href="loginForm.php" class="btn btn-info links">Zaloguj się</a></h4>
    </div>
    <hr/>
    <form method="POST" action="register.php">
        <div>
            <label for="nameField">Login:</label>
            <div>
                <input type="text" name="username" class="forms" id="nameField" placeholder="Login"/>
            </div>
        </div>
        <?php
        if (isset($_SESSION['e_username'])) {
            echo '<div class="error">' . $_SESSION['e_username']. '</div>';
            unset($_SESSION['e_username']);
        }
        ?>
        <div>
            <label for="emailField">E-mail</label>
            <div>
                <input type="email" name="email" class="forms" id="emailField" placeholder="E-mail"/>
            </div>
        </div>
        <?php
        if (isset($_SESSION['e_email'])) {
            echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
            unset($_SESSION['e_email']);
        }
        ?>
        <div>
            <label for="passwordField">Hasło:</label>
            <div>
                <input type="password" name="password" class="forms" id="passwordField" placeholder="Hasło"/>
            </div>
        </div>
        <?php
        if (isset($_SESSION['e_password'])) {
            echo '<div class="error">' . $_SESSION['e_password'] . '</div>';
            unset($_SESSION['e_password']);
        }
        ?>
        <div class="g-recaptcha" data-sitekey="6LdV4z8UAAAAAM90r0fWRQMn4n_Cwunfq02pzZ9T"></div>
        <?php
        if (isset($_SESSION['e_bot'])) {
            echo '<div class="error">' . $_SESSION['e_bot'] . '</div>';
            unset($_SESSION['e_bot']);
        }
        ?>
        <div>
            <button type="submit" class="btn btn-success button">Zarejestruj się</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>