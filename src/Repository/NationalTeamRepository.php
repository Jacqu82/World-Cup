<?php

namespace Repository;

use Model\NationalTeam;
use PDO;

class NationalTeamRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveToDB(PDO $connection, NationalTeam $nationalTeam)
    {
        $id = $nationalTeam->getId();
        $name = $nationalTeam->getName();
        $coach = $nationalTeam->getCoach();
        $groupId = $nationalTeam->getGroupId();


        if ($id == -1) {
            $sql = "INSERT INTO national_teams (name, coach, group_id) VALUES (:name, :coach, :group_id)";

            $result = $connection->prepare($sql);
            $result->bindParam('name', $name, PDO::PARAM_STR);
            $result->bindParam('coach', $coach, PDO::PARAM_STR);
            $result->bindParam('group_id', $groupId, PDO::PARAM_STR);

            $result->execute();
            //last insert id!!!!!
            $id = $connection->lastInsertId();
            return true;
        }
        return false;
    }

    public function loadAllNationalTeamsByGroupId($id)
    {
        $sql = "SELECT n.id, n.name, g.name as group_name, i.image_path FROM national_teams n
                LEFT JOIN groups g ON n.group_id = g.id
                LEFT JOIN images i ON n.id = i.flag_id
                WHERE group_id = :id";
        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('id', $id);
        $result->execute();
        $nationalTeams = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $nationalTeams[] = $row;
            }
            return $nationalTeams;
        }

        return false;
    }

    public function loadNationalTeamsById($id)
    {
        $sql = "SELECT name, coach FROM national_teams WHERE id = :id";
        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('id', $id);
        $result->execute();
        $array = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }

        return false;
    }

    public function loadAllNationalTeams(PDO $connection)
    {
        $sql = "SELECT id, name FROM national_teams";
        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

        $result->execute();
        $array = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }

        return false;
    }
}