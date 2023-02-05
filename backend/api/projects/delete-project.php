<?php
    require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["user"])){
        $db = new DB();
        $connection = $db->getConnection();
        if (isAdmin($_SESSION["user"]["role_id"])) {
            $project_id = $_DELETE["id"];
            try{
                $sql = "DELETE FROM projects WHERE id = ?";
                $statement = $connection -> prepare($sql);
                $statement -> execute($project_id);
                http_response_code(201);
                echo json_encode(["message" => "Проектът е изтрит успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo ["message" => "Грешка при изтриване на проект."];
            }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
    } else {
        http_response_code(401);
    }
?>