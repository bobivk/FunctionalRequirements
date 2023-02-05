<?php
require_once("../../db/db.php");
//    session_start();
        try{
            $userData = json_decode(file_get_contents("php://input"), true);
            var_dump($userData);
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT username, email FROM users WHERE username=:username OR email=:email";
            $statement = $connection -> prepare($sql);
            $statement -> execute(["username" => $userData["username"], "email" => $userData["email"]]);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            while ($user = $results) {
                if($user["email"] == $userData["email"]) {
                    echo json_encode(array("exists" => true, "sameUsername"=> false, "sameEmail"=> true));
                }
                if($user["username"] == $userData["username"]) {
                    echo json_encode(array("exists" => true, "sameUsername"=> true, "sameEmail"=> false));
                }
            }
            echo json_encode(array("exists" => false, "sameUsername"=> false, "sameEmail"=> false));
       } catch(PDOException $exc) {
           http_response_code(500);
           echo ["message" => $exc->getMessage()];
       }
?>