<?php


class User
{
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct()
    {
        $this->id = -1;
        $this->username = '';
        $this->email = '';
        $this->password = '';
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setHash($hash)
    {
        $this->password = $hash;
        return $this;
    }
}
