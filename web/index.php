<?php

session_start();

if (isset($_SESSION['login'])) {
    header('Location: mainPage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<?php

include '../widget/head.php';

?>
<body>
<div class="container text-center">
    <h1>World Cup 2018</h1>
    <h3><a href="loginForm.php" class="btn btn-primary links">Zaloguj się na swoje konto</a></h3>
    <h3><a href="registerForm.php" class="btn btn-primary links">Utwórz nowe konto</a></h3>

    <?php
    if (isset($_SESSION['delete_account'])) {
        echo "<div class=\"text-center alert alert-success\">";
        echo '<strong>' . $_SESSION['delete_account'] . '</strong>';
        echo "</div>";
        unset($_SESSION['delete_account']);
    }
    ?>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>