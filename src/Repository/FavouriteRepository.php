<?php

namespace Repository;

use Model\Favourite;
use PDO;


class FavouriteRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveToDB(Favourite $favourite)
    {
        $id = $favourite->getId();
        $userId = $favourite->getUserId();
        $nationalTeamId = $favourite->getNationalTeamId();

        if ($id == -1) {
            $sql = "INSERT INTO favourites (user_id, national_team_id)
                    VALUES (:user_id, :national_team_id)";

            $result = $this->pdo->prepare($sql);

            $result->bindParam('user_id', $userId);
            $result->bindParam('national_team_id', $nationalTeamId);

            $result->execute();
            $id = $this->pdo->lastInsertId();

            return true;
        }

        return false;
    }

    public function loadAllFavouritesTeamsByUserId($userId)
    {
        $sql = "SELECT n.name FROM favourites f
                LEFT JOIN users u ON f.user_id = u.id
                LEFT JOIN national_teams n ON f.national_team_id = n.id
                WHERE user_id = :user_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;
    }

    public function secureVote($userId, $nationalTeamId)
    {
        $sql = "SELECT id FROM favourites
                WHERE user_id = :user_id AND national_team_id = :national_team_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('user_id', $userId);
        $result->bindParam('national_team_id', $nationalTeamId);
        $result->execute();

        if (!$result) {
            die("Connection Error" . $this->pdo->errorInfo());
        }

        return $result;

    }
}
