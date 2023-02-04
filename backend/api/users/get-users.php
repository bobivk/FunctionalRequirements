<?php
    session_start();

        try{
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT username, email FROM users";
            $connection -> prepare($sql);
            $statement -> execute();     
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exc) {
            http_response_code(500);
            echo ["message" => $exc->getMessage()];
        }
        http_response_code(200);
        echo json_encode($rows);


?>