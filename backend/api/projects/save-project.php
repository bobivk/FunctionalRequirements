<?php
    session_start();

    if(isset($_SESSION["user"])){
        $db = new DB();
        $connection = $db->getConnection();
        if (isAdmin($_SESSION["user"]["role_id"])) {
            $projectData = json_decode(file_get_contents("php://input"), true); 
            try{
                $sql = "INSERT INTO projects (name, number, description) VALUES (?, ?, ?)";
                $statement = $connection -> prepare($sql);
                $statement -> execute([$projectData["name"], $projectData["number"], $projectData["description"]]);
                http_response_code(201);
                echo json_encode(["message" => "Проектът е добавен успешно."]);
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