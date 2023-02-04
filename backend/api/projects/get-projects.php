<?php
    session_start();

    if(isset($_SESSION["user"])) {
        try{
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT * FROM projects";
            $connection -> prepare($sql);
            $statement -> execute();     
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exc) {
            http_response_code(500);
            echo ["message" => "Грешка при взимане на проекти."];
        }
        http_response_code(200);
        echo json_encode($rows);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Невалидни права за достъп"]);
    }

?>