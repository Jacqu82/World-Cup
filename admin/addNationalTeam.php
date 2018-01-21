<?php
require_once '../src/lib.php';
require_once '../connection.php';
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../web/index.php');
    exit();
}
//if for every page for logged user!!!

$user = loggedUser($connection);

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

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['name']) && isset($_POST['coach']) && isset($_POST['groups'])) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $coach = filter_input(INPUT_POST, 'coach', FILTER_SANITIZE_STRING);
            $groupId = $_POST['groups'];

            $nationalTeam = new NationalTeam();
            $nationalTeam
                ->setName($name)
                ->setCoach($coach)
                ->setGroupId($groupId);
            if (NationalTeamRepository::saveToDB($connection, $nationalTeam)) {
                echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Poprawnie dodano reprezentację do bazy</strong>';
                echo "</div>";
            }
        }
    }

    ?>

    <form method="POST" action="addNationalTeam.php">
        <div>
            <label for="nameField">Reprezentacja:</label>
            <div>
                <input type="text" name="name" class="forms" id="nameField" placeholder="Reprezentacja"/>
            </div>
        </div>
        <div>
            <label for="coachField">Trener</label>
            <div>
                <input type="text" name="coach" class="forms" id="coachField" placeholder="Trener"/>
            </div>
        </div>
        <div>
            Wybierz grupe:<br/>
                <select name="groups" class="forms">
                    <?php
                    $groups = GroupRepository::loadAllGroups($connection);
                    foreach ($groups as $group) {
                        echo "<option value='" . $group['id'] . "'>" . $group['name'] . "</option>";
                    }
                    ?>
                </select>
        </div>
        <div>
            <button type="submit" class="btn btn-success button">Dodaj</button>
        </div>
    </form>

    <hr/>
    <h3><a href="adminPanel.php" class="btn btn-default links">Powrót do panelu Admina</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>