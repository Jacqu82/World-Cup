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
//    $id = ImageRepository::loadImageIdByUserId($connection, $user->getId());
//    var_dump($id);


    foreach ($images as $image) {

    ?>

        <div class='img-thumbnail1'>
            <img src="<?php echo $image['image_path'] ?> " width='450' height='350'/>
            <form method="post" action="#" enctype="multipart/form-data">
                <div class="file forms">
                    <input type="file" name="imageFile"/>
                    <input type="hidden" name="userId" value="<?php echo $user->getId(); ?>"/>
                </div>
                <br/>
                <input type="hidden" name="action" value="saveImage"/>
                <button type="submit" class="btn btn-warning links">Edytuj zdjęcie</button>
            </form>
            <div>
                <div class="form-group">
                    <button type="submit" name="deleteImage" class="btn btn-danger links">Usuń zdjęcie</button>
                </div>
            </div>
        </div>
    <?php

//        if (isset($_POST['deleteImage'])) {
//            if (ImageRepository::delete($connection)) {
//
//            }
//        }

//        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'saveImage') {
//            if (($_FILES['imageFile']['error'] == 0)
//                && ($_FILES['imageFile']['type'] == 'image/jpeg')
//                && isset($_POST['userId'])) {
//                $userId = $_POST['userId'];
//                $filename = $_FILES['imageFile']['name'];
//                $path = 'images/' . $userId . '/';
//                if (!file_exists($path)) {
//                    mkdir($path, 0777, true);
//                }
//                $path .= $filename;
//                if(!file_exists($path)) {
//                    $upload = move_uploaded_file($_FILES['imageFile']['tmp_name'], $path);
//                } else {
//                    echo "<div class=\"text-center alert alert-danger\">";
//                    echo '<strong>Zdjęcie o podanej nazwie już istnieje!</strong>';
//                    echo "</div>";
//                    die();
//                }
//                if ($upload) {
//                    //$image = new Image();
//                    $image->setImagePath($path);
//                    if (ImageRepository::updateImage($connection, $userId)) {
//                        echo "<div class=\"text-center alert alert-success\">";
//                        echo '<strong>Zdjęcie zmienione pomyślnie :)</strong>';
//                        echo "</div>";
//                    }
////                    $image = new Image();
////                    $image
////                        ->setImagePath($path)
////                        ->setUserId($_POST['userId']);
////                    $upload = ImageRepository::saveToDB($connection, $image);
//
//                } else {
//                    echo "<div class=\"text-center alert alert-danger\">";
//                    echo '<strong>Wystąpił błąd podczas dodawania zdjęcia!</strong>';
//                    echo "</div>";
//                    die();
//                }
//            }
//        }

    }

    ?>

</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>
