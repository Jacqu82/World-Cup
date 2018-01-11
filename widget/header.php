<?php

//require_once '../connection.php';

$user = loggedUser($connection);

?>
<div class="container">
    <div class="navbar-header">
        <div class="container text-center">
            <div class="navbar-header">
                <a class="navbar-brand" href="mainPage.php">Strona główna</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
<!--                    <li><a href="{{ path('user_show_all') }}">Admin Panel</a></li>-->
<!--                    <li><a href="{{ path('place_show_all') }}">Piękne miejsca</a></li>-->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li style="margin-top: 15px">Zalogowany jako:
<!--                        <a style="float: right; margin-top: -15px" href="">-->
                        <a class="user" href="userPanel.php">
                            <?php
                            echo $user->getUsername();
                            //echo $_SESSION['username'];
                            ?>
                        </a>
                    </li>
                    <li><a href="logout.php">
                            <span class="glyphicon glyphicon-log-out"></span> Wyloguj
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>