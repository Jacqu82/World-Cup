<?php

namespace Repository;

use PDO;

class GroupRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loadAllGroups()
    {
        $sql = "SELECT * FROM groups";
        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->execute();
        $groups = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $groups[] = $row;
            }
            return $groups;
        }

        return false;
    }

    public function loadAllGroupsById($id)
    {
        $sql = "SELECT * FROM groups WHERE id = :id";
        $result = $this->pdo->prepare($sql);
        if (!$result) {
            die("Query Error!" . $this->pdo->errorInfo());
        }

        $result->bindParam('id', $id);
        $result->execute();
        $groups = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $groups[] = $row;
            }
            return $groups;
        }

        return false;
    }
}