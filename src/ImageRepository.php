<?php

class ImageRepository
{
    public static function saveToDB(PDO $connection, Image $image)
    {
        $id = $image->getId();
        $imagePath = $image->getImagePath();
        $userId = $image->getUserId();
        $nationalTeamId = $image->getNationalTeamId();

        if ($id == -1) {
            $sql = "INSERT INTO images (image_path, user_id, national_team_id) 
                    VALUES (:image_path, :user_id, :national_team_id)";

            $result = $connection->prepare($sql);
            $result->bindParam('image_path', $imagePath);
            $result->bindParam('user_id', $userId);
            $result->bindParam('national_team_id', $nationalTeamId);
            $result->execute();

            $id = $connection->lastInsertId();
            return true;
        }
        return false;
    }


    public static function loadImageDetailsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT * FROM images WHERE user_id = :user_id ORDER BY created_at DESC";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $imageArray = [];
        $result->bindParam('user_id', $userId);
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $imageArray[] = $row;
        }
        return $imageArray;
    }

    public static function loadNationalTeamImageDetails(PDO $connection)
    {
        $sql = "SELECT * FROM images WHERE national_team_id IS NOT NULL";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $imageArray = [];
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $imageArray[] = $row;
        }
        return $imageArray;
    }

    public static function loadUsersImageDetails(PDO $connection, $id)
    {
        $sql = "SELECT i.id, i.image_path, i.user_id, u.username FROM images i 
                LEFT JOIN users u ON i.user_id = u.id
                WHERE user_id IS NOT NULL 
                AND user_id <> :id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $imageArray = [];
        $result->bindParam('id', $id);
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $imageArray[] = $row;
        }
        return $imageArray;
    }

    public static function loadImageDetailsByNationalTeamId(PDO $connection, $nationalTeamId)
    {
        $sql = "SELECT * FROM images WHERE national_team_id = :national_team_id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $imageNationsArray = [];
        $result->bindParam('national_team_id', $nationalTeamId);
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $imageNationsArray[] = $row;
        }
        return $imageNationsArray;
    }

    public static function loadFirstImageDetailsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT * FROM images WHERE user_id = :user_id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('user_id', $userId);
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
        return null;
    }

    public static function loadImagePath(PDO $connection, $id)
    {
        $sql = "SELECT image_path FROM images WHERE id = :id";

        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->bindParam('id', $id);
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

    public static function countAllImagesByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT count(id) as count FROM images WHERE user_id = :user_id";

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

    public static function updateImagePath(PDO $connection, $path, $id)
    {
        $sql = "UPDATE images SET image_path = :image_path WHERE id = :id";

        $result = $connection->prepare($sql);
        $result->bindParam('image_path', $path);
        $result->bindParam('id', $id);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;
    }

    public static function countAllImagesExceptAdmin(PDO $connection, $id)
    {
        $sql = "SELECT count(id) as countImages FROM images WHERE user_id <> :id";

        $result = $connection->prepare($sql);
        $result->bindParam('id', $id);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['countImages'];
            }
        }

        return false;
    }
}
