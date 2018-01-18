<?php
require_once '../src/lib.php';
require_once '../connection.php';
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
            header('Location: editNationalTeamImages.php');
        }

        if (($_FILES['imageFile']['error'] == 0) && ($_FILES['imageFile']['type'] == 'image/jpeg')
            && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $nationalTeamId = $_POST['national_team_id'];

            $pathToDelete = ImageRepository::loadImagePath($connection, $imageId);
            unlink($pathToDelete);

            $filename = $_FILES['imageFile']['name'];
            $path = '../content/images/teams/' . $nationalTeamId . '/';
            if (!file_exists($path)) {
                mkdir($path);
            }
            $path .= $filename;
            if (!file_exists($path)) {
                $upload = move_uploaded_file($_FILES['imageFile']['tmp_name'], $path);
            } else {
                echo "<div class=\"text-center alert alert-danger\">";
                echo '<strong>Zdjęcie o podanej nazwie już istnieje!</strong>';
                echo "</div>";
                die();
            }

            if ($upload) {
                ImageRepository::updateImagePath($connection, $path, $imageId);
                header('Location: editNationalTeamImages.php');
            } else {
                echo "<div class=\"text-center alert alert-danger\">";
                echo '<strong>Wystąpił błąd podczas edycji zdjęcia!</strong>';
                echo "</div>";
                die();
            }
        }
    }

    $images = ImageRepository::loadNationalTeamImageDetails($connection);
    foreach ($images as $image) {

        ?>
        <div class='img-thumbnail1'>
            <img src="<?php echo $image['image_path'] ?> " width='450' height='300'/><br/>
            <span><?php echo $image['image_path'] ?></span>
            <form method="POST" action="#" enctype="multipart/form-data">
                <div class="file forms">
                    <input type="file" name="imageFile"/>
                    <input type="hidden" name="national_team_id" value="<?php echo $image['national_team_id']; ?>"/>
                    <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>"/>
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