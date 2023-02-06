<?php
require_once("../../db/db.php");
//    session_start();
        try {
            $userData = json_decode(file_get_contents("php://input"), true);
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT username, email FROM users WHERE username=:username OR email=:email";
            $statement = $connection -> prepare($sql);
            $statement -> execute(["username" => $userData["username"], "email" => $userData["email"]]);
            $exists = false;
            while ($user = $statement->fetch(PDO::FETCH_ASSOC)) {
                if($user["email"] == $userData["email"]) {
                    $exists = true;
                    echo json_encode(array("exists" => true, "sameUsername"=> false, "sameEmail"=> true));
                }
                else if($user["username"] == $userData["username"]) {
                    $exists = true;
                    echo json_encode(array("exists" => true, "sameUsername"=> true, "sameEmail"=> false));
                }
            }
            if(!$exists){
                echo json_encode(array("exists" => false, "sameUsername"=> false, "sameEmail"=> false));
            }
       } catch(PDOException $exc) {
           http_response_code(500);
           echo ["message" => $exc->getMessage()];
       }
?>