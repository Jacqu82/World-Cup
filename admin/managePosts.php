<?php

require_once '../src/lib.php';
require_once '../connection.php';

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../web/index.php');
    exit();
}

//if for every page for logged user!!!

$user = loggedUser($connection);

if ($user->getRole() != 'admin') {
    header('Location: ../web/mainPage.php');
}

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

    $count = PostRepository::countAllPostsExceptAdmin($connection, $user->getId());
    echo '<h3>Wszystkie posty ( ' . $count . ' )</h3>';

    $posts = PostRepository::loadAllPostsExceptAdmin($connection, $user->getId());
    foreach ($posts as $post) {
        echo 'Data utworzenia: ' . $post['created_at'] . '<br/>';
        echo $post['username'] . '<br/>';
        echo $post['text'] . '<br/><br/>';

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
        <hr/>
        <?php
    }
    ?>
    <h3><a href="adminPanel.php" class="btn btn-default links">Powrót do panelu Admina</a></h3>
</div>

<?php

include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>
