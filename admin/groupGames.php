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

    $groups = $container->getGroupRepository()->loadAllGroups();
    foreach ($groups as $group) {
        $id = $group['id'];
        $name = $group['name'];

        echo "<h6><a href='editGames.php?id=$id'
                class='btn btn-success links'>$name</a></h6>";
    }

    ?>

    <hr/>
    <h3><a href="adminPanel.php" class="btn btn-default links">Powrót do panelu Admina</a></h3>
</div>
<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>