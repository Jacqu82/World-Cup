<?php

session_start();

require __DIR__ . '/../autoload.php';

use Service\Container;

if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

//if for every page for logged user!!!

$container = new Container($configuration);
$postRepository = $container->getPostRepository();
$imageRepository = $container->getImageRepository();

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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $users = $container->getUserRepository()->loadUserById($id);
            echo '<h1>' . $users->getUsername() . '</h1>';
            echo '<h3>Adres E-mail: ' . $users->getEmail() . '</h3>';
            echo '<h3>Data utworzenia profilu: ' . $users->getCreatedAt() . '</h3>';
            ?>

            <img src="  <?php
            $firstImage = $imageRepository->loadFirstImageDetailsByUserId($id);
            echo $firstImage['image_path']; ?> " width='150' height='100'/><br/>
            <?php

            $count = $imageRepository->countAllImagesByUserId($id);
            echo '<h3>Liczba zdjęć użytkownika ' . $users->getUsername() . ' ( ' . $count . ' )</h3>';

            $images = $imageRepository->loadImageDetailsByUserId($id);
            foreach ($images as $image) {

                ?>
                <div class='img-thumbnail1'>
                    <img src="  <?php echo $image['image_path']; ?> " width='450' height='300'/><br/>
                    <span>Data dodania: <?php echo $image['created_at'] ?></span>
                </div>

                <?php

            }

            $count = $postRepository->countAllPostsByUserId($id);
            echo '<h3>Wszystkie posty użytkownika ' . $users->getUsername() . ' ( ' . $count . ' )</h3>';
            $myPosts = $postRepository->loadAllPostsByUserId($id);
            foreach ($myPosts as $post) {
                echo $post['created_at'] . "<br/>";
                echo $post['text'] . "<br/><br/>";

            }
        }
    }

    ?>


    <hr/>
    <h3><a href="searchUsers.php" class="btn btn-default links">Powrót do Strony wyszukiwania</a></h3>

</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>