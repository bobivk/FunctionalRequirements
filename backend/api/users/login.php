<?php
    require_once("../db/db.php");

    function login($userData) {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT * FROM users WHERE email = ?";
            $statement = $connection -> prepare($sql);
            $statement -> execute([$userData["email"]]);
            if($statement -> rowCount() === 1) {
                $user = $statement->fetchAll(PDO::FETCH_ASSOC)[0]; //fetch_assoc връща данните само като асоциативен списък, иначе дублира - асоциативен и индексиран
                $isPasswordValid = password_verify($userData["password"], $user["password"]);
                if($isPasswordValid){
                    return $user;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch(PDOException $exc) {
            http_response_code(500);
            echo ["message" => $exc->getMessage()];
        }
    }


    $userData = json_decode(file_get_contents("php://input"), true);

    if(isset($userData) && $userData && $userData["email"] && $userData["password"]) {
        try {
            $user = login($userData);

            if(!$user) {
                http_response_code(500);
                echo json_encode(["message" => "Грешка при вход"]);
            }
            session_start(); //създава session cookie
            $_SESSION["user"] = $user; //запазваме данните за потребителя в сесията, за да не трябва да се логва отново при следващи извиквания
            http_response_code(200);
            echo json_encode(["message" => "Входът е успешен"]);
        
        } catch (Error $ex) {
            http_response_code(500);
            echo json_encode(["message" => "Грешка при вход"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Невалидни данни"]);
    }

?>