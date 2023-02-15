<?php
    require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
        $db = new DB();
        $connection = $db->getConnection();
            try {
                $sql = "UPDATE users SET assigned_project_id = :assigned_project_id where id = :user_id";
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("assigned_project_id" => $_GET["projectId"], "user_id" => $_SESSION["userId"]));
                http_response_code(200);
                echo json_encode(["message" => "Project added."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo json_encode(["message" => $exc->getMessage()]);
            }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп."]);
        }
?>