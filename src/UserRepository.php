<?php


class UserRepository
{

    public static function loadSql(PDO $connection)
    {
        $sql = "SELECT * FROM users";
        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->execute();
        $array = [];
        if ($result->rowCount() > 0) {
//            foreach ($result as $row) {
//                return $row;
//            }
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }

        return false;
    }


    public static function saveToDB(PDO $connection, User $user)
    {
        $id = $user->getId();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        if ($id == -1) {
            $sql = "INSERT INTO users (username, email, password, role) 
                    VALUES (:username, :email, :password, :role)";

            $result = $connection->prepare($sql);
            $result->bindParam('username', $username, PDO::PARAM_STR);
            $result->bindParam('email', $email, PDO::PARAM_STR);
            $result->bindParam('password', $password, PDO::PARAM_STR);
            $result->bindParam('role', $role, PDO::PARAM_STR);

            $result->execute();
            //last insert id!!!!!
            $id = $connection->lastInsertId();
            return true;
        }
        return false;
    }

    public static function updateUsername(PDO $connection, User $user)
    {
        $id = $user->getId();
        $username = $user->getUsername();

        $sql = "UPDATE users SET username = :username WHERE id = :id";
        $result = $connection->prepare($sql);

        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('username', $username);
        $result->bindParam('id', $id);
        $result->execute();

        return true;
    }

    public static function updateEmail(PDO $connection, User $user)
    {
        $id = $user->getId();
        $email = $user->getEmail();

        $sql = "UPDATE users SET email = :email WHERE id = :id";
        $result = $connection->prepare($sql);

        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('email', $email);
        $result->bindParam('id', $id);
        $result->execute();

        return true;
    }

    public static function updatePassword(PDO $connection, User $user)
    {
        $id = $user->getId();
        $password = $user->getPassword();

        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $result = $connection->prepare($sql);

        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('password', $password);
        $result->bindParam('id', $id);
        $result->execute();

        return true;
    }

    public static function delete(PDO $connection, User $user)
    {
        $id = $user->getId();

        if ($id != -1) {
            $sql = "DELETE FROM users WHERE id = :id";
            $result = $connection->prepare($sql);

            $result->bindParam('id', $id);
            $result->execute();

            if ($result) {
                $id = -1;
                return true;
            }
            return false;
        }
        return true;
    }


    public static function loadUserById(PDO $connection, $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('id', $id);
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

    public static function loadAllUsersByEmail(PDO $connection, $email)
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('email', $email);
        $result->execute();

        return $result;
    }

    public static function loadAllUsersByUsername(PDO $connection, $username)
    {
        $sql = "SELECT id FROM users WHERE username = :username";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('username', $username);
        $result->execute();

        return $result;
    }

    public static function loadUserByUsername(PDO $connection, $username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }
        //' OR 1=1 --

        $result->bindParam('username', $username);
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

    public static function loadUsersExceptMe(PDO $connection, $userId)
    {
        $sql = "SELECT id, username FROM users WHERE id <> :user_id";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
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

}