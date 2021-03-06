<?php

session_start();

require __DIR__ . '/../autoload.php';

use Service\Container;

if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
//if for every page for logged user!!!

$container = new Container($configuration);

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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            $groupId = $_GET['id'];
            $_SESSION['group_id'] = $groupId;

            $nationalTeams = $container->getNationalTeamRepository()->loadAllNationalTeamsByGroupId($groupId);
            echo '<h3>' . $nationalTeams[0]['group_name'] . '</h3>';

            foreach ($nationalTeams as $nationalTeam) {
                $id = $nationalTeam['id'];
                $name = $nationalTeam['name'];
                $flag = $nationalTeam['image_path'];

                ?>

                <div class="row"><a href="nationalTeamSite.php?id=<?php echo $id; ?>"
                                    class="btn btn-primary links group-list"><?php echo $name; ?>
                        <span class='img-thumbnail1'>
                            <img src="  <?php echo $flag; ?> " width='44' height='28'/><br/>
                        </span>
                </a></div>

                <?php
            }
        }
    }

    ?>

    <hr/>
    <h3><a href="groups.php" class="btn btn-default links">Powrót do listy grup</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>