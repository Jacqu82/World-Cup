<?php

session_start();

require __DIR__ . '/../autoload.php';

use Model\GroupTable;
use Service\Container;

if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
//if for every page for logged user!!!

$container = new Container($configuration);
$matchRepository = $container->getMatchRepository();
$groupTableRepository = $container->getGroupTableRepository();

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

    $groupId = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['match_id']) && isset($_POST['goals_for']) && isset($_POST['goals_against'])) {
            $matchRepository->updateMatchGoalsByMatchId($_POST['match_id'], $_POST['goals_for'], $_POST['goals_against']);

            $matchId = $matchRepository->findOneById($_POST['match_id']);

            $groupTableHome = new GroupTable();
            $groupTableHome
                ->setTeamId($_POST['team1_id'])
                ->setGroupId($groupId)
                ->setRound($matchId['round'])
                ->setWon(1)
                ->setDraw(1)
                ->setLose(1)
                ->setGoalsFor(2)
                ->setGoalsAgainst(2)
                ->setGoalsDiff(2 - 2)
                ->setPoints(1);

            $groupTableRepository->saveToDB($groupTableHome);

            $groupTableAway = new GroupTable();
            $groupTableAway
                ->setTeamId($_POST['team2_id'])
                ->setGroupId($groupId)
                ->setRound($matchId['round'])
                ->setWon(1)
                ->setDraw(1)
                ->setLose(1)
                ->setGoalsFor(3)
                ->setGoalsAgainst(3)
                ->setGoalsDiff(3 - 3)
                ->setPoints(1);

            $groupTableRepository->saveToDB($groupTableAway);

            header('Location: editGames.php?id=' . $groupId);
        }
    }

    $matches = $matchRepository->loadAllMatchesByGroupId($groupId);
    //dump($matches);die;
    foreach ($matches as $match) {
        //var_dump($match);
        echo '<h4>' . $match['date'] . ' ' . $match['hour'] . ' - ' . $match['city'] . '</h4>';
        echo '<h2>' . $match['team1'] . ' - ' . $match['team2'] . '</h2>';

        if (($match['goals_for'] === null) && ($match['goals_against'] === null)) {
            ?>
            <form method="post" action="#">
                <input type="hidden" name="match_id" value="<?php echo $match['id']; ?>"/>
                <input type="hidden" name="team1_id" value="<?php echo $match['team1_id']; ?>"/>
                <input type="hidden" name="team2_id" value="<?php echo $match['team2_id']; ?>"/>
<!--                <input type="hidden" name="group_id" value="--><?php //echo $match['group_id']; ?><!--"/>-->
                <input type="number" name="goals_for" class="forms-goal" value="<?php echo $match['goals_for'] ?>"/>
                <input type="number" name="goals_against" class="forms-goal" value="<?php echo $match['goals_against'] ?>"/><br/>
                <button type="submit" class="btn btn-success links">Zapisz wynik</button>
            </form>
            <hr/>
            <?php

        } else {
            echo '<h2>' . $match['goals_for'] . ' : ' . $match['goals_against'] . '</h2>';
        }
    }
    ?>

    <h3><a href="groupGames.php" class="btn btn-default links">Powrót do grup</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>