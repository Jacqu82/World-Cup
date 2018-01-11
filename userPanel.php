<?php

require_once 'src/lib.php';
require_once 'connection.php';

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

//if for every page for logged user!!!

$user = loggedUser($connection);

?>

<!DOCTYPE html>
<html lang="pl">
<?php

include 'widget/head.php';

?>
<body>
<?php
include 'widget/header.php';
?>
<div class="container text-center">
    <h1>World Cup 2018</h1>
    <h3>Id: <?php echo $user->getId(); ?></h3>
    <h3>Witaj <?php echo $user->getUsername(). "!"; ?></h3>
    <h3>Adres E-mail: <?php echo $user->getEmail(); ?></h3>
    <h3><a href="editUserProfile.php" class="btn btn-warning links">Edytuj profil</a></h3>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
