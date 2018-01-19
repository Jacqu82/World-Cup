<?php


class NationalTeamRepository
{
    public static function saveToDB(PDO $connection, NationalTeam $nationalTeam)
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

    public static function loadAllNationalTeamsByGroupId(PDO $connection, $id)
    {
        $sql = "SELECT n.id, n.name, g.name as group_name FROM national_teams n
                LEFT JOIN groups g ON n.group_id = g.id
                WHERE group_id = :id";
        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
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

    public static function loadNationalTeamsById(PDO $connection, $id)
    {
        $sql = "SELECT name, coach FROM national_teams WHERE id = :id";
        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
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
}