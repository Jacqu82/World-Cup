<?php


class Game
{
    private $id;
    private $groupId;
    private $homeTeamId;
    private $awayTeamId;
    private $goalsHomeTeam;
    private $goalsAwayTeam;
    private $city;
    private $date;
    private $hour;

    public function __construct()
    {
        $this->id = -1;
        $this->groupId = -1;
        $this->homeTeamId = -1;
        $this->awayTeamId = -1;
        $this->goalsHomeTeam = 0;
        $this->goalsAwayTeam = 0;
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
    public function getHomeTeamId()
    {
        return $this->homeTeamId;
    }

    /**
     * @param int $homeTeamId
     * @return $this
     */
    public function setHomeTeamId($homeTeamId)
    {
        $this->homeTeamId = $homeTeamId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAwayTeamId()
    {
        return $this->awayTeamId;
    }

    /**
     * @param int $awayTeamId
     * @return $this
     */
    public function setAwayTeamId($awayTeamId)
    {
        $this->awayTeamId = $awayTeamId;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalsHomeTeam()
    {
        return $this->goalsHomeTeam;
    }

    /**
     * @param int $goalsHomeTeam
     * @return $this
     */
    public function setGoalsHomeTeam($goalsHomeTeam)
    {
        $this->goalsHomeTeam = $goalsHomeTeam;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoalsAwayTeam()
    {
        return $this->goalsAwayTeam;
    }

    /**
     * @param int $goalsAwayTeam
     * @return $this
     */
    public function setGoalsAwayTeam($goalsAwayTeam)
    {
        $this->goalsAwayTeam = $goalsAwayTeam;
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
