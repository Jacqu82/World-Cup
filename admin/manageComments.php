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

    $countComments = CommentRepository::countAllCommentsExceptAdmin($connection, $user->getId());
    echo '<h3>Wszystkie komentarze ( ' . $countComments . ' )</h3>';

    $comments = CommentRepository::loadAllComments($connection, $user->getId());
    foreach ($comments as $comment) {
        echo 'Data utworzenia: ' . $comment['created_at'] . '<br/>';
        echo $comment['username'] . '<br/>';
        echo $comment['text'] . '<br/><br/>';

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
