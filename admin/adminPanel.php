<?php

session_start();

require __DIR__ . '/../autoload.php';

use Service\Container;

if (!isset($_SESSION['login'])) {
    header('Location: ../web/index.php');
    exit();
}

$container = new Container($configuration);
$user = $container->loggedUser();

if ($user->getRole() != 'admin') {
    header('Location: ../web/mainPage.php');
}


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
    <h3>Witaj <?php echo $user->getUsername() . "!"; ?></h3>
    <h3>Panel Administracyjny</h3>

    <a href="addNationalTeam.php" class="btn btn-success links">Dodaj reprezentacje do bazy</a>
    <a href="addGameToTimetable.php" class="btn btn-danger links">Dodaj mecz do terminarza</a>
    <a href="groupGames.php" class="btn btn-primary links">Uzupełnij terminarz</a>
    <a href="addNationalTeamImage.php" class="btn btn-info links">Dodaj zdjęcia reprezentacji</a>
    <a href="editNationalTeamImages.php" class="btn btn-success links">Edytuj zdjęcia reprezentacji</a>
    <a href="managePosts.php" class="btn btn-primary links">Zarządzaj postami</a>
    <a href="manageComments.php" class="btn btn-info links">Zarządzaj komentarzami</a>
    <a href="manageImages.php" class="btn btn-primary links">Zarządzaj zdjęciami użytkowników</a>
    <a href="addNationalTeamFlag.php" class="btn btn-warning links">Dodaj flagi reprezentacji</a>
    <a href="editNationalTeamFlag.php" class="btn btn-warning links">Edytuj flage reprezentacji</a>

    <hr/>
    <a href="../web/userPanel.php" class="btn btn-default links">Powrót do profilu</a>
    <hr/>
</div>

<?php

include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>
