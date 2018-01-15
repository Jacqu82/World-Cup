<?php

class ImageRepository
{
    public static function saveToDB(PDO $connection, Image $image)
    {
        $id = $image->getId();
        $imagePath = $image->getImagePath();
        $userId = $image->getUserId();

        if ($id == -1) {
            $sql = "INSERT INTO images (image_path, user_id) VALUES (:image_path, :user_id)";

            $result = $connection->prepare($sql);
            $result->bindParam('image_path', $imagePath);
            $result->bindParam('user_id', $userId);
            $result->execute();

            $id = $connection->lastInsertId();
            return true;
        }
        return false;
    }


    public static function loadImageDetailsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT * FROM images WHERE user_id = :user_id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $pathArray = [];
        $result->bindParam('user_id', $userId);
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $pathArray[] = $row;
        }
        return $pathArray;
    }

    public static function loadImagePath(PDO $connection, $userId)
    {
        $sql = "SELECT image_path FROM images WHERE user_id = :user_id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('user_id', $userId);
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $path = $row['image_path'];
        }
        return $path;
    }

    public static function loadImageById(PDO $connection, $id)
    {
        $sql = "SELECT * FROM images WHERE id = :id";

        $result = $connection->prepare($sql);

        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('id', $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $image = new Image();
            $image
                ->setId($row['id'])
                ->setImagePath($row['image_path'])
                ->setUserId($row['user_id'])
                ->setCreatedAt($row['created_at']);

            return $image;
        }

        return false;
    }

    public static function delete(PDO $connection, Image $image)
    {
        $id = $image->getId();

        if ($id != -1) {
            $sql = "DELETE FROM images WHERE id = :id";
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
}
