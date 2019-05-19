<?php

namespace Model;


class GroupTable
{
    private $id;
    private $teamId;
    private $groupId;
    private $round;
    private $won;
    private $draw;
    private $lose;
    private $goalsFor;
    private $goalsAgainst;
    private $goalsDiff;
    private $points;

    public function __construct()
    {
        $this->id = -1;
        $this->teamId = -1;
        $this->groupId = -1;
        $this->round = 0;
        $this->won = 0;
        $this->draw = 0;
        $this->lose = 0;
        $this->goalsFor = 0;
        $this->goalsAgainst = 0;
        $this->goalsDiff = 0;
        $this->points = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @param int $teamId
     * @return $this
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     * @return $this
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @return int
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * @param int $round
     * @return $this
     */
    public function setRound($round)
    {
        $this->round = $round;
        return $this;
    }

    /**
     * @return int
     */
    public function getWon()
    {
        return $this->won;
    }

    /**
     * @param int $won
     * @return $this
     */
    public function setWon($won)
    {
        $this->won = $won;
        return $this;
    }

    /**
     * @return int
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @param int $draw
     * @return $this
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;
        return $this;
    }

    /**
     * @return int
     */
    public function getLose()
    {
        return $this->lose;
    }

    /**
     * @param int $lose
     * @return $this
     */
    public function setLose($lose)
    {
        $this->lose = $lose;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalsFor()
    {
        return $this->goalsFor;
    }

    /**
     * @param int $goalsFor
     * @return $this
     */
    public function setGoalsFor($goalsFor)
    {
        $this->goalsFor = $goalsFor;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @param int $goalsAgainst
     * @return $this
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalsDiff()
    {
        return $this->goalsDiff;
    }

    /**
     * @param int $goalsDiff
     * @return $this
     */
    public function setGoalsDiff($goalsDiff)
    {
        $this->goalsDiff = $goalsDiff;
        return $this;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }
}
