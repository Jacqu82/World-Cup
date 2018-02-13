<?php


class HomeTeamRepository
{
    public static function loadAllHomeTeams(PDO $connection)
    {
        $sql = "SELECT * FROM home_teams";

        $result = $connection->prepare($sql);
        if (!$result) {
            die('Query Error!' . $connection->errorInfo());
        }
        $result->execute();

        return $result;
    }
}
