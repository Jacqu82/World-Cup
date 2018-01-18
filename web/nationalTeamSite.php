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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['coach'])) {
            $nationalTeamId = $_GET['id'];
            $nationalTeamName = $_GET['name'];
            $nationalTeamCoach = $_GET['coach'];
        }
    }

    echo '<h1>' . $nationalTeamName . '</h1>';
    echo '<h3>Trener reprezentacji: ' . $nationalTeamCoach . '</h3>';

    $images = ImageRepository::loadImageDetailsByNationalTeamId($connection, $nationalTeamId);
    foreach ($images as $image) {

        ?>
        <div class='img-thumbnail1'>
            <img src="  <?php echo $image['image_path']; ?> " width='500' height='300'/><br/>
        </div>

        <?php
    }
    echo '<hr/>';


    ?>

    <hr/>
    <h3><a href="nationalTeamsList.php" class="btn btn-default links">Powrót do listy</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>