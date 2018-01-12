<?php

require_once 'autoload.php';

function loggedUser($connection)
{
    if (isset($_SESSION['id'])) {
        return UserRepository::loadUserById($connection, $_SESSION['id']);
    }
    return false;
}

//function getImageId($connection)
//{
//    if (isset($_SESSION['id'])) {
//        return ImageRepository::loadImageByUserId($connection, $_SESSION['id']);
//    }
//    return false;
//}
