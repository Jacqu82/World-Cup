<?php

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>World Cup 2018 - Strona główna</title>
    <meta name="description" content="World Cup 2018 App">
    <meta name="keywords" content="World Cup, Mundial, Mistrzostwa Świata">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container text-center">
    <h1>World Cup 2018</h1>
    <h3>Witaj <?php echo $_SESSION['username']; ?></h3>
    <h3>Adres E-mail: <?php echo $_SESSION['email']; ?></h3>
    <a href="logout.php" class="btn btn-info links">Wyloguj się</a>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>