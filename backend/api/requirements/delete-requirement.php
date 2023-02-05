<?php
require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["user"])){
        $db = new DB();
        $connection = $db->getConnection();
        if (isAdmin($_SESSION["user"]["role_id"])) {
            $requirementId = $_DELETE["id"];
            try {
                $sql = "DELETE FROM requirements WHERE id = ?";
                $statement = $connection -> prepare($sql);
                $statement -> execute($requirementId);
                http_response_code(201);
                echo json_encode(["message" => "Проектът е изтрит успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo ["message" => "Грешка при изтриване на изискване."];
            }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
    } else {
        http_response_code(401);
    }
?>