<?php
    require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
        try{
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT * FROM projects";
            $statement = $connection -> prepare($sql);
            $statement -> execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exc) {
            http_response_code(500);
            echo json_encode(["message" => $exc->getMessage()]);
        }
        http_response_code(200);
        echo json_encode($rows);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Невалидни права за достъп"]);
    }

?>