<?php

namespace Model;


class Image
{
    private $id;
    private $imagePath;
    private $userId;
    private $nationalTeamId;
    private $flagId;
    private $createdAt;

    public function __construct()
    {
        $this->id = -1;
        $this->imagePath = '';
        $this->userId = null;
        $this->nationalTeamId = null;
        $this->flagId = null;
    }

    /**
     * @param $id
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $imagePath
     * @return $this
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
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
     * @return null
     */
    public function getFlagId()
    {
        return $this->flagId;
    }

    /**
     * @param null $flagId
     * @return $this
     */
    public function setFlagId($flagId)
    {
        $this->flagId = $flagId;
        return $this;
    }
}
