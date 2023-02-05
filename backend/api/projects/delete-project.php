<?php
    require_once("../../db/db.php");
    //require_once("../users/is-admin.php");
    session_start();

    //if(isset($_SESSION["user"])){
        $db = new DB();
        //$adminCheck = new AdminCheck();
        $connection = $db->getConnection();
        //if ($adminCheck->isAdmin($_SESSION["user"]["role_id"])) {
            $project_id = $_GET["id"];
            try {
                $sql = "DELETE FROM projects WHERE id = :id";
                $statement = $connection -> prepare($sql);
                $statement -> execute(["id" => $project_id]);
                http_response_code(204);
                echo json_encode(["message" => "Проектът е изтрит успешно."]);
                //delete requirements for this project first
            } catch(PDOException $exc) {
                http_response_code(500);
                echo json_encode($exc->getMessage());
            }
    //     } else {
    //         http_response_code(403);
    //         echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
    //     }
    // } else {
    //     http_response_code(401);
    // }
?>