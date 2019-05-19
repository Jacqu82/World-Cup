<?php

session_start();

require __DIR__ . '/../autoload.php';

use Model\Image;
use Service\Container;

if (!isset($_SESSION['login'])) {
    header('Location: ../web/index.php');
    exit();
}

$container = new Container($configuration);
$user = $container->loggedUser();

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
    <h3>Dodaj flage reprezentacji</h3>

    <form method="POST" action="#" enctype="multipart/form-data">
        <div class="file forms">
            <input type="file" name="imageFile"/>
        </div>
        <br/>
        Wybierz reprezentacje:<br/>
        <select name="nationalTeams" class="forms">
            <?php
            $nationalTeams = $container->getNationalTeamRepository()->loadAllNationalTeams();
            foreach ($nationalTeams as $nationalTeam) {
                echo "<option value='" . $nationalTeam['id'] . "' class='forms'>" . $nationalTeam['name'] . "</option>";
            }
            ?>
        </select>
        <br/>
        <input type="hidden" name="action" value="saveImage"/>
        <button type="submit">Dodaj flage reprezentacji</button>
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'saveImage') {
        if (($_FILES['imageFile']['error'] == 0)
            && ($_FILES['imageFile']['type'] == 'image/jpeg')
            && isset($_POST['nationalTeams'])) {
            $kindId = $_POST['nationalTeams'];
            $kind = 'flags';

            $addImage = $container->getImageService()->imageOperation($kind, $kindId);
            $upload = $addImage['upload'];
            $path = $addImage['path'];
            if ($upload) {
                $image = new Image();
                $image
                    ->setImagePath($path)
                    ->setFlagId($_POST['nationalTeams']);
                $container->getImageRepository()->saveToDB($image);
                echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Flaga dodane pomyślnie :)</strong>';
                echo "</div>";
            } else {
                echo "<div class=\"flash-message text-center alert alert-danger alert-dismissible\" role=\"alert\">";
                echo '<strong>Wystąpił błąd podczas dodawania flagi!</strong>';
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