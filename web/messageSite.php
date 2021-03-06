<?php

session_start();

require __DIR__ . '/../autoload.php';

use Model\Message;
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
<div>
    <form action="#" method="POST">
        <h3>Napisz wiadomość: </h3>
        <?php
        $users = $container->getUserRepository()->loadUsersExceptMe($user->getId());
        echo "Wybierz użytkownika: <br/>";
        echo '<div>';
        echo "<select name='receiverId' class='forms'>";
        foreach ($users as $value) {
            echo "<option value='" . $value['id'] . "'>" . $value['username'] . "</option>";
        }
        echo "</select>";
        echo "</div>";
        ?>
        <textarea name="text" rows="4" class="forms" placeholder="Napisz wiadomość"
                  maxlength="140"></textarea><br/>
        <button class='btn btn-success links' type='submit'>Wyślij wiadomość</button>
    </form>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['receiverId']) && isset($_POST['text'])) {
        $receiverId = (int)$_POST['receiverId'];
        $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);

        $message = new Message();
        $message
            ->setSenderId($user->getId())
            ->setReceiverId($receiverId)
            ->setText($text)
            ->setIsRead(0);
        if ($message) {
            $messageRepository->saveToDB($message);
            $receiverName = $container->getUserRepository()->loadUserById($receiverId);
            ?>
            <div class="flash-message alert alert-success alert-dismissible" role="alert">
                <strong>Wysłałeś wiadomość do <?php echo $receiverName->getUsername(); ?></strong>
            </div>
            <?php
        }
    }
}

$unread = $messageRepository->countAllUnreadMessages($user->getId());
?>
<hr/>
<a href="inbox.php" class="btn btn-primary links">Skrzynka odbiorcza
    <span class="badge"><?php echo $unread; ?></span></a>
<a href="outbox.php" class="btn btn-info links">Skrzynka nadawcza</a>
<div>
    <a href="mainPage.php" class="btn btn-default links">Powrót</a>
</div>

</div>

<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>