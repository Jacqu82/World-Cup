<?php


class PostRepository
{
    public static function saveToDB(PDO $connection, Post $post)
    {
        $id = $post->getId();
        $userId = $post->getUserId();
        $text = $post->getText();

        if ($id == -1) {
            $sql = "INSERT INTO posts (user_id, text)
                    VALUES (:user_id, :text)";

            $result = $connection->prepare($sql);
            $result->bindParam('user_id', $userId);
            $result->bindParam('text', $text);

            $result->execute();
            $id = $connection->lastInsertId();
            return true;
        }
        return false;
    }

    public static function loadAllPosts(PDO $connection)
    {
        $sql = "SELECT p.id, p.text, p.created_at, u.username FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id
                ORDER BY created_at DESC";

        $result = $connection->prepare($sql);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;
    }

    public static function loadAllPostsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT p.text, p.created_at, u.username FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.user_id = :user_id
                ORDER BY created_at DESC";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;
    }

    public static function countAllPosts(PDO $connection)
    {
        $sql = "SELECT count(id) as count FROM posts";

        $result = $connection->prepare($sql);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['count'];
            }
        }

        return false;
    }

    public static function countAllPostsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT count(id) as count FROM posts WHERE user_id = :user_id";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['count'];
            }
        }

        return false;
    }
}
