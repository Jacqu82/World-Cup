<?php


class CommentRepository
{
    public static function saveToDB(PDO $connection, Comment $comment)
    {
        $id = $comment->getId();
        $userId = $comment->getUserId();
        $postId = $comment->getPostId();
        $text = $comment->getText();

        if ($id == -1) {
            $sql = "INSERT INTO comments (user_id, post_id, text)
                    VALUES (:user_id, :post_id, :text)";

            $result = $connection->prepare($sql);
            $result->bindParam('user_id', $userId);
            $result->bindParam('post_id', $postId);
            $result->bindParam('text', $text);

            $result->execute();
            $id = $connection->lastInsertId();
            return true;
        }

        return false;
    }

    public static function loadAllCommentsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT c.text, c.created_at FROM comments c
                WHERE user_id = :user_id
                ORDER BY c.created_at DESC";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;
    }

    public static function loadAllCommentsByPostId(PDO $connection, $postId)
    {
        $sql = "SELECT c.text, c.created_at, u.username FROM comments c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE post_id = :post_id
                ORDER BY created_at DESC";

        $result = $connection->prepare($sql);
        $result->bindParam('post_id', $postId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;
    }

    public static function countAllCommentsByPostId(PDO $connection, $postId)
    {
        $sql = "SELECT count(id) as count FROM comments WHERE post_id = :post_id";

        $result = $connection->prepare($sql);
        $result->bindParam('post_id', $postId);
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

    public static function countAllCommentsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT count(id) as countComments FROM comments WHERE user_id = :user_id";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
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
}
