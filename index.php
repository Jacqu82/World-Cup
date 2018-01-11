<?php

session_start();

if (isset($_SESSION['login'])) {
    header('Location: mainPage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<?php

include 'widget/head.php';

?>
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