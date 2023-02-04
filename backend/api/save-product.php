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
        $adminRoleId = getUserRole($db->getConnection());
        if ($adminRoleId === $_SESSION["user"]["role_id"]) {
            $project_id = $_GET["project_id"];
            if (isset($project_id)) {
        
            $db = new 
            $connection = 
        
            $sql = "SELECT * FROM products where id  = ?";
            $connection -> prepare($sql);
            $statement -> execute(["project_id" => $project_id]); //map
            // sql injection vulnerable - $statement = $connection -> query($sql);
            $products = $statement->fetchAll();
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