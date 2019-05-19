<?php

namespace Repository;

use Model\User;
use PDO;

class UserRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveToDB(User $user)
    {
        $id = $user->getId();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        if ($id == -1) {
            $sql = "INSERT INTO users (username, email, password, role) 
                    VALUES (:username, :email, :password, :role)";

            $result = $this->pdo->prepare($sql);
            $result->bindParam('username', $username, PDO::PARAM_STR);
            $result->bindParam('email', $email, PDO::PARAM_STR);
            $result->bindParam('password', $password, PDO::PARAM_STR);
            $result->bindParam('role', $role, PDO::PARAM_STR);

            $result->execute();
            //last insert id!!!!!
            $id = $this->pdo->lastInsertId();

            return true;
        }

        return false;
    }

    public function updateUsername(User $user)
    {
        $id = $user->getId();
        $username = $user->getUsername();

        $sql = "UPDATE users SET username = :username WHERE id = :id";
        $result = $this->pdo->prepare($sql);

        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('username', $username, PDO::PARAM_STR);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();

        return true;
    }

    public function updateEmail(User $user)
    {
        $id = $user->getId();
        $email = $user->getEmail();

        $sql = "UPDATE users SET email = :email WHERE id = :id";
        $result = $this->pdo->prepare($sql);

        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('email', $email, PDO::PARAM_STR);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();

        return true;
    }

    public function updatePassword(User $user)
    {
        $id = $user->getId();
        $password = $user->getPassword();

        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $result = $this->pdo->prepare($sql);

        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('password', $password, PDO::PARAM_STR);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();

        return true;
    }

    public function delete(User $user)
    {
        $id = $user->getId();

        if ($id != -1) {
            $sql = "DELETE FROM users WHERE id = :id";
            $result = $this->pdo->prepare($sql);

            $result->bindParam('id', $id, PDO::PARAM_INT);
            $result->execute();

            if ($result) {
                $id = -1;
                return true;
            }

            return false;
        }

        return true;
    }


    public function loadUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";

        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $user = new User();
            $user
                ->setId($row['id'])
                ->setUsername($row['username'])
                ->setEmail($row['email'])
                ->setHash($row['password'])
                ->setRole($row['role'])
                ->setCreatedAt($row['created_at']);

            return $user;
        }

        return false;
    }

    public function loadAllSearchedUsers($username)
    {
        $sql = "SELECT id, username FROM users WHERE username LIKE :username";

        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindValue('username', $username.'%');
        $result->execute();

        return $result;
    }

    public function loadAllUsersByEmail($email)
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('email', $email);
        $result->execute();

        return $result;
    }

    public function loadAllUsersByUsername($username)
    {
        $sql = "SELECT id FROM users WHERE username = :username";

        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('username', $username, PDO::PARAM_STR);
        $result->execute();

        return $result;
    }

    public function loadUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";

        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }
        //' OR 1=1 --

        $result->bindParam('username', $username, PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetch();
            $user = new User();
            $user
                ->setId($row['id'])
                ->setUsername($row['username'])
                ->setEmail($row['email'])
                ->setHash($row['password'])
                ->setCreatedAt($row['created_at']);
            return $user;
        }

        return false;
    }

    public function loadUsersExceptMe($userId)
    {
        $sql = "SELECT id, username FROM users WHERE id <> :user_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId, PDO::PARAM_INT);
        $result->execute();

        $userArray = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $userArray[] = $row;
            }
            return $userArray;
        }

        return false;
    }

    //    public function loadSql(PDO $connection)
//    {
//        $sql = "SELECT * FROM users";
//        $result = $connection->prepare($sql);
//        if (!$result) {
//            die("Query Error!" . $connection->errorInfo());
//        }
//
//        $result->execute();
//        $array = [];
//        if ($result->rowCount() > 0) {
////            foreach ($result as $row) {
////                return $row;
////            }
//            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//                $array[] = $row;
//            }
//            return $array;
//        }
//
//        return false;
//    }
}
