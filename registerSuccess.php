<?php

session_start();

if (!isset($_SESSION['register_success'])) {
    header('Location: index.php');
    exit();
} else {
    unset($_SESSION['register_success']);
}

//delete register errors

if (isset($_SESSION['e_username'])) {
    unset($_SESSION['e_username']);
}

if (isset($_SESSION['e_email'])) {
    unset($_SESSION['e_email']);
}

if (isset($_SESSION['e_password'])) {
    unset($_SESSION['e_password']);
}

if (isset($_SESSION['e_bot'])) {
    unset($_SESSION['e_bot']);
}

?>
<!DOCTYPE html>
<html lang="pl">
<?php

include 'widget/head.php';

?>
<body>
<div class="container text-center">
    <h2>Gratulacje! Poprawnie założyłeś konto na World Cup 2018!</h2>
    <h3><a href="loginForm.php" class="btn btn-info links">Zaloguj się na swoje konto</a></h3>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>