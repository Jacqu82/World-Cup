<?php

session_start();

require __DIR__ . '/../autoload.php';

use Model\Image;
use Service\Container;

if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
//if for every page for logged user!!!

$container = new Container($configuration);
$user = $container->loggedUser();

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
            $kindId = $_POST['userId'];
            $kind = 'users';

            $addImage = $container->getImageService()->imageOperation($kind, $kindId);
            $upload = $addImage['upload'];
            $path = $addImage['path'];

//            $filename = $_FILES['imageFile']['name'] = $kindId . '_image';
//            $chmod = '../content';
//            chmod($chmod, 0777);
//            chmod($path, 0777);

            if ($upload) {
                $image = new Image();
                $image
                    ->setImagePath($path)
                    ->setUserId($_POST['userId']);
                $container->getImageRepository()->saveToDB($image);
                echo "<div class=\"flash-message alert alert-success alert-dismissible\" role=\"alert\">";
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