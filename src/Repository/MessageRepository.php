<?php

namespace Repository;

use Model\Message;
use PDO;

class MessageRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveToDB(Message $message)
    {
        $id = $message->getId();
        $senderId = $message->getSenderId();
        $receiverId = $message->getReceiverId();
        $text = $message->getText();
        $isRead = $message->getIsRead();

        if ($id == -1) {
            $sql = "INSERT INTO messages (sender_id, receiver_id, text, is_read)
                    VALUES (:sender_id, :receiver_id, :text, :is_read)";

            $result = $this->pdo->prepare($sql);
            $result->bindParam('sender_id', $senderId);
            $result->bindParam('receiver_id', $receiverId);
            $result->bindParam('text', $text);
            $result->bindParam('is_read', $isRead);

            $result->execute();
            $id = $this->pdo->lastInsertId();

            return true;
        }

        return false;
    }

    public function loadAllReceivedMessagesByUserId($userId)
    {
        $sql = "SELECT m.id, m.text, m.is_read, m.created_at, u.username FROM messages m 
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE m.receiver_id = :user_id
                ORDER BY m.created_at DESC";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function loadAllSentMessagesByUserId($userId)
    {
        $sql = "SELECT m.id, m.text, m.created_at, u.username FROM messages m
                LEFT JOIN users u ON m.receiver_id = u.id
                WHERE m.sender_id = :user_id
                ORDER BY m.created_at DESC";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function setMessageStatus($messageId, $status)
    {
        $sql = "UPDATE messages SET is_read = :status WHERE id = :message_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('status', $status);
        $result->bindParam('message_id', $messageId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }
        return $result;
    }

    public function loadMessageById($id)
    {
        $sql = "SELECT * FROM messages WHERE id = :id";

        $result = $this->pdo->prepare($sql);
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

        return false;
    }

    public function delete(Message $message)
    {
        $id = $message->getId();

        if ($id != -1) {
            $sql = "DELETE FROM messages WHERE id = :id";
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

    public function countAllUnreadMessages($userId)
    {
        $sql = "SELECT count(id) as unread FROM messages WHERE is_read = 0 AND receiver_id = :user_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['unread'];
            }
        }

        return false;
    }

    public function countAllReceivedMessages($userId)
    {
        $sql = "SELECT count(id) as received FROM messages WHERE receiver_id = :user_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['received'];
            }
        }

        return false;
    }

    public function countAllSentMessages($userId)
    {
        $sql = "SELECT count(id) as sent FROM messages WHERE sender_id = :user_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['sent'];
            }
        }

        return false;
    }
}