<?php


class MessageRepository
{
    public static function saveToDB(PDO $connection, Message $message)
    {
        $id = $message->getId();
        $senderId = $message->getSenderId();
        $receiverId = $message->getReceiverId();
        $text = $message->getText();
        $isRead = $message->getIsRead();

        if ($id == -1) {
            $sql = "INSERT INTO messages (sender_id, receiver_id, text, is_read)
                    VALUES (:sender_id, :receiver_id, :text, :is_read)";

            $result = $connection->prepare($sql);
            $result->bindParam('sender_id', $senderId);
            $result->bindParam('receiver_id', $receiverId);
            $result->bindParam('text', $text);
            $result->bindParam('is_read', $isRead);

            $result->execute();
            $id = $connection->lastInsertId();
            return true;
        }
        return false;
    }

    public static function loadAllReceivedMessagesByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT m.id, m.text, m.is_read, m.created_at, u.username FROM messages m 
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE m.receiver_id = :user_id
                ORDER BY m.created_at DESC";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }
        return $result;
    }

    public static function loadAllSentMessagesByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT m.id, m.text, m.created_at, u.username FROM messages m
                LEFT JOIN users u ON m.receiver_id = u.id
                WHERE m.sender_id = :user_id
                ORDER BY m.created_at DESC";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }
        return $result;
    }

    public static function setMessageStatus(PDO $connection, $messageId, $status)
    {
        $sql = "UPDATE messages SET is_read = :status WHERE id = :message_id";

        $result = $connection->prepare($sql);
        $result->bindParam('status', $status);
        $result->bindParam('message_id', $messageId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }
        return $result;
    }

    public static function loadMessageById(PDO $connection, $id)
    {
        $sql = "SELECT * FROM messages WHERE id = :id";

        $result = $connection->prepare($sql);
        $result->bindParam('id', $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $message = new Message();
            $message
                ->setId($row['id'])
                ->setReceiverId($row['receiver_id'])
                ->setSenderId($row['sender_id'])
                ->setText($row['text'])
                ->setCreatedAt($row['created_at']);

            return $message;
        }

        return null;
    }

    public static function delete(PDO $connection, Message $message)
    {
        $id = $message->getId();

        if ($id != -1) {
            $sql = "DELETE FROM messages WHERE id = :id";
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

    public static function countAllUnreadMessages(PDO $connection, $userId)
    {
        $sql = "SELECT count(id) as unread FROM messages WHERE is_read = 0 AND receiver_id = :user_id";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['unread'];
            }
        }

        return false;
    }
}