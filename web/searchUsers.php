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

    <form method="post" action="#">
        <input type="text" name="search" class="forms" placeholder="Szukaj znajomych"><br/>
        <button type="submit" class="btn btn-success button">Szukaj</button>
    </form>
    <hr/>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['search'])) {
            $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);

            $users = UserRepository::loadAllSearchedUsers($connection, $search);

            if ($users->rowCount() > 0) {
                echo "<div class=\"flash-message alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Liczba znalezionych użytkowników: ' . $users->rowCount() . '</strong>';
                echo "</div>";

                foreach ($users as $user) {
                    $id = $user['id'];
                    $username = $user['username'];

                    echo "<h6><a href='userProfile.php?id=$id'
                                class='btn btn-info links'>$username</a></h6>";
                }
            } else {
                echo "<div class=\"flash-message alert alert-danger alert-dismissible\" role=\"alert\">";
                echo '<strong>Brak wyników wyszukiwania</strong>';
                echo "</div>";
            }
        }
    }

    ?>

    <hr/>
    <h3><a href="mainPage.php" class="btn btn-default links">Powrót do Strony głównej</a></h3>

</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>