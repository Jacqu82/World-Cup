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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'updateImage') {
        if (isset($_POST['delete_image']) && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $path = ImageRepository::loadImagePath($connection, $imageId);
            unlink($path);
            $toDelete = ImageRepository::loadImageById($connection, $imageId);
            ImageRepository::delete($connection, $toDelete);
            echo "<div class=\"flash-message alert alert-success alert-dismissible\" role=\"alert\">";
            echo '<strong>Zdjęcie poprawnie usunięte :)</strong>';
            echo "</div>";
        }

        if (($_FILES['imageFile']['error'] == 0) && ($_FILES['imageFile']['type'] == 'image/jpeg')
            && isset($_POST['user_id']) && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $kindId = $_POST['user_id'];
            $kind = 'users';

            $pathToDelete = ImageRepository::loadImagePath($connection, $imageId);
            unlink($pathToDelete);

            $editImage = ImageOperations::imageOperation($kind, $kindId);
            $upload = $editImage['upload'];
            $path = $editImage['path'];
            if ($upload) {
                ImageRepository::updateImagePath($connection, $path, $imageId);
                echo "<div class=\"flash-message alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Zdjęcie poprawnie edytowane :)</strong>';
                echo "</div>";
            } else {
                echo "<div class=\"text-center alert alert-danger\">";
                echo '<strong>Wystąpił błąd podczas edycji zdjęcia!</strong>';
                echo "</div>";
                die();
            }
        }
    }

    $images = ImageRepository::loadImageDetailsByUserId($connection, $user->getId());
    if (count($images) != 0) {
        foreach ($images as $image) {

            ?>
            <div class='img-thumbnail1'>
                <img src="<?php echo $image['image_path'] ?> " width='450' height='300'/>
                <form method="POST" action="#" enctype="multipart/form-data">
                    <div class="file forms">
                        <input type="file" name="imageFile"/>
                        <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>"/>
                        <input type="hidden" name="image_id" value="<?php echo $image['id'];; ?>"/>
                    </div>
                    <br/>
                    <input type="hidden" name="action" value="updateImage"/>
                    <button type="submit" class="btn btn-warning links">Edytuj zdjęcie</button>
                    <div>
                        <input type="submit" class="btn btn-danger links" name="delete_image" value="Usuń zdjęcie"/>
                        <input type='hidden' name='image_id' value="<?php echo $image['id']; ?> ">
                    </div>
                </form>
            </div>
            <?php
        }
    } else {
        echo '<h3>Brak zdjęć do edycji!</h3>';
    }
    ?>
    <hr/>
    <h3><a href="userPanel.php" class="btn btn-default links">Powrót do profilu</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>