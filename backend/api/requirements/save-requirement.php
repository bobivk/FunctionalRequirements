<?php
require_once("../../db/db.php");
    session_start();

    // if(isset($_SESSION["user"])){
        $db = new DB();
        $connection = $db->getConnection();
        //if (isAdmin($_SESSION["user"]["role_id"])) {
            $reqData = json_decode(file_get_contents("php://input"), true);
            $sql = "INSERT INTO requirements (name, project_id, priority, layer, story, description, tags) VALUES
                (:name, :project_id, :priority, :layer, :story, :description, :tags)";
            try {
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("name" => $reqData["name"], "project_id"=> $reqData["project_id"] "priority" => $reqData["priority"],"layer" => $reqData["layer"],
                    "story" => $reqData["story"],"description" => $reqData["description"],"tags" => $reqData["tags"],"id" => $reqData["id"]));
                http_response_code(201);
                echo json_encode(["message" => "Изискването е добавено успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo ["message" => $exc->getMessage()];
            }
    //     } else {
    //         http_response_code(403);
    //         echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
    //     }
    // } else {
    //     http_response_code(401);
    // }
?>