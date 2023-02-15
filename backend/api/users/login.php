<?php
    require_once("../../db/db.php");
    session_start(); //създава session cookie
    $userInput = json_decode(file_get_contents("php://input"), true);
    if(isset($userInput) && isset($userInput["email"]) && isset($userInput["password"])) {
        try {
            $user = login($userInput);
            if(!isset($user)) {
                http_response_code(404);
                echo json_encode(["message" => "No user found with the credentials."]);
             } else {
                $_SESSION["username"] = $user["username"];
                $_SESSION["userId"] = $user["id"];
                $_SESSION["userRoleId"] = $user["role_id"];
            http_response_code(200);
        }
        } catch (Error $ex) {
            http_response_code(500);
            echo json_encode(["message" => $ex->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid data"]);
    }

    function login($userInput) {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            $sql = "SELECT * FROM users WHERE email = :email";
            $statement = $connection -> prepare($sql);
            $statement -> execute(array("email" => $userInput["email"]));
            if($statement -> rowCount() === 1) {
                $userFromDb = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
                $passwordFromDb = $userFromDb["password"];
                $inputPassword = $userInput["password"];
                $isPasswordValid = password_verify($inputPassword, $passwordFromDb);
                if($isPasswordValid) {           
                    return $userFromDb;
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
?>