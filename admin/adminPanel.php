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
    <h3>Witaj <?php echo $user->getUsername(). "!"; ?></h3>
    <h3>Panel Administracyjny</h3>

    <a href="addNationalTeam.php" class="btn btn-success links">Dodaj reprezentacje do bazy</a>
    <a href="addNationalTeamImage.php" class="btn btn-success links">Dodaj zdjęcia reprezentacji</a>
    <a href="editNationalTeamImages.php" class="btn btn-primary links">Edytuj zdjęcia reprezentacji</a>

    <hr/>
</div>

<?php

include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>
