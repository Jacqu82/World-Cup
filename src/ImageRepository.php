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


//    public static function updateImage(PDO $connection, $userId)//to delete
//    {
//        $sql = "UPDATE images SET image_path WHERE user_id = :user_id";
//
//        $result = $connection->prepare($sql);
//        if (!$result) {
//            die("Query Error!" . $connection->errorInfo());
//        }
//
//        $result->bindParam('user_id', $userId);
//        $result->execute();
//
//        return true;
//    }

    public static function delete(PDO $connection, $id)
    {

        $sql = "DELETE FROM images WHERE id = :id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('id', $id);
        $result->execute();

        return true;
    }
}
