<?php

session_start();

require_once '../connection.php';
require_once 'autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $is_ok = true;
        //check validate

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        //check username length
        if ((strlen($username) < 3) || (strlen($username) > 15)) {
            $is_ok = false;
            $_SESSION['e_username'] = 'Login musi zawierać od 3 do 15 znaków!';
            header('Location: registerForm.php');
        }

        //check exiting username
        $users = UserRepository::loadAllUsersByUsername($connection, $username);
        if ($users->rowCount() > 0) {
            $is_ok = false;
            $_SESSION['e_username'] = 'Login ' . $_POST['username'] . ' już znajduje się w bazie danych! Wybierz inny!';
            header('Location: registerForm.php');
        }

        //alphanumeric letters
        if (ctype_alnum($username) === false) {
            $is_ok = false;
            $_SESSION['e_username'] = 'Nick może skaładać się tylko z liter i cyfr (bez polskich znaków)';
            header('Location: registerForm.php');
        }

        //check unique email
        $emails = UserRepository::loadAllUsersByEmail($connection, $email);
        if ($emails->rowCount() > 0) {
            $is_ok = false;
            $_SESSION['e_email'] = 'Adres ' . $_POST['email'] . ' już istnieje w bazie danych!';
            header('Location: registerForm.php');
        }

        //check correct e-mail
        if (empty($email)) {
            $is_ok = false;
            $_SESSION['e_email'] = 'To nie jest poprawny adres e-mail!';
            //echo $_POST['email'] . "<br/>" . $email;
            header('Location: registerForm.php');
        }

        //check password length
        if ((strlen($password) < 6) || (strlen($password) > 15)) {
            $is_ok = false;
            $_SESSION['e_password'] = 'Hasło musi zawierać od 6 do 15 znaków!';
            header('Location: registerForm.php');
        }

        //check recaptcha
        $secret_key = "6LdV4z8UAAAAAOjWqN5tA3fMbtMFNGMWxceyZ_Et";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);
        $response = json_decode($check);

        if ($response->success === false) {
            $is_ok = false;
            $_SESSION['e_bot'] = "Potwierdź że, nie jesteś botem!";
            header('Location: registerForm.php');
        }

        //validate_success!
        if ($is_ok) {
            $user = new User();
            $user
                ->setUsername($username)
                ->setEmail($email)
                ->setPassword($password);
            UserRepository::saveToDB($connection, $user);

            $_SESSION['register_success'] = true;
            header('Location: registerSuccess.php');
        }
    } else {
        header('Location: registerForm.php');
        exit();
    }
}
