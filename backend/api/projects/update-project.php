<?php
    require_once("../../db/db.php");
    require_once("../../db/is-admin.php");
    session_start();

    if(isset($_SESSION["user"])){
        $db = new DB();
        $adminCheck = new AdminCheck();
        $connection = $db->getConnection();
        if ($adminCheck->isAdmin($_SESSION["user"]["role_id"])) {
            $projectData = json_decode(file_get_contents("php://input"), true); 
            try{
                $sql = "UPDATE projects SET name=?, number=?, description=? where id = ?";
                $statement = $connection -> prepare($sql);
                $statement -> execute([$projectData["name"], $projectData["number"], $projectData["description"], $projectData["id"]]);
                http_response_code(201);
                echo json_encode(["message" => "Проектът е променен успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo ["message" => "Грешка при запазване на проект."];
            }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
    } else {
        http_response_code(401);
    }
?>