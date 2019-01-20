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
    echo '<h2>' . $_GET['name'] . '</h2>';

    echo '<h3>1.kolejka</h3>';
    $rounds1 = MatchRepository::loadAllMatchesByGroupIdAndRound($connection, $_GET['id'], 1);
    foreach ($rounds1 as $round1) {
        echo '<h4>' . $round1['date'] . ' ' . $round1['hour'] . ' - ' . $round1['city'] . '</h4>';
        echo '<h2>' . $round1['team1'] . ' - ' . $round1['team2'] . '
         ' . $round1['goals_for'] . ' : ' . $round1['goals_against'] . '</h2>';
    }
    echo '<hr/>';

    echo '<h3>2.kolejka</h3>';
    $rounds2 = MatchRepository::loadAllMatchesByGroupIdAndRound($connection, $_GET['id'], 2);
    foreach ($rounds2 as $round2) {
        echo '<h4>' . $round2['date'] . ' ' . $round2['hour'] . ' - ' . $round2['city'] . '</h4>';
        echo '<h2>' . $round2['team1'] . ' - ' . $round2['team2'] . '
         ' . $round2['goals_for'] . ' : ' . $round2['goals_against'] . '</h2>';
    }
    echo '<hr/>';

    echo '<h3>3.kolejka</h3>';
    $rounds3 = MatchRepository::loadAllMatchesByGroupIdAndRound($connection, $_GET['id'], 3);
    foreach ($rounds3 as $round3) {
        echo '<h4>' . $round3['date'] . ' ' . $round3['hour'] . ' - ' . $round3['city'] . '</h4>';
        echo '<h2>' . $round3['team1'] . ' - ' . $round3['team2'] . '
         ' . $round3['goals_for'] . ' : ' . $round3['goals_against'] . '</h2>';
    }
    echo '<hr/>';

    ?>

    <table align="center">
        <thead>
        <tr>
            <th>Pozycja</th>
            <th>Reprezentacja</th>
            <th>Runda</th>
            <th>Zwycięstwa</th>
            <th>Remisy</th>
            <th>Porażki</th>
            <th>Gole +</th>
            <th>Gole -</th>
            <th>Gole +/-</th>
            <th>Punkty</th>
        </tr>
        </thead>
        <?php

        $matches = MatchRepository::loadAllMatchesByGroupId($connection, $_GET['id']);
        foreach ($matches as $match) {

//            $homeGoalsFor = MatchRepository::loadGoalsForHomeByTeamId($connection, $team['id']);
//            $awayGoalsFor = MatchRepository::loadGoalsForAwayByTeamId($connection, $team['id']);
//            $goalsFor = $homeGoalsFor + $awayGoalsFor;
//            $homeGoalsAgainst = MatchRepository::loadGoalsAgainstHomeByTeamId($connection, $team['id']);
//            $awayGoalsAgainst = MatchRepository::loadGoalsAgainstAwayByTeamId($connection, $team['id']);
//            $goalsAgainst = $homeGoalsAgainst + $awayGoalsAgainst;


            ?>
            <tbody>
            <tr>
                <td></td>
                <td><?php echo $match['team1'] ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
            <?php
        }
        ?>
    </table>
    <hr/>
    <h3><a href="groupGames.php" class="btn btn-default links">Powrót do listy grup</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>