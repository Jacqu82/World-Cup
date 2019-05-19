<?php

namespace Repository;

use Model\Comment;
use PDO;

class CommentRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveToDB(Comment $comment)
    {
        $id = $comment->getId();
        $userId = $comment->getUserId();
        $postId = $comment->getPostId();
        $text = $comment->getText();

        if ($id == -1) {
            $sql = "INSERT INTO comments (user_id, post_id, text)
                    VALUES (:user_id, :post_id, :text)";

            $result = $this->pdo->prepare($sql);
            $result->bindParam('user_id', $userId);
            $result->bindParam('post_id', $postId);
            $result->bindParam('text', $text);

            $result->execute();
            $id = $this->pdo->lastInsertId();

            return true;
        }

        return false;
    }

    public function loadAllCommentsByUserId($userId)
    {
        $sql = "SELECT c.id, c.text, c.created_at FROM comments c
                WHERE user_id = :user_id
                ORDER BY c.created_at DESC";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function loadAllCommentsByPostId($postId)
    {
        $sql = "SELECT c.text, c.created_at, u.username FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE post_id = :post_id
                ORDER BY created_at DESC";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('post_id', $postId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function countAllCommentsByPostId($postId)
    {
        $sql = "SELECT count(id) as count FROM comments WHERE post_id = :post_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('post_id', $postId);
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

    public function countAllCommentsByUserId($userId)
    {
        $sql = "SELECT count(id) as countComments FROM comments WHERE user_id = :user_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['countComments'];
            }
        }

        return false;
    }

    public function countAllComments(PDO $connection)
    {
        $sql = "SELECT count(id) as countComments FROM comments";

        $result = $connection->prepare($sql);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['countComments'];
            }
        }
        return false;
    }

    public function countAllCommentsExceptAdmin(PDO $connection, $id)
    {
        $sql = "SELECT count(id) as countComments FROM comments WHERE user_id <> :id";

        $result = $connection->prepare($sql);
        $result->bindParam('id', $id);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['countComments'];
            }
        }

        return false;
    }

    public function updateCommentText($id, $text)
    {

        $sql = "UPDATE comments SET text = :text WHERE id = :id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('text', $text);
        $result->bindParam('id', $id);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function loadCommentById($id)
    {
        $sql = "SELECT * FROM comments WHERE id = :id";

        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('id', $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $comment = new Comment();
            $comment
                ->setId($row['id'])
                ->setUserId($row['user_id'])
                ->setPostId($row['post_id'])
                ->setText($row['text'])
                ->setCreatedAt($row['created_at']);

            return $comment;
        }

        return false;
    }

    public function delete(Comment $comment)
    {
        $id = $comment->getId();

        if ($id != -1) {
            $sql = "DELETE FROM comments WHERE id = :id";
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

    public function loadAllComments(PDO $connection, $id)
    {
        $sql = "SELECT c.id, c.text, c.created_at, u.username FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id
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
}
