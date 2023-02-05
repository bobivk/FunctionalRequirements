<?php
// require_once("../../db/db.php");
// session_start();
// $userRoleId = $_SESSION["user"]["role_id"];
// if(isAdmin($userRoleId)) {
//         http_response_code(200);
//         echo encode_json(["isAdmin" => true]);
// }
class AdminCheck {

        public function isAdmin($userRoleId) {
                $db = new DB();
                $connection = $db->getConnection();
                $sql = "SELECT id FROM roles WHERE title = 'admin'";
                $statement = $connection->query($sql);    
                $rows = $statement -> fetchAll();
                return $rows[0]["id"] == $userRoleId;
        }
}
?>