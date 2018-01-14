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
    <h3>Skrzynka nadawcza</h3>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_messege']) && isset($_POST['message_id'])) {
            $messageId = $_POST['message_id'];
            $message = MessageRepository::loadMessageById($connection, $messageId);
            MessageRepository::delete($connection, $message);
        }
    }

    $sent = MessageRepository::loadAllSentMessagesByUserId($connection, $user->getId());
    foreach ($sent as $row) {
        echo 'Do: ' . $row['username'] . "<br/>";
        echo $row['text'] . "<br/>";
        echo $row['created_at'] . "<br/>";
        echo "<form method='POST'>
                <input type=\"submit\" class=\"btn btn-danger links\" name=\"delete_messege\" value=\"Usuń wiadomość\"/>
                <input type='hidden' name='message_id' value='" . $row['id'] . " '>
              </form>";
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