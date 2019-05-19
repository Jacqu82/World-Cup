<?php

namespace Repository;

use Model\Post;
use PDO;

class PostRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveToDB(Post $post)
    {
        $id = $post->getId();
        $userId = $post->getUserId();
        $text = $post->getText();

        if ($id == -1) {
            $sql = "INSERT INTO posts (user_id, text)
                    VALUES (:user_id, :text)";

            $result = $this->pdo->prepare($sql);
            $result->bindParam('user_id', $userId);
            $result->bindParam('text', $text);

            $result->execute();
            $id = $this->pdo->lastInsertId();
            return true;
        }

        return false;
    }

    public function loadAllPosts()
    {
        $sql = "SELECT p.id, p.text, p.created_at, u.username FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id
                ORDER BY created_at DESC";

        $result = $this->pdo->prepare($sql);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function loadAllPostsExceptAdmin(PDO $connection, $id)
    {
        $sql = "SELECT p.id, p.text, p.created_at, u.username FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id
                WHERE user_id <> :id
                ORDER BY created_at DESC";

        $result = $connection->prepare($sql);
        $result->bindParam('id', $id);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;
    }

    public function loadAllPostsByUserId($userId)
    {
        $sql = "SELECT p.id, p.text, p.created_at, u.username FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.user_id = :user_id
                ORDER BY created_at DESC";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function countAllPosts()
    {
        $sql = "SELECT count(id) as count FROM posts";

        $result = $this->pdo->prepare($sql);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['count'];
            }
        }

        return false;
    }

    public function countAllPostsExceptAdmin(PDO $connection, $id)
    {
        $sql = "SELECT count(id) as count FROM posts
                WHERE user_id <> :id";

        $result = $connection->prepare($sql);
        $result->bindParam('id', $id);
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

    public function countAllPostsByUserId($userId)
    {
        $sql = "SELECT count(id) as count FROM posts WHERE user_id = :user_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['count'];
            }
        }

        return false;
    }

    public function updatePostText($id, $text)
    {

        $sql = "UPDATE posts SET text = :text WHERE id = :id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('text', $text);
        $result->bindParam('id', $id);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function loadPostById($id)
    {
        $sql = "SELECT * FROM posts WHERE id = :id";

        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('id', $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $post = new Post();
            $post
                ->setId($row['id'])
                ->setUserId($row['user_id'])
                ->setText($row['text'])
                ->setCreatedAt($row['created_at']);

            return $post;
        }

        return false;
    }

    public function delete(Post $post)
    {
        $id = $post->getId();

        if ($id != -1) {
            $sql = "DELETE FROM posts WHERE id = :id";
            $result = $this->pdo->prepare($sql);

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
}
