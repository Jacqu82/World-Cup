<?php

require_once 'src/lib.php';
require_once 'connection.php';

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

//if for every page for logged user!!!

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

</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>