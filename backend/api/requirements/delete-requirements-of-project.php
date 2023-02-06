<?php
require_once("../../db/db.php");
    session_start();

    //if(isset($_SESSION["user"])){
        $db = new DB();
        //$adminCheck = new AdminCheck();
        $connection = $db->getConnection();
        //if ($adminCheck->isAdmin($_SESSION["user"]["role_id"])) {
            $projectId = $_GET["projectId"];
            try {
                $sql = "DELETE FROM requirements WHERE project_id = :project_id";
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("project_id" => $projectId));
                http_response_code(201);
                echo json_encode(["message" => "Проектът е изтрит успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo json_encode(["message" => $exc->getMessage()]);
            }
    //     } else {
    //         http_response_code(403);
    //         echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
    //     }
    // } else {
    //     http_response_code(401);
    // }
?>