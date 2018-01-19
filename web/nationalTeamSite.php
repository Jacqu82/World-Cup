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
        if (isset($_GET['id'])) {
            $nationalTeamId = $_GET['id'];
        }
    }

    $nationalTeamDetails = NationalTeamRepository::loadNationalTeamsById($connection, $nationalTeamId);
    foreach ($nationalTeamDetails as $nationalTeamDetail) {
        echo '<h1>' . $nationalTeamDetail['name'] . '</h1>';
        echo '<h3>Trener reprezentacji: ' . $nationalTeamDetail['coach'] . '</h3>';
    }

    $images = ImageRepository::loadImageDetailsByNationalTeamId($connection, $nationalTeamId);
    foreach ($images as $image) {

        ?>
        <div class='img-thumbnail1'>
            <img src="  <?php echo $image['image_path']; ?> " width='500' height='300'/><br/>
        </div>

        <?php
    }
    echo '<hr/>';

    $groups = GroupRepository::loadAllGroupsById($connection, $_SESSION['group_id']);
    foreach ($groups as $group) {
        $id = $group['id'];

    }

    echo '<hr/>';
    echo "<h3><a href='groupList.php?id=$id' class='btn btn-default links'>Powrót do grupy</a></h3>";
    ?>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>