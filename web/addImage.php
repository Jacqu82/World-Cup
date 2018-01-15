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
    <form method="POST" action="#" enctype="multipart/form-data">
        <div class="file forms">
            <input type="file" name="imageFile"/>
            <input type="hidden" name="userId" value="<?php echo $user->getId(); ?>"/>
        </div>
        <br/>
        <input type="hidden" name="action" value="saveImage"/>
        <button type="submit">Dodaj zdjęcie</button>
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'saveImage') {
        if (($_FILES['imageFile']['error'] == 0)
            && ($_FILES['imageFile']['type'] == 'image/jpeg')
            && isset($_POST['userId'])) {
            $userId = $_POST['userId'];
            //$filename = $_FILES['imageFile']['name'] = $imageId . '_image';
            $filename = $_FILES['imageFile']['name'];
            $path = '../content/' . $userId . '/';
//            $chmod = '../content';
            if (!file_exists($path)) {
                mkdir($path);
//                chmod($chmod, 0777);
//                chmod($path, 0777);
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
                $image = new Image();
                $image
                    ->setImagePath($path)
                    ->setUserId($_POST['userId']);
                $upload = ImageRepository::saveToDB($connection, $image);
                echo "<div class=\"text-center alert alert-success\">";
                echo '<strong>Zdjęcie dodane pomyślnie :)</strong>';
                echo "</div>";
            } else {
                echo "<div class=\"text-center alert alert-danger\">";
                echo '<strong>Wystąpił błąd podczas dodawania zdjęcia!</strong>';
                echo "</div>";
                die();
            }
        }
    }

    ?>
    <h3><a href="userPanel.php" class="btn btn-default links">Powrót do profilu</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>