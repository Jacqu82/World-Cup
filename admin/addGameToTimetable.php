<?php

require_once '../src/lib.php';
require_once '../connection.php';

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../web/index.php');
    exit();
}

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
    <h2>Dodaj mecz do terminarza</h2>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['round']) && isset($_POST['group']) && isset($_POST['team1']) && isset($_POST['team2'])
        && isset($_POST['city']) && isset($_POST['date']) && $_POST['hour']) {
            $round = filter_input(INPUT_POST, 'round', FILTER_SANITIZE_NUMBER_INT);
            $group = filter_input(INPUT_POST, 'group', FILTER_SANITIZE_STRING);
            $nationalTeam1 = filter_input(INPUT_POST, 'team1', FILTER_SANITIZE_NUMBER_INT);
            $nationalTeam2 = filter_input(INPUT_POST, 'team2', FILTER_SANITIZE_NUMBER_INT);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            $hour = filter_input(INPUT_POST, 'hour', FILTER_SANITIZE_STRING);

            $game = new Match();
            $game
                ->setRound($round)
                ->setGroupId($group)
                ->setNationalTeam1Id($nationalTeam1)
                ->setNationalTeam2Id($nationalTeam2)
                ->setCity($city)
                ->setDate($date)
                ->setHour($hour);
            if (MatchRepository::saveToDB($connection, $game)) {
                echo "<div class=\"flash-message alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Poprawnie dodano szpilek do terminarza</strong>';
                echo "</div>";
            }
        }
    }


    ?>

    <form method="post" action="#">
        <div>
            <label for="roundField">Kolejka:</label>
            <div>
                <input type="number" name="round" class="forms" id="roundField" placeholder="Kolejka"/>
            </div>
        </div>
        <div>
            Wybierz grupe:<br/>
            <select name="group" class="forms">
                <?php
                $groups = GroupRepository::loadAllGroups($connection);
                foreach ($groups as $group) {
                    echo "<option value='" . $group['id'] . "'>" . $group['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            Wybierz pierwszą reprezentację:<br/>
            <select name="team1" class="forms">
                <?php
                $nationalTeam1 = NationalTeamRepository::loadAllNationalTeams($connection);
                foreach ($nationalTeam1 as $team1) {
                    echo "<option value='" . $team1['id'] . "'>" . $team1['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            Wybierz drugą reprezentację:<br/>
            <select name="team2" class="forms">
                <?php
                $nationalTeam2 = NationalTeamRepository::loadAllNationalTeams($connection);
                foreach ($nationalTeam2 as $team2) {
                    echo "<option value='" . $team2['id'] . "'>" . $team2['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="cityField">Miasto:</label>
            <div>
                <input type="text" name="city" class="forms" id="cityField" placeholder="Miasto"/>
            </div>
        </div>
        <div>
            <label for="dateField">Data:</label>
            <div>
                <input type="text" name="date" class="forms" id="dateField" placeholder="Data"/>
            </div>
        </div>
        <div>
            <label for="hourField">Godzina:</label>
            <div>
                <input type="text" name="hour" class="forms" id="hourField" placeholder="Godzina"/>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-success button">Dodaj mecz</button>
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