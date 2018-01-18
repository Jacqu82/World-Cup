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

    public static function loadAllNationalTeams(PDO $connection)
    {
        $sql = "SELECT * FROM national_teams";
        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
        }

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
}