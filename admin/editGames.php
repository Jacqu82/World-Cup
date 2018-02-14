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
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['match_id']) && isset($_POST['goals_for']) && isset($_POST['goals_against'])) {
            MatchRepository::updateMatchGoalsByMatchId(
                    $connection, $_POST['match_id'], $_POST['goals_for'], $_POST['goals_against']);
        }
    }

    $matches = MatchRepository::loadAllMatchesByGroupId($connection, $_GET['id']);
    foreach ($matches as $match) {
        echo '<h4>' . $match['date'] . ' ' . $match['hour'] . ' - ' . $match['city'] . '</h4>';
        echo '<h2>' . $match['team1'] . ' - ' . $match['team2'] . '</h2>';

        if (($match['goals_for'] === null) && ($match['goals_against'] === null)) {
            ?>
            <form method="post" action="#">
                <input type="hidden" name="match_id" value="<?php echo $match['id']; ?>"/>
                <input type="number" name="goals_for" class="forms-goal" value="<?php echo $match['goals_for'] ?>"/>
                <input type="number" name="goals_against" class="forms-goal" value="<?php echo $match['goals_against'] ?>"/><br/>
                <button type="submit" class="btn btn-success links">Zapisz wynik</button>
            </form>
            <hr/>
            <?php
        } else {

            $goalsFor = MatchRepository::loadGoalsByTeamId($connection, $match['home']);
            var_dump($goalsFor);
            echo '<h2>' . $match['goals_for'] . ' : ' . $match['goals_against'] . '</h2>';
        }
    }
    ?>

    <h3><a href="adminPanel.php" class="btn btn-default links">Powrót do panelu Admina</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>