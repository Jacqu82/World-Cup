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

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
        $this->password = password_hash($password, PASSWORD_BCRYPT);
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
            $result->bindParam('username', $this->username, PDO::PARAM_STR);
            $result->bindParam('email', $this->email, PDO::PARAM_STR);
            $result->bindParam('password', $this->password, PDO::PARAM_STR);

            $result->execute();
            if ($result) {
                $this->id = $connection->lastInsertId();
            } else {
                die("Connection Error! " . $connection->errorInfo());
            }
        }
        return false;
    }

    public function updateUsername(PDO $connection)
    {
        $sql = "UPDATE users SET username = :username WHERE id = :id";
        $result = $connection->prepare($sql);

        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('username', $this->username);
        $result->bindParam('id', $this->id);
        $result->execute();

        return true;
    }

    public function updateEmail(PDO $connection)
    {
        $sql = "UPDATE users SET email = :email WHERE id = :id";
        $result = $connection->prepare($sql);

        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('email', $this->email);
        $result->bindParam('id', $this->id);
        $result->execute();

        return true;
    }

    public function updatePassword(PDO $connection)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $result = $connection->prepare($sql);

        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('password', $this->password);
        $result->bindParam('id', $this->id);
        $result->execute();

        return true;
    }
}
