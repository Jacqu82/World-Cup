<?php

require_once '../src/lib.php';
require_once '../connection.php';

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../web/index.php');
    exit();
}

//if for every page for logged user!!!

$user = loggedUser($connection);

if ($user->getRole() != 'admin') {
    header('Location: ../web/mainPage.php');
}

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
    <h3>Dodaj zdjęcie reprezentacji</h3>

    <form method="POST" action="#" enctype="multipart/form-data">
        <div class="file forms">
            <input type="file" name="imageFile"/>
        </div>
        <br/>
        Wybierz reprezentacje:<br/>
        <select name="nationalTeams" class="forms">
            <?php
            $nationalTeams = NationalTeamRepository::loadAllNationalTeams($connection);
            foreach ($nationalTeams as $nationalTeam) {
                echo "<option value='" . $nationalTeam['id'] . "' class='forms'>" . $nationalTeam['name'] . "</option>";
            }
            ?>
        </select>
        <br/>
        <input type="hidden" name="action" value="saveImage"/>
        <button type="submit">Dodaj zdjęcie reprezentacji</button>
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'saveImage') {
        if (($_FILES['imageFile']['error'] == 0)
            && ($_FILES['imageFile']['type'] == 'image/jpeg')
            && isset($_POST['nationalTeams'])) {
            $kindId = $_POST['nationalTeams'];
            $kind = 'teams';

            $addImage = ImageOperations::imageOperation($kind, $kindId);
            $upload = $addImage['upload'];
            $path = $addImage['path'];
            if ($upload) {
                $image = new Image();
                $image
                    ->setImagePath($path)
                    ->setNationalTeamId($_POST['nationalTeams']);
                ImageRepository::saveToDB($connection, $image);
                echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Zdjęcie dodane pomyślnie :)</strong>';
                echo "</div>";
            } else {
                echo "<div class=\"flash-message text-center alert alert-danger alert-dismissible\" role=\"alert\">";
                echo '<strong>Wystąpił błąd podczas dodawania zdjęcia!</strong>';
                echo "</div>";
                die();
            }
        }
    }

    ?>
    <h3><a href="adminPanel.php" class="btn btn-default links">Powrót do panelu Admina</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>