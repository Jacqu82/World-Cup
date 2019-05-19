<?php

namespace Repository;

use Model\GroupTable;
use PDO;

class GroupTableRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveToDB(GroupTable $groupTable)
    {
        $id = $groupTable->getId();
        $teamId = $groupTable->getTeamId();
        $groupId = $groupTable->getGroupId();
        $round = $groupTable->getRound();
        $won = $groupTable->getWon();
        $draw = $groupTable->getDraw();
        $lose = $groupTable->getLose();
        $goalsFor = $groupTable->getGoalsFor();
        $goalsAgainst = $groupTable->getGoalsAgainst();
        $goalsDiff = $groupTable->getGoalsDiff();
        $points = $groupTable->getPoints();

        if ($id == -1) {
            $sql = "INSERT INTO group_tables (team_id, group_id, round, won, draw, lose, goals_for,
                    goals_against, goals_diff, points)
                    VALUES (:team_id, :group_id, :round, :won, :draw, :lose, :goals_for,
                    :goals_against, :goals_diff, :points)";

            $result = $this->pdo->prepare($sql);
            $result->bindParam('team_id', $teamId, PDO::PARAM_INT);
            $result->bindParam('group_id', $groupId, PDO::PARAM_INT);
            $result->bindParam('round', $round, PDO::PARAM_INT);
            $result->bindParam('won', $won, PDO::PARAM_INT);
            $result->bindParam('draw', $draw, PDO::PARAM_INT);
            $result->bindParam('lose', $lose, PDO::PARAM_INT);
            $result->bindParam('goals_for', $goalsFor, PDO::PARAM_INT);
            $result->bindParam('goals_against', $goalsAgainst, PDO::PARAM_INT);
            $result->bindParam('goals_diff', $goalsDiff, PDO::PARAM_INT);
            $result->bindParam('points', $points, PDO::PARAM_INT);
            $result->execute();

            $teamId = $this->pdo->lastInsertId();
            $groupTable = $this->loadGroupTableById($teamId);

            return $groupTable;

        } elseif ($id != -1) {
            $sql = "UPDATE group_tables SET team_id = :team_id,
                                            group_id = :group_id,
                                            round = :round,
                                            won = won + :won,
                                            draw = draw + :draw,
                                            lose = lose + :lose,
                                            goals_for = goals_for + :goals_for,
                                            goals_against = goals_against + :goals_against,
                                            goals_diff = :goals_diff,
                                            points = points + :points
                    WHERE id = :id";

            $result = $this->pdo->prepare($sql);
            $result->bindParam('id', $id, PDO::PARAM_INT);
            $result->bindParam('team_id', $teamId, PDO::PARAM_INT);
            $result->bindParam('group_id', $groupId, PDO::PARAM_INT);
            $result->bindParam('round', $round, PDO::PARAM_INT);
            $result->bindParam('won', $won, PDO::PARAM_INT);
            $result->bindParam('draw', $draw, PDO::PARAM_INT);
            $result->bindParam('lose', $lose, PDO::PARAM_INT);
            $result->bindParam('goals_for', $goalsFor, PDO::PARAM_INT);
            $result->bindParam('goals_against', $goalsAgainst, PDO::PARAM_INT);
            $result->bindParam('goals_diff', $goalsDiff, PDO::PARAM_INT);
            $result->bindParam('points', $points, PDO::PARAM_INT);
            $result->execute();

            $groupTable = GroupTableRepository::loadGroupTableById($teamId);

            return $groupTable;
        }

        return false;
    }

    public function loadGroupTableById($teamId)
    {
        $sql = "SELECT * FROM group_tables WHERE team_id = :team_id";

        $result = $this->pdo->prepare($sql);
        $result->bindParam('team_id', $teamId);
        $result->execute();

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $groupTable = new GroupTable();
            $groupTable
                ->setTeamId($row['team_id'])
                ->setGroupId($row['group_id'])
                ->setRound($row['round'])
                ->setWon($row['won'])
                ->setDraw($row['draw'])
                ->setLose($row['lose'])
                ->setGoalsFor($row['goals_for'])
                ->setGoalsAgainst($row['goals_against'])
                ->setGoalsDiff($row['goals_diff'])
                ->setPoints($row['points']);

            return $groupTable;
        }

        return false;
    }
}