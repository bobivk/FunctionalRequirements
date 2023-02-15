<?php 
require_once("../../db/db.php");
session_start();

$filename = $_FILES["files"]["tmp_name"][0];
if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"]) && $_SESSION["userRoleId"] == 1) {
if(isset($_FILES['files']) && !empty($filename)) {
        if($_FILES["files"]["size"] > 0) {
            $file = fopen($filename, "r");
            $db = new DB();
            $connection = $db->getConnection();
	        while (($projectData = fgetcsv($file, 10000, ",")) !== FALSE) {
				if(!isset($projectData["name"]) || $projectData["name"] == "" ||
                    !isset($projectData["number"]) || $projectData["number"] <= 0 ||
                    !isset($projectData["description"]) || $projectData["description"] == "" ||
                    !isset($projectData["projectId"]) || $projectData["projectId"] == "" ||
                    !isset($projectData["status"]) || $projectData["status"] == "") {
                        http_response_code(400);
                }
                $sql = "INSERT INTO projects (name, number, description, status) VALUES (:name, :number, :description, :status)";
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("number" => $projectData[0], "name" => $projectData[1], "description" => $projectData[2], "status" => $projectData[3]));
		        $result = $statement->fetchAll();
                if(!isset($result)) {
					http_response_code(400);
		        } else {
					http_response_code(200);
				}
	        }
	        fclose($file);
	}
}
} else {
	http_response_code(403);
	echo json_encode(["message" => "Невалидни права за достъп - потребителят не е администратор"]);
}
?>