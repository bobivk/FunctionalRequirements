<?php
require_once("../../db/db.php");
    session_start();
    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
    $project_id = $_GET["projectId"];
        try {
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT * FROM requirements WHERE project_id = :project_id";
            $statement = $connection -> prepare($sql);
            $statement -> execute(array("project_id" => $project_id));
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exc) {
            http_response_code(500);
            echo json_encode(["message" => $exc->getMessage()]);
        }
        http_response_code(200);
        echo json_encode($rows);
    } else {
        http_response_code(403);
        echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
    }
?>