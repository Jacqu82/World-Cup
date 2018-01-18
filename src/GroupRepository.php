<?php


class GroupRepository
{
    public static function loadAllGroups(PDO $connection)
    {
        $sql = "SELECT * FROM groups";
        $result = $connection->prepare($sql);
        if (!$result) {
            die("Query Error!" . $connection->errorInfo());
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
}