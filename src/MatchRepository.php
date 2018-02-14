<?php


class MatchRepository
{
    public static function saveToDB(PDO $connection, Match $match)
    {
        $id = $match->getId();
        $round = $match->getRound();
        $groupId = $match->getGroupId();
        $nationalTeam1Id = $match->getNationalTeam1Id();
        $nationalTeam2Id = $match->getNationalTeam2Id();
        $goalsFor = $match->getGoalsFor();
        $goalsAgainst = $match->getGoalsAgainst();
        $city = $match->getCity();
        $date = $match->getDate();
        $hour = $match->getHour();

        if ($id == -1) {
            $sql = "INSERT INTO matches (round, group_id, national_team_1_id, national_team_2_id, 
                                        goals_for, goals_against, city, date, hour) 
                    VALUES (:round, :group_id, :national_team_1_id, :national_team_2_id, :goals_for,
                            :goals_against, :city, :date, :hour)";

            $result = $connection->prepare($sql);
            $result->bindParam('group_id', $groupId, PDO::PARAM_INT);
            $result->bindParam('round', $round, PDO::PARAM_INT);
            $result->bindParam('national_team_1_id', $nationalTeam1Id, PDO::PARAM_INT);
            $result->bindParam('national_team_2_id', $nationalTeam2Id, PDO::PARAM_INT);
            $result->bindParam('goals_for', $goalsFor, PDO::PARAM_INT);
            $result->bindParam('goals_against', $goalsAgainst, PDO::PARAM_INT);
            $result->bindParam('city', $city, PDO::PARAM_STR);
            $result->bindParam('date', $date, PDO::PARAM_STR);
            $result->bindParam('hour', $hour, PDO::PARAM_STR);
            $result->execute();

            return true;
        }

        return false;
    }

    public static function loadAllMatchesByGroupIdAndRound(PDO $connection, $groupId, $round)
    {
        $sql = "SELECT m.city, m.date, m.hour, n1.name as team1, n2.name as team2,
                m.goals_for, m.goals_against 
                FROM matches m
                LEFT JOIN national_teams n1 ON m.national_team_1_id = n1.id
                LEFT JOIN national_teams n2 ON m.national_team_2_id = n2.id
                WHERE m.group_id = :group_id
                AND m.round = :round";

        $result = $connection->prepare($sql);
        $result->bindParam('group_id', $groupId, PDO::PARAM_INT);
        $result->bindParam('round', $round, PDO::PARAM_INT);
        $result->execute();

        return $result;
    }

    public static function loadAllMatchesByGroupId(PDO $connection, $groupId)
    {
        $sql = "SELECT m.id, m.city, m.date, m.hour, n1.name as team1, n2.name as team2,
                n1.id as home, n2.id as away,
                m.goals_for, m.goals_against 
                FROM matches m
                LEFT JOIN national_teams n1 ON m.national_team_1_id = n1.id
                LEFT JOIN national_teams n2 ON m.national_team_2_id = n2.id
                WHERE m.group_id = :group_id";

        $result = $connection->prepare($sql);
        $result->bindParam('group_id', $groupId, PDO::PARAM_INT);
        $result->execute();

        return $result;
    }

    public static function updateMatchGoalsByMatchId(PDO $connection, $matchId, $goalsFor, $goalsAgainst)
    {
        $sql = "UPDATE matches SET goals_for = :goals_for,
                                    goals_against = :goals_against
                WHERE id = :match_id";

        $result = $connection->prepare($sql);
        $result->bindParam('match_id', $matchId, PDO::PARAM_INT);
        $result->bindParam('goals_for', $goalsFor, PDO::PARAM_INT);
        $result->bindParam('goals_against', $goalsAgainst, PDO::PARAM_INT);
        $result->execute();

        return $result;
    }

    public static function loadGoalsByTeamId(PDO $connection, $teamId)
    {
        $sql = "SELECT sum(goals_for) as gfor FROM matches
                WHERE national_team_1_id = :team_id";

        $result = $connection->prepare($sql);
        $result->bindParam('team_id', $teamId, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                return $row['gfor'];
            }
        }

        return false;
    }
}
