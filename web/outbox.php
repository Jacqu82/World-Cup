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
$user = $container->loggedUser();
$messageRepository = $container->getMessageRepository();

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
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_message']) && isset($_POST['message_id'])) {
            $messageId = $_POST['message_id'];
            $message = $messageRepository->loadMessageById($messageId);
            $messageRepository->delete($message);
        }
    }

    $countSent = $messageRepository->countAllSentMessages($user->getId());
    echo '<h3>Skrzynka nadawcza ( ' . $countSent . ' ) </h3>';

    $sent = $messageRepository->loadAllSentMessagesByUserId($user->getId());

    foreach ($sent as $row) {
        echo 'Do: ' . $row['username'] . "<br/>";
        echo $row['text'] . "<br/>";
        echo $row['created_at'] . "<br/>";
        echo "<form method='POST'>
                <input type=\"submit\" class=\"btn btn-danger links\" name=\"delete_message\" value=\"Usuń wiadomość\"/>
                <input type='hidden' name='message_id' value='" . $row['id'] . " '>
              </form>";
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