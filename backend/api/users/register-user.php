<?php

    require_once("./db/product-db.php");

    function validateUserData($user_data) {
        if (!isset($userData["username"]) 
            || !isset($userData["username"])
            || !isset($userData["password"])) {
                return [
                    "isValid" => false,
                    "message" => "Невалидни данни"
                ];
        }

        $emailRegex = "/^[a-z_]+@[a-z]+.[a-z]+$/";
        $isEmailValid = preg_match($emailRegex, $userData["email"]);
        if(!$isEmailValid) {
            return [
                "isValid" => false,
                "message" => "Невалиден email"
            ];
        }
        return [
            "isValid" => true
        ];
    }

    function getUserRole (PDO $connection) {
        $sql = "SELECT id FROM roles WHERE name='client'";
        $statement = $connection->query($sql);

        $rows = $statement -> fetchAll();
        return $rows[0]["id"];
    }

    $userData = json_decode(file_get_contents("php://input"), true);

    //validation
    if (isset($userData) && $userData) {

        $valid = validateUserData($userData);
        if ($valid["isValid"]) {
            http_response_code(400);
            exit([
                "message" => $valid["message"]
            ]);
        }

        try {
            $db = new DB();
            $connection = $db->getConnection();
            $userRoleId = getUserRole($connection);
            $passwordHash = password_hash($userData["password"], PASSWORD_DEFAULT);


            $sqlInsert = "INSERT INTO users (username, email, role_id, password) VALUES (?, ?, ?, ?)";
            $statement = $connection->prepare($sql);
            $statement -> execute([$userData["username"], $userData["email"], $userRoleId, $passwordHash]);
            http_response_code(201); //201 created
            echo json_encode([
                "message" => "Регистрацията е успешна"
            ]);

        } catch (PDOException $ex) {
            //if($ex["message"] e neshto si) - http 409 conflict, user exists
            http_response_code(500);
            echo json_encode(["message" => "Неуспешна регистрация"]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "message" => "Невалидни данни"
        ]);
    }
    echo json_encode($userData);


    
?>