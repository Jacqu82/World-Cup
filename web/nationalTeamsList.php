<?php
require_once '../src/lib.php';
require_once '../connection.php';
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
include '../widget/head.php';
?>
<body>
<?php
include '../widget/header.php';
?>
<div class="container text-center">
    <h1>World Cup 2018</h1>
    <hr/>
    <?php

    $nationalTeams = NationalTeamRepository::loadAllNationalTeams($connection);
    foreach ($nationalTeams as $nationalTeam) {
        $id = $nationalTeam['id'];
        $name = $nationalTeam['name'];
        $coach = $nationalTeam['coach'];
        echo "<a href='nationalTeamSite.php?id=$id&name=$name&coach=$coach'
                class='btn btn-primary links'>$name</a> ";
    }

    ?>

    <hr/>
    <h3><a href="mainPage.php" class="btn btn-default links">Powrót</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>