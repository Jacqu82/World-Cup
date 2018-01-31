<?php

require_once '../connection.php';
require_once 'autoload.php';
require_once '../src/lib.php';

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$user = loggedUser($connection);

//if for every page for logged user!!!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['userSubmit'])) {
        $is_ok = true;
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

        //check username length
        if ((strlen($username) < 3) || (strlen($username) > 15)) {
            echo "<div class=\"text-center alert alert-danger\">";
            echo "<strong>Login musi zawierać od 3 do 15 znaków!</strong>";
            echo "</div>";
            $is_ok = false;
        }

        //check exiting username

        $users = UserRepository::loadAllUsersByUsername($connection, $username);
        if ($users->rowCount() > 0) {
            echo "<div class=\"text-center alert alert-danger\">";
            echo '<strong>Login ' . $_POST['username'] . ' już znajduje się w bazie danych! Wybierz inny!</strong>';
            echo "</div>";
            $is_ok = false;
        }

        //alphanumeric letters
        if (ctype_alnum($username) === false) {
            echo "<div class=\"text-center alert alert-danger\">";
            echo '<strong>Nick może skaładać się tylko z liter i cyfr (bez polskich znaków)</strong>';
            echo "</div>";
            $is_ok = false;
        }

        //validate success!!!
        if ($is_ok) {
            $user->setUsername($username);
            if (UserRepository::updateUsername($connection, $user)) {
                echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Zmieniono login na ' . $user->getUsername() . '</strong>';
                echo "</div>";
            }
        }
    }

    //update e-mail
    if (isset($_POST['email'], $_POST['emailSubmit'])) {
        $is_ok = true;
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        //check unique email
        $emails = UserRepository::loadAllUsersByEmail($connection, $email);
        if ($emails->rowCount() > 0) {
            echo "<div class=\"text-center alert alert-danger\">";
            echo '<strong>Adres ' . $_POST['email'] . ' już istnieje w bazie danych!</strong>';
            echo "</div>";
            $is_ok = false;

        }

        //check correct e-mail
        if (empty($email)) {
            echo "<div class=\"text-center alert alert-danger\">";
            echo '<strong>To nie jest poprawny adres e-mail!</strong>';
            echo "</div>";
            $is_ok = false;
        }

        //validate success!!!
        if ($is_ok) {
            $user->setEmail($email);
            if (UserRepository::updateEmail($connection, $user)) {
                echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Zmieniono adres e-mail na ' . $user->getEmail() . '</strong>';
                echo "</div>";
            }
        }
    }

    //update password

    if (isset($_POST['password'], $_POST['passSubmit'])) {
        $is_ok = true;
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        //check password length
        if ((strlen($password) < 6) || (strlen($password) > 15)) {
            echo "<div class=\"text-center alert alert-danger\">";
            echo '<strong>Hasło musi zawierać od 6 do 15 znaków!</strong>';
            echo "</div>";
            $is_ok = false;
        }

        //validate success!!!
        if ($is_ok) {
            $user->setPassword($password);
            if (UserRepository::updatePassword($connection, $user)) {
                echo "<div class=\"flash-message text-center alert alert-success alert-dismissible\" role=\"alert\">";
                echo '<strong>Hasło zostało zmienione!</strong>';
                echo "</div>";
            }
        }
    }

    if (isset($_POST['deleteAccount'])) {
        if (UserRepository::delete($connection, $user)) {

            if (isset($_SESSION['login'])) {
                unset($_SESSION['login']);
            }
            $_SESSION['delete_account'] = "Twoje konto zostało usunięte!";
            header('Location: index.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<?php

include '../widget/head.php';

?>

<?php
include '../widget/header.php';
?>
    <div class="container text-center">
        <h1>World Cup 2018</h1>
        <hr/>
        <div class="container" align="center">
            <form action="#" method="post">
                <h3>Edycja profilu</h3>
                    <p class="text-primary">Zmień login:</p>
                    <div class="form-group">
                        <input type="text" class="forms" name="username" value="<?php echo $user->getUsername(); ?>">
                        <br/>
                        <button type="submit" name="userSubmit" class="btn btn-warning links">Zmień</button>
                    </div>
                <hr/>
                    <p class="text-primary">Aktualizuj adres E-mail:</p>
                    <div class="form-group">
                        <input type="email" class="forms" name="email" value="<?php echo $user->getEmail(); ?>">
                        <br>
                        <button type="submit" name="emailSubmit" class="btn btn-warning links">Zmień</button>
                    </div>
                <hr/>
                    <p class="text-primary">Zmień hasło:</p>
                    <div class="form-group">
                        <input type="password" class="forms" name="password" placeholder="Hasło">
                        <br>
                        <button type="submit" name="passSubmit" class="btn btn-warning links">Zmień</button>
                    </div>
                <hr/>
                <div>
                    <div class="form-group">
                        <button type="submit" name="deleteAccount" class="btn btn-danger links">Usuń konto</button>
                    </div>
                </div>
            </form>
            <hr/>
            <h3><a href="userPanel.php" class="btn btn-default links">Powrót do profilu</a></h3>
        </div>
    </div>

<?php
include '../widget/footer.php';
include '../widget/scripts.php';
?>
</body>
</html>
