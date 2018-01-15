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

    $images = ImageRepository::loadImageDetailsByUserId($connection, $user->getId());
    foreach ($images as $photo) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'saveImage') {
        if (isset($_POST['delete_image']) && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $path = ImageRepository::loadImagePath($connection, $user->getId());
            unlink($path);
            $toDelete = ImageRepository::loadImageById($connection, $imageId);
            ImageRepository::delete($connection, $toDelete);
            header('Location: editImages.php');
        }

        if (($_FILES['imageFile']['error'] == 0) && ($_FILES['imageFile']['type'] == 'image/jpeg')
            && isset($_POST['userId']) && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $userId = $_POST['userId'];

            $pathToDelete = ImageRepository::loadImagePath($connection, $user->getId());
            unlink($pathToDelete);
            $toDelete = ImageRepository::loadImageById($connection, $imageId);
            ImageRepository::delete($connection, $toDelete);

            $filename = $_FILES['imageFile']['name'];
            $path = '../content/' . $userId . '/';
            if (!file_exists($path)) {
                mkdir($path);
            }
            $path .= $filename;
            if(!file_exists($path)) {
                $upload = move_uploaded_file($_FILES['imageFile']['tmp_name'], $path);
            } else {
                echo "<div class=\"text-center alert alert-danger\">";
                echo '<strong>Zdjęcie o podanej nazwie już istnieje!</strong>';
                echo "</div>";
                die();
            }
            if ($upload) {
                $image = new Image();
                $image
                    ->setImagePath($path)
                    ->setUserId($_POST['userId']);
                $upload = ImageRepository::saveToDB($connection, $image);
                header('Location: editImages.php');
            } else {
                echo "<div class=\"text-center alert alert-danger\">";
                echo '<strong>Wystąpił błąd podczas edycji zdjęcia!</strong>';
                echo "</div>";
                die();
            }
        }
    }

    ?>

        <div class='img-thumbnail1'>
            <img src="<?php echo $photo['image_path'] ?> " width='450' height='300'/>
            <form method="POST" action="#" enctype="multipart/form-data">
                <div class="file forms">
                    <input type="file" name="imageFile"/>
                    <input type="hidden" name="userId" value="<?php echo $user->getId(); ?>"/>
                    <input type="hidden" name="image_id" value="<?php echo $photo['id'];; ?>"/>
                </div>
                <br/>
                <input type="hidden" name="action" value="saveImage"/>
                <button type="submit" class="btn btn-warning links">Edytuj zdjęcie</button>
                <div>
                    <input type="submit" class="btn btn-danger links" name="delete_image" value="Usuń zdjęcie"/>
                    <input type='hidden' name='image_id' value="<?php echo $photo['id']; ?> ">
                </div>
            </form>
        </div>
    <?php

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