<?php
require_once("../../db/db.php");
    session_start();
    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT COUNT(*) FROM requirements where type= :type";
            $statement = $connection -> prepare($sql);
            $statement -> execute(array("type" => $_GET["type"]));
            $count = $statement->fetchColumn();
        } catch(PDOException $exc) {
            http_response_code(500);
            echo json_encode(["message" => $exc->getMessage()]);
        }
        http_response_code(200);
        echo json_encode($count);
    } else {
        http_response_code(403);
        echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
    }
?>