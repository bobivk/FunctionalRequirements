<?php
require_once("../../db/db.php");
    session_start();
        try {
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT COUNT(*) FROM requirements where type= :type";
            $statement = $connection -> prepare($sql);
            $statement -> execute(array("type" => $_GET["type"]));
            $count = $statement->fetchColumn();
        } catch(PDOException $exc) {
            http_response_code(500);
            echo ["message" => $exc->getMessage()];
        }
        http_response_code(200);
        echo json_encode($count);
?>