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
            $upload = $result->execute();

            if ($upload) {
                return true;
            }
        }
        return false;
    }

    public static function loadImageByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT image_path FROM images WHERE user_id = :user_id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $pathArray = [];
        $result->bindParam('user_id', $userId);
        $result->execute();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $pathArray[] = $row['image_path'];
            }

            return $pathArray;
    }
}
