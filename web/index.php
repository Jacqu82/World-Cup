<?php

session_start();

require __DIR__ . '/../autoload.php';

use Service\Container;

if (isset($_SESSION['login'])) {
    header('Location: mainPage.php');
    exit();
}

$container = new Container($configuration); //to delete

?>
<!DOCTYPE html>
<html lang="pl">
<?php

include '../widget/head.php';

?>
<body>
<div class="container text-center">
    <h1>World Cup 2018</h1>
    <hr/>
    <?php
    if (isset($_SESSION['delete_account'])) {
        echo "<div class=\"flash-message alert alert-success alert-dismissible\" role=\"alert\">";
        echo '<strong>' . $_SESSION['delete_account'] . '</strong>';
        echo "</div>";
        unset($_SESSION['delete_account']);
    }
    ?>

    <h3><a href="loginForm.php" class="btn btn-primary links">Zaloguj się na swoje konto</a></h3>
    <h3><a href="registerForm.php" class="btn btn-primary links">Utwórz nowe konto</a></h3>
    <div>
        <img src="../images/world_cup.jpeg" width="450" height="300" />
    </div>
    <hr/>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>