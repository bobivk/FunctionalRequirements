<?php
require_once("../../db/db.php");
    session_start();

    if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
        $db = new DB();
        $connection = $db->getConnection();
            $reqData = json_decode(file_get_contents("php://input"), true);
            if(!isset($reqData["name"]) || $reqData["name"] == "" ||
            !isset($reqData["projectId"]) || $reqData["projectId"] == "" ||
            !isset($reqData["priority"]) || $reqData["priority"] == "" ||
            !isset($reqData["layer"]) || $reqData["layer"] == "" ||
            !isset($reqData["story"]) || $reqData["description"] == "" ||
            !isset($reqData["tags"]) || $reqData["tags"] == "" ||
            !isset($reqData["type"]) || $reqData["type"] == "") {
                http_response_code(400);
                echo json_encode(["message" => "One or more empty required fields."]);
            }
            $sql = "INSERT INTO requirements (name, project_id, priority, layer, story, description, tags, type) VALUES
                (:name, :project_id, :priority, :layer, :story, :description, :tags, :type)";
            try {
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("name" => $reqData["name"], "project_id"=> $reqData["project_id"], "priority" => $reqData["priority"], "layer" => $reqData["layer"],
                    "story" => $reqData["story"], "description" => $reqData["description"], "tags" => $reqData["tags"], "type" => $reqData["type"]));
                http_response_code(201);
                echo json_encode(["message" => "Изискването е добавено успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo json_encode(["message" => $exc->getMessage()]);
            }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
?>