<?php

require_once 'autoload.php';

class UserRepository extends User
{
    public static function loadAllUsersByEmail(PDO $connection, $email)
    {
        $sql = "SELECT id FROM users WHERE email = :email";

        $result = $connection->prepare($sql);
        $result->bindParam('email', $email);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result;
    }

    public static function loadAllUsersByUsername(PDO $connection, $username)
    {
        $sql = "SELECT id FROM users WHERE username = :username";

        $result = $connection->prepare($sql);
        $result->bindParam('username', $username);
        $result->execute();

        return $result;
    }

    public static function loadUserByUsername(PDO $connection, $username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";

        $result = $connection->prepare($sql);
        $result->bindParam('username', $username);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetchAll();
            foreach ($row as $value) {
                $user = new User();
                $user->setUsername($value['username'])
                    ->setEmail($value['email'])
                    ->setHash($value['password']);
                return $user;
            }
        }

        return false;
    }

}