<?php


class AwayTeamRepository
{
    public static function loadAllAwayTeams(PDO $connection)
    {
        $sql = "SELECT * FROM away_teams";

        $result = $connection->prepare($sql);
        if (!$result) {
            die('Query Error!' . $connection->errorInfo());
        }
        $result->execute();

        return $result;
    }
}
