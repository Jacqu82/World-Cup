<?php

$user = loggedUser($connection);

?>
<div class="container">
    <div class="navbar-header">
        <div class="container text-center">
            <div class="navbar-header">
                <a class="navbar-brand" href="../web/mainPage.php">Strona główna</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="../web/groups.php">Grupy</a></li>
                    <li><a href="">Terminarz</a></li>
                    <li><a href="">Tabele</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    $unread = MessageRepository::countAllUnreadMessages($connection, $user->getId());
                    ?>
                    <li><a href="../web/messageSite.php">Messanger
                            <span class="badge"><?php echo $unread; ?></span></a></li>
                    <li><a href="../web/searchUsers.php">Szukaj znajomych</a></li>
                    <li style="margin-top: 15px">Zalogowany jako:
                        <a class="user" href="../web/userPanel.php">
                            <?php
                            echo $user->getUsername();
                            ?>
                        </a>
                    </li>
                    <li><a href="../web/logout.php">
                            <span class="glyphicon glyphicon-log-out"></span> Wyloguj
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>