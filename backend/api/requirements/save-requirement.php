<?php
    function getUserRole (PDO $connection) {
        $sql = "SELECT id FROM roles WHERE title = 'admin'";
        $statement = $connection->query($sql);
        $rows = $statement -> fetchAll();
        return $rows[0]["id"];
    }

    session_start();

    if(isset($_SESSION["user"])){
        $db = new DB();
        $connection = $db->getConnection();
        $adminRoleId = getUserRole($connection);
        if ($adminRoleId === $_SESSION["user"]["role_id"]) {
            $reqData = json_decode(file_get_contents("php://input"), true);
            $sql = "INSERT INTO requirements (name, project_id, priority, layer, story, description, tags) VALUES (?, ?, ?, ?, ?, ?, ?)";
            try {
                $statement = $connection -> prepare($sql);
                $statement -> execute([$reqData["name"], $reqData["project_id"], $reqData["priority"], $reqData["layer"], 
                                        $reqData["story"], $reqData["description"], $reqData["tags"]]);
                http_response_code(201);
                echo json_encode(["message" => "Изискването е добавено успешно."]);
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