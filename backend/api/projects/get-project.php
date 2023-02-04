<?php
    session_start();

    if(isset($_SESSION["user"])) {
        $db = new DB();
        $connection = $db->getConnection();
        $project_id = $_GET["project_id"];
        if (isset($project_id)) {
            $sql = "SELECT * FROM projects where id  = ?";
            $connection -> prepare($sql);
            $statement -> execute(["project_id" => $project_id]);
            $projects = $statement->fetchAll();
            http_response_code(200);
            echo json_encode([]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "id е празно"]);
        }
       
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Невалидни права за достъп"]);
    }

?>