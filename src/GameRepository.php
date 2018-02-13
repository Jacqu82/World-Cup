<?php


class GameRepository
{
    public static function saveToDB(PDO $connection, Game $game)
    {
        $id = $game->getId();
        $groupId = $game->getGroupId();
        $homeTeamId = $game->getHomeTeamId();
        $awayTeamId = $game->getAwayTeamId();
        $goalsHomeTeam = $game->getGoalsHomeTeam();
        $goalsAwayTeam = $game->getGoalsAwayTeam();
        $city = $game->getCity();
        $date = $game->getDate();
        $hour = $game->getHour();

        if ($id == -1) {
            $sql = "INSERT INTO game (group_id, home_team_id, away_team_id, goals_home_team, goals_away_team,
                    city, date, hour) VALUES
                    (:group_id, :home_team_id, :away_team_id, :goals_home_team, :goals_away_team, :city, :date, :hour)";

            $result = $connection->prepare($sql);
            $result->bindParam('group_id', $groupId, PDO::PARAM_INT);
            $result->bindParam('home_team_id', $homeTeamId, PDO::PARAM_INT);
            $result->bindParam('away_team_id', $awayTeamId, PDO::PARAM_INT);
            $result->bindParam('goals_home_team', $goalsHomeTeam, PDO::PARAM_INT);
            $result->bindParam('goals_away_team', $goalsAwayTeam, PDO::PARAM_INT);
            $result->bindParam('city', $city, PDO::PARAM_STR);
            $result->bindParam('date', $date, PDO::PARAM_STR);
            $result->bindParam('hour', $hour, PDO::PARAM_STR);
            $result->execute();

            return true;
        }

        return false;
    }
}
