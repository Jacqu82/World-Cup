<?php


class User
{
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct()
    {
        $this->id = -1;
        $this->username = '';
        $this->email = '';
        $this->password = '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setHash($hash)
    {
        $this->password = $hash;
        return $this;
    }

    public function saveToDb(PDO $connection)
    {
        if ($this->id == -1) {
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

            $result = $connection->prepare($sql);
            if (!$result) {
                die("Database Error!" . $connection->errorInfo());
            }

            $result->bindParam('username', $this->username, PDO::PARAM_STR);
            $result->bindParam('email', $this->email, PDO::PARAM_STR);
            $result->bindParam('password', $this->password, PDO::PARAM_STR);

            $result->execute();

            return $result;
        }

        return false;
    }

}