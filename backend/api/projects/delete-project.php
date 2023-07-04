<?php
    require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"]) && $_SESSION["userRoleId"] == 1) {
        $db = new DB();
        $connection = $db->getConnection();
            $project_id = $_GET["projectId"];
            try {
                $sql = "DELETE FROM projects WHERE id = :id";
                $statement = $connection -> prepare($sql);
                $statement -> execute(["id" => $project_id]);
                http_response_code(204);
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