<?php
    session_start();

    if(isset($_SESSION["user"])) {
        $db = new DB();
        $connection = $db->getConnection();
        $project_id = $_GET["project_id"];
        if (isset($project_id)) {
            $sql = "SELECT * FROM projects where id = ?";
            try {
                $connection -> prepare($sql);
                $statement -> execute(["project_id" => $project_id]);
                $project = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
                http_response_code(200);
                echo json_encode($project);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo ["message" => "Грешка при взимане на проект."];
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "id е празно"]);
        }
       
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Невалидни права за достъп"]);
    }

?>