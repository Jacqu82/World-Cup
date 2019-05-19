<?php

session_start();

require __DIR__ . '/../autoload.php';

use Model\Favourite;
use Service\Container;

if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
//if for every page for logged user!!!

$container = new Container($configuration);
$favouriteRepository = $container->getFavouriteRepository();
$imageRepository = $container->getImageRepository();

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
        if (isset($_POST['user_id']) && isset($_POST['national_team_id'])) {
            $userId = $_POST['user_id'];
            $teamId = $_POST['national_team_id'];

            $favourite = new Favourite();
            $favourite
                ->setUserId($userId)
                ->setNationalTeamId($teamId);
            $favouriteRepository->saveToDB($favourite);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            $nationalTeamId = $_GET['id'];
        }


        $nationalTeamDetails = $container->getNationalTeamRepository()->loadNationalTeamsById($nationalTeamId);
        foreach ($nationalTeamDetails as $nationalTeamDetail) {
            echo '<h1>' . $nationalTeamDetail['name'] . '</h1>';
            echo '<h3>Trener reprezentacji: ' . $nationalTeamDetail['coach'] . '</h3>';
        }

        $flag = $imageRepository->loadFlagByNationalTeamId($nationalTeamId);
        foreach ($flag as $image) {

            ?>
            <div class='img-thumbnail1'>
                <img src="  <?php echo $image['image_path']; ?> " width='200' height='115'/><br/>
            </div>

            <?php
        }

        echo '<hr/>';

        $secure = $favouriteRepository->secureVote($user->getId(), $nationalTeamId);
        if ($secure->rowCount() == 0) {
            ?>
            <div class="vote">
                <a href="#" class="btn btn-success links favourite"
                   data-user_id="<?php echo $user->getId(); ?>"
                   data-team_id="<?php echo $nationalTeamId; ?>">Kibicuj</a>
            </div>

            <?php
        } else {
            echo "<div class=\"alert alert-success\">";
            echo '<strong>Kibicujesz :)</strong>';
            echo "</div>";
        }

        $images = $imageRepository->loadImageDetailsByNationalTeamId($nationalTeamId);
        foreach ($images as $image) {

            ?>
            <div class='img-thumbnail1'>
                <img src="  <?php echo $image['image_path']; ?> " width='500' height='300'/><br/>
            </div>

            <?php
        }
    }
    echo '<hr/>';

    $groups = $container->getGroupRepository()->loadAllGroupsById($_SESSION['group_id']);
    foreach ($groups as $group) {
        $id = $group['id'];
    }

    echo "<h3><a href='groupList.php?id=$id' class='btn btn-default links'>Powrót do grupy</a></h3>";
    ?>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>