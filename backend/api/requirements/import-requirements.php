<?php 
require_once("../../db/db.php");
session_start();

$filename = $_FILES["files"]["tmp_name"][0];
if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
if(isset($_FILES['files']) && !empty($filename)) {
        if($_FILES["files"]["size"] > 0) {
            $file = fopen($filename, "r");
            $db = new DB();
            $connection = $db->getConnection();
	        while (($reqData = fgetcsv($file, 10000, ",")) !== FALSE) {
				if(!isset($reqData["name"]) || $reqData["name"] == "" ||
            !isset($reqData["projectId"]) || $reqData["projectId"] == "" ||
            !isset($reqData["priority"]) || $reqData["priority"] == "" ||
            !isset($reqData["layer"]) || $reqData["layer"] == "" ||
            !isset($reqData["story"]) || $reqData["description"] == "" ||
            !isset($reqData["tags"]) || $reqData["tags"] == "" ||
            !isset($reqData["type"]) || $reqData["type"] == "") {
                http_response_code(400);
            }
                $sql = "INSERT INTO requirements (name, project_id, priority, layer, story, description, tags, type) VALUES (:name, :project_id, :priority, :layer, :story, :description, :tags, :type)";
                $statement = $connection -> prepare($sql);
                $statement -> execute(array("name" => $reqData[0], "priority" => $reqData[1], "layer" => $reqData[2],  "story" => $reqData[3], "description" => $reqData[4], "tags" => $reqData[5], "type" => $reqData[6], "project_id" => $_GET["projectId"]));
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