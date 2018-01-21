<?php


class Favourite
{
    private $id;
    private $userId;
    private $nationalTeamId;
    private $createdAt;


    public function __construct()
    {
        $this->id = -1;
        $this->userId = -1;
        $this->nationalTeamId = -1;
        $this->createdAt = '';
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getNationalTeamId()
    {
        return $this->nationalTeamId;
    }

    /**
     * @param int $nationalTeamId
     * @return $this
     */
    public function setNationalTeamId($nationalTeamId)
    {
        $this->nationalTeamId = $nationalTeamId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
