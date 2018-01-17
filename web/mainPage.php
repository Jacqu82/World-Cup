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
    <div class="row">
        <form action="#" method="POST">
            <h3>Napisz Post: </h3>

            <textarea name="text" rows="4" class="forms" placeholder="Napisz Post"
                      maxlength="150"></textarea><br/>
            <button class='btn btn-success links' type='submit'>Wyślij Post</button>
        </form>
    </div>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['text'])) {
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);

            if (strlen($text) > 150) {
                echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Post może mieć maksymalnie 150 znaków!</strong>
                </div>
                ';
            } else {
                $post = new Post();
                $post
                    ->setUserId($user->getId())
                    ->setText($text);
                if ($post) {
                    PostRepository::saveToDB($connection, $post);
                    ?>
                    <div class="flash-message alert alert-success alert-dismissible" role="alert">
                        <strong>Post pomyślnie dodany :)</strong>
                    </div>

                    <?php
                }
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['commentText'])) {
            $commentText = filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_STRING);
            $postId = $_POST['postId'];
            if (strlen($commentText) > 80) {
                echo '
                <div class="flash-message alert alert-success alert-dismissible" role="alert">
                    <strong>Komentarz może mieć maksymalnie 80 znaków!</strong>
                </div>
                ';
            } else {
                $comment = new Comment();
                $comment
                    ->setUserId($user->getId())
                    ->setPostId($postId)
                    ->setText($commentText);
                if ($comment) {
                    CommentRepository::saveToDB($connection, $comment);
                    ?>
                    <div class="flash-message alert alert-success alert-dismissible" role="alert">
                        <strong>Komentarz pomyślnie dodany :)</strong>
                    </div>
                    <?php
                }
            }
        }
    }

    $count = PostRepository::countAllPosts($connection);
    echo '<h3>Wszystkie posty ( ' . $count . ' )</h3>';
    $posts = PostRepository::loadAllPosts($connection);
    foreach ($posts as $post) {
        echo "W dniu " . $post['created_at'] . " użytkownik " . $post['username'] . " napisał: <br/>";
        echo $post['text'] . "<br/><br/>";

//        if ($user->getUsername() === 'admin') {
//            if (isset($_POST['editText'], $_POST['postSubmit'])) {
//                $editText = filter_input(INPUT_POST, 'editText', FILTER_SANITIZE_STRING);
//                if (strlen($editText) > 150) {
//                    echo '
//                <div class="flash-message alert alert-success alert-dismissible" role="alert">
//                    <strong>Post może mieć maksymalnie 150 znaków!</strong>
//                </div>';
//                } else {
//                    $post = new Post();
//                    $post
//                        ->setUserId($user->getId())
//                        ->setText($editText);
//                    if ($post) {
//                        PostRepository::updatePostText($connection, $post);
//                        echo '
//                        <div class="flash-message alert alert-success alert-dismissible" role="alert">
//                            <strong>Post pomyślnie edytowany :)</strong>
//                        </div>';
//                    }
//                }
//            }
//            ?>
<!--            <form action="#" method="post">-->
<!--                <div class="form-group">-->
<!--                    <textarea class="forms" name="editText"-->
<!--                              placeholder="Edytuj Post"></textarea>-->
<!--                    <br/>-->
<!--                    <button type="submit" name="postSubmit" class="btn btn-warning links">Edytuj Post</button>-->
<!--                </div>-->
<!--                <input type='hidden' name='image_id' value="--><?php //?><!-- ">-->
<!--                <button type="submit" class="btn btn-danger links">Usuń Post</button>-->
<!--                            <input type="submit" class="btn btn-danger links" name="delete_image" value="Usuń zdjęcie"/>-->
<!--            </form>-->
<!--            --><?php
//        }
        ?>

        <form action="#" method="POST">
            <div class="toggle-comment-form">
                <span class="toggle">Pokaż / ukryj</span>
                <textarea class="commentText forms" name="commentText"
                          placeholder="Dodaj swój komentarz" maxlength='80'></textarea><br/>
                <button class="btn btn-primary links" type='submit'>Dodaj komentarz</button>
                <input type="hidden" name="postId" value=" <?php echo $post['id']; ?> "/>
            </div>
        </form>

        <?php

        $countComments = CommentRepository::countAllCommentsByPostId($connection, $post['id']);
        echo '<h4>Komentarze do posta ( ' . $countComments . ' )</h4>';
        $comments = CommentRepository::loadAllCommentsByPostId($connection, $post['id']);
        foreach ($comments as $commentByPost) {
            echo "<p style='color: teal'>W dniu " . $commentByPost['created_at'] . " użytkownik " .
                $commentByPost['username'] . " skomentował tego posta: <br/>";
            echo $commentByPost['text'] . "<p/>";
        }
        echo "<hr/>";
    }


    ?>

</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>