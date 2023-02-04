<?php
    session_start();

    if(isset($_SESSION["user"])) {
        http_response_code(200)
        echo json_encode([]);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Невалидни права за достъп"]);
    }

?>