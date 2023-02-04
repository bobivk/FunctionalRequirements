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
           $projectData = json_decode(file_get_contents("php://input"), true); 
           $sql = "INSERT INTO projects (name, number, description) VALUES (?, ?, ?)";
           $statement = $connection -> prepare($sql);
           $statement -> execute([$projectData["name"], $projectData["number"], $projectData["description"]]);
           http_response_code(201);
           echo json_encode(["message" => "Проектът е добавен успешно."]);
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
    } else {
        http_response_code(401);
    }
?>