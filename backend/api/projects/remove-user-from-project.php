<?php
    require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {

        try {
            $db = new DB();
            $connection = $db->getConnection();
            $select = "SELECT assigned_project_id FROM users where id = :user_id";
            $selectStatement = $connection -> prepare($select);
            $selectStatement -> execute(array("user_id" => $_SESSION["userId"]));
            $result = $selectStatement -> fetch();
            
            if(isset($result[0]) && $result[0] == $_GET["projectId"]) {  
                $sql = "UPDATE users SET assigned_project_id = null where id = :user_id";
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("user_id" => $_SESSION["userId"]));
                http_response_code(200);
                echo json_encode(["message" => "User removed from project."]);
            } else {
                http_response_code(400);
            }
        } catch(PDOException $exc) {
            http_response_code(500);
            echo json_encode(["message" => $exc->getMessage()]);
        }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп."]);
        }
?>