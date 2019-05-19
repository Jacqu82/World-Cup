<?php

namespace Model;

class Match
{
    private $id;
    private $round;
    private $groupId;
    private $nationalTeam1Id;
    private $nationalTeam2Id;
    private $goalsFor;
    private $goalsAgainst;
    private $city;
    private $date;
    private $hour;

    public function __construct()
    {
        $this->id = -1;
        $this->round = 0;
        $this->groupId = -1;
        $this->nationalTeam1Id = -1;
        $this->nationalTeam2Id = -1;
        $this->goalsFor = null;
        $this->goalsAgainst = null;
        $this->city = '';
        $this->date = '';
        $this->hour = '';
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
     * @return null
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * @param null $round
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
    public function getNationalTeam1Id()
    {
        return $this->nationalTeam1Id;
    }

    /**
     * @param int $nationalTeam1Id
     * @return $this
     */
    public function setNationalTeam1Id($nationalTeam1Id)
    {
        $this->nationalTeam1Id = $nationalTeam1Id;
        return $this;
    }

    /**
     * @return int
     */
    public function getNationalTeam2Id()
    {
        return $this->nationalTeam2Id;
    }

    /**
     * @param int $nationalTeam2Id
     * @return $this
     */
    public function setNationalTeam2Id($nationalTeam2Id)
    {
        $this->nationalTeam2Id = $nationalTeam2Id;
        return $this;
    }

    /**
     * @return null
     */
    public function getGoalsFor()
    {
        return $this->goalsFor;
    }

    /**
     * @param null $goalsFor
     * @return $this
     */
    public function setGoalsFor($goalsFor)
    {
        $this->goalsFor = $goalsFor;
        return $this;
    }

    /**
     * @return null
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @param null $goalsAgainst
     * @return $this
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param string $hour
     * @return $this
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
        return $this;
    }
}
