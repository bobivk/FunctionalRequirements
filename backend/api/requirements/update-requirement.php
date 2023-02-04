<?php
    session_start();

    if(isset($_SESSION["user"])){
        $db = new DB();
        $connection = $db->getConnection();
        if (isAdmin($_SESSION["user"]["role_id"])) {
            $reqData = json_decode(file_get_contents("php://input"), true);
            $sql = "UPDATE requirements SET name=?, priority=?, layer=?, story=?, description=?, tags=? WHERE id=?";
            try {
                $statement = $connection -> prepare($sql);
                $statement -> execute([$reqData["name"], $reqData["priority"], $reqData["layer"], $reqData["story"], 
                                         $reqData["description"], $reqData["tags"], $reqData["id"]]);
                http_response_code(201);
                echo json_encode(["message" => "Изискването е променено успешно."]);
            } catch(PDOException $exc) {
                http_response_code(500);
                echo ["message" => $exc->getMessage()];
            }
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
    } else {
        http_response_code(401);
    }
?>