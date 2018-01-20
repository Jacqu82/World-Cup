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
    <img src="  <?php
    $firstImage = ImageRepository::loadFirstImageDetailsByUserId($connection, $user->getId());
    echo $firstImage['image_path']; ?> " width='150' height='100'/><br/>
    <?php if ($user->getRole() === 'admin') {
        echo '<h3><a href="../admin/adminPanel.php" class="btn btn-success links">Panel Administracyjny</a></h3>';
    } ?>
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['editText']) && isset ($_POST['post_id']) && isset($_POST['update_post'])) {
            $editText = filter_input(INPUT_POST, 'editText', FILTER_SANITIZE_STRING);
            $postId = $_POST['post_id'];
            if (strlen($editText) > 150) {
                echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Post może mieć maksymalnie 150 znaków!</strong>
                </div>';
            } else {
                PostRepository::updatePostText($connection, $postId, $editText);
                echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Post pomyślnie edytowany :)</strong>
                </div>';
            }
        }

        if (isset($_POST['post_id']) && isset($_POST['delete_post'])) {
            $postId = $_POST['post_id'];
            $postToDelete = PostRepository::loadPostById($connection, $postId);
            PostRepository::delete($connection, $postToDelete);
            echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Post pomyślnie usynięty :)</strong>
                </div>';
        }
    }

    $count = PostRepository::countAllPostsByUserId($connection, $user->getId());
    echo '<h3>Wszystkie Twoje posty ( ' . $count . ' )</h3>';
    $myPosts = PostRepository::loadAllPostsByUserId($connection, $user->getId());
    foreach ($myPosts as $post) {
        echo $post['created_at'] . "<br/>";
        echo $post['text'] . "<br/><br/>";

        ?>

        <form action="#" method="post">
            <div class="toggle-comment-form">
                <span class="toggle" style="color: gold">Edytuj</span>
                <textarea class="commentText forms" name="editText" placeholder="Edytuj Post"></textarea>
                <br/>
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>"/>
                <input type="hidden" name="update_post"/>
                <button type="submit" class="btn btn-warning links">Edytuj Post</button>
            </div>
        </form>
        <form action="#" method="post">
            <input type="submit" class="btn btn-danger links" name="delete_post" value="Usuń Post"/>
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>"/>
        </form>

        <?php
    }

    echo '<hr/>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['editComment']) && isset ($_POST['comment_id']) && isset($_POST['update_comment'])) {
            $editComment = filter_input(INPUT_POST, 'editComment', FILTER_SANITIZE_STRING);
            $commentId = $_POST['comment_id'];
            if (strlen($editComment) > 150) {
                echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Komentarz może mieć maksymalnie 80 znaków!</strong>
                </div>';
            } else {
                CommentRepository::updateCommentText($connection, $commentId, $editComment);
                echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Komentarz pomyślnie edytowany :)</strong>
                </div>';
            }
        }

        if (isset($_POST['comment_id']) && isset($_POST['delete_comment'])) {
            $commentId = $_POST['comment_id'];
            $commentToDelete = CommentRepository::loadCommentById($connection, $commentId);
            CommentRepository::delete($connection, $commentToDelete);
            echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Komentarz pomyślnie usynięty :)</strong>
                </div>';
        }
    }

    $countComments = CommentRepository::countAllCommentsByUserId($connection, $user->getId());
    echo '<h3>Wszystkie Twoje komentarze ( ' . $countComments . ' )</h3>';
    $myComments = CommentRepository::loadAllCommentsByUserId($connection, $user->getId());
    foreach ($myComments as $comment) {
        echo $comment['created_at'] . "<br/>";
        echo $comment['text'] . "<br/><br/>";

        ?>

        <form action="#" method="post">
            <div class="toggle-comment-form">
                <span class="toggle" style="color: gold">Edytuj</span>
                <textarea class="commentText forms" name="editComment" placeholder="Edytuj Komentarz"></textarea>
                <br/>
                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>"/>
                <input type="hidden" name="update_comment"/>
                <button type="submit" class="btn btn-warning links">Edytuj Komentarz</button>
            </div>
        </form>
        <form action="#" method="post">
            <input type="submit" class="btn btn-danger links" name="delete_comment" value="Usuń Komentarz"/>
            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>"/>
        </form>

        <?php

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