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
    <h3>Witaj <?php echo $user->getUsername() . "!"; ?></h3>
    <h3>Twój adres E-mail: <?php echo $user->getEmail(); ?></h3>
    <h3>Data utworzenia profilu: <?php echo $user->getCreatedAt(); ?></h3>

    <?php

    $count = ImageRepository::countAllImagesByUserId($connection, $user->getId());
    echo '<h3>Liczba Twoich zdjęć ( ' . $count . ' )</h3>';

    $images = ImageRepository::loadImageDetailsByUserId($connection, $user->getId());
    foreach ($images as $image) {

        ?>
        <div class='img-thumbnail1'>
            <img src="  <?php echo $image['image_path']; ?> " width='450' height='300'/><br/>
            <span>Data dodania: <?php echo $image['created_at'] ?></span>
        </div>

        <?php
    }
    echo '<hr/>';

    $count = PostRepository::countAllPostsByUserId($connection, $user->getId());
    echo '<h3>Wszystkie Twoje posty ( ' . $count . ' )</h3>';
    $myPosts = PostRepository::loadAllPostsByUserId($connection, $user->getId());
    foreach ($myPosts as $post) {
        echo $post['created_at'] . "<br/>";
        echo $post['text'] . "<br/><br/>";
    }

    echo '<hr/>';

    ?>

    <h3><a href="addImage.php" class="btn btn-success links">Dodaj zdjęcia</a></h3>
    <h3><a href="editUserProfile.php" class="btn btn-warning links">Edytuj profil</a></h3>
    <h3><a href="editImages.php" class="btn btn-primary links">Edytuj zdjęcia</a></h3>
    <hr/>
    <h3><a href="mainPage.php" class="btn btn-default links">Powrót do Strony głównej</a></h3>

</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>