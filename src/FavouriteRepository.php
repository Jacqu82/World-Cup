<?php


class FavouriteRepository
{
    public static function saveToDB(PDO $connection, Favourite $favourite)
    {
        $id = $favourite->getId();
        $userId = $favourite->getUserId();
        $nationalTeamId = $favourite->getNationalTeamId();

        if ($id == -1) {
            $sql = "INSERT INTO favourites (user_id, national_team_id)
                    VALUES (:user_id, :national_team_id)";

            $result = $connection->prepare($sql);

            $result->bindParam('user_id', $userId);
            $result->bindParam('national_team_id', $nationalTeamId);

            $result->execute();
            $id = $connection->lastInsertId();
            return true;
        }

        return false;
    }

    public static function loadAllFavouritesTeamsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT n.name FROM favourites f
                LEFT JOIN users u ON f.user_id = u.id
                LEFT JOIN national_teams n ON f.national_team_id = n.id
                WHERE user_id = :user_id";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;
    }

    public static function secureVote(PDO $connection, $userId, $nationalTeamId)
    {
        $sql = "SELECT id FROM favourites
                WHERE user_id = :user_id AND national_team_id = :national_team_id";

        $result = $connection->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->bindParam('national_team_id', $nationalTeamId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $connection->errorInfo());
        }

        return $result;

    }
}
