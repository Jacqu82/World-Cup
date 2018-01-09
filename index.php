<?php

session_start();

if (isset($_SESSION['login'])) {
    header('Location: mainPage.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>World Cup 2018</title>
    <meta name="description" content="World Cup 2018 App">
    <meta name="keywords" content="World Cup, Mundial, Mistrzostwa Świata">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container text-center">
    <h1>World Cup 2018</h1>
    <h3><a href="loginForm.php" class="btn btn-primary links">Zaloguj się na swoje konto</a></h3>

    <h3><a href="registerForm.php" class="btn btn-primary links">Utwórz nowe konto</a></h3>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>