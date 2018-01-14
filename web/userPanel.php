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

    $images = ImageRepository::loadImageDetailsByUserId($connection, $user->getId());
    foreach ($images as $image) {

        ?>
        <div class='img-thumbnail1'>
            <img src="  <?php echo $image['image_path']; ?> " width='450' height='350'/>
        </div>
        <div>
<!--            <span>--><?php //echo $image['id']  ?><!--</span><br/>-->
            <span>Data dodania: <?php echo $image['created_at']  ?></span>
        </div>

        <?php
    }

    ?>

    <h3><a href="addImage.php" class="btn btn-success links">Dodaj zdjęcia</a></h3>
    <h3><a href="editUserProfile.php" class="btn btn-warning links">Edytuj profil</a></h3>
    <h3><a href="editImages.php" class="btn btn-warning links">Edytuj zdjęcia</a></h3>

</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>
