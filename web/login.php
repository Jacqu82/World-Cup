<?php

session_start();

require_once '../autoload.php';

use Service\Container;

$container = new Container($configuration);

if (isset($_POST['username']) || isset($_POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $user = $container->getUserRepository()->loadUserByUsername($username);
    if (!$user) {
        $_SESSION['error'] = 'Niepoprawny login lub hasło!';
        header('Location: loginForm.php');
    }
    if (password_verify($password, $user->getPassword())) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $user->getId();

        unset($_SESSION['error']);
        header('Location: mainPage.php');
    } else {
        $_SESSION['error'] = 'Niepoprawny login lub hasło!';
        header('Location: loginForm.php');
    }
} else {
    header('Location: index.php');
    exit();
}
