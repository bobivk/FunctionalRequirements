<?php
require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"]) && $_SESSION["userRoleId"] == 1) {
        $db = new DB();
        $connection = $db->getConnection();
            $projectId = $_GET["projectId"];
            try {
                $sql = "DELETE FROM requirements WHERE project_id = :project_id";
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("project_id" => $projectId));
                http_response_code(201);
                echo json_encode(["message" => "Проектът е изтрит успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo json_encode(["message" => $exc->getMessage()]);
            }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
?>