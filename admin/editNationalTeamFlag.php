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

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'updateImage') {
        if (isset($_POST['delete_image']) && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $path = ImageRepository::loadImagePath($connection, $imageId);
            unlink($path);
            $toDelete = ImageRepository::loadImageById($connection, $imageId);
            ImageRepository::delete($connection, $toDelete);
            echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
            echo '<strong>Flaga poprawnie usunięta :)</strong>';
            echo "</div>";
        }

        if (($_FILES['imageFile']['error'] == 0) && ($_FILES['imageFile']['type'] == 'image/jpeg')
            && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $kindId = $_POST['national_team_id'];
            $kind = 'flags';

            $pathToDelete = ImageRepository::loadImagePath($connection, $imageId);
            unlink($pathToDelete);

            $editImage = ImageOperations::imageOperation($kind, $kindId);
            $upload = $editImage['upload'];
            $path = $editImage['path'];
            if ($upload) {
                ImageRepository::updateImagePath($connection, $path, $imageId);
                echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Flaga poprawnie edytowana :)</strong>';
                echo "</div>";
            } else {
                echo "<div class=\"flash-message text-center alert alert-danger alert-dismissible\" role=\"alert\">";
                echo '<strong>Wystąpił błąd podczas edycji flagi!</strong>';
                echo "</div>";
                die();
            }
        }
    }

    $images = ImageRepository::loadNationalTeamFlag($connection);
    foreach ($images as $image) {

        ?>
        <div class='img-thumbnail1'>
            <img src="<?php echo $image['image_path'] ?> " width='150' height='100'/><br/>
            <span><?php echo $image['image_path'] ?></span>
            <form method="POST" action="#" enctype="multipart/form-data">
                <div class="file forms">
                    <input type="file" name="imageFile"/>
                    <input type="hidden" name="national_team_id" value="<?php echo $image['flag_id']; ?>"/>
                    <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>"/>
                </div>
                <br/>
                <input type="hidden" name="action" value="updateImage"/>
                <button type="submit" class="btn btn-warning links">Edytuj</button>
                <div>
                    <input type="submit" class="btn btn-danger links" name="delete_image" value="Usuń"/>
                    <input type='hidden' name='image_id' value="<?php echo $image['id']; ?> ">
                </div>
            </form>
        </div>
        <?php
    }
    ?>
    <hr/>
    <h3><a href="adminPanel.php" class="btn btn-default links">Powrót do panelu Admina</a></h3>
</div>
<?php

include '../widget/footer.php';
include '../widget/scripts.php';

?>
</body>
</html>