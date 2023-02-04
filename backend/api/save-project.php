<?php


    function getUserRole (PDO $connection) {
        $sql = "SELECT id FROM roles WHERE title='admin'";
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
            $project_id = $_GET["project_id"];
            if (isset($project_id)) {
                $sql = "SELECT * FROM projects where id  = ?";
                $connection -> prepare($sql);
                $statement -> execute(["project_id" => $project_id]); //map
                $projects = $statement->fetchAll();
            }
        //    while($rpow = $statement -> fetch()) { }        
        } else {
            http_response_code(403);
            echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
        }
    } else {
        http_response_code(401);
    }
?>