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
    <h3>Skrzynka odbiorcza</h3>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['set_message_as_read']) && isset($_POST['message_id'])) {
            $id = $_POST['message_id'];
            MessageRepository::setMessageStatus($connection, $id, 1);
        } else if (isset($_POST['set_message_as_unread']) && isset($_POST['message_id'])) {
            $id = $_POST['message_id'];
            MessageRepository::setMessageStatus($connection, $id, 0);
        }
    }

    $unread = MessageRepository::countAllUnreadMessages($connection, $user->getId());
    echo 'Nieprzyczatane wiadomości: ( ' . $unread . ' )<br/>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_messege']) && isset($_POST['message_id'])) {
            $messageId = $_POST['message_id'];
            $message = MessageRepository::loadMessageById($connection, $messageId);
            MessageRepository::delete($connection, $message);
        }
    }


    $received = MessageRepository::loadAllReceivedMessagesByUserId($connection, $user->getId());
    foreach ($received as $row) {
        echo "Od " . $row['username'] . "<br/>";
        if ($row['is_read'] == 0) {
            echo "<form method='POST'>";
            echo "<b>" . $row['text'] . "<br/>" . $row['created_at'] . "</b><br/>
                        <input type='submit'  name='set_message_as_read' value='Oznacz jako przeczytaną' class='btn btn-success links' />
                        <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                        <input type=\"submit\" class=\"btn btn-danger links\" name=\"delete_messege\" value=\"Usuń wiadomość\"/>
                        <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                    </form>";
        } else if ($row['is_read'] == 1) {
            echo "<form method='POST'>";
            echo $row['text'] . "<br/>" . $row['created_at'] . "<br/>
                        <input type='submit'  name='set_message_as_unread' value='Oznacz jako nie przeczytaną' class='btn btn-success links' />
                        <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                        <input type=\"submit\" class=\"btn btn-danger links\" name=\"delete_messege\" value=\"Usuń wiadomość\"/>
                        <input type='hidden' name='message_id' value='" . $row['id'] . " '>
                    </form>";
        }
        echo "<hr/>";
    }

    ?>
    <a href="messageSite.php" class="btn btn-default links">Powrót</a>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>