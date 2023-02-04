<?php
public function isAdmin($userRoleId) {
        $db = new DB();
        $connection = $db->getConnection();
        $sql = "SELECT id FROM roles WHERE title = 'admin'";
        $statement = $connection->query($sql);    
        $rows = $statement -> fetchAll();
        return $rows[0]["id"] == $userRoleId;
}
?>