<?php
require 'vendor/autoload.php';
require_once("../../db/db.php");
session_start();
use Aws\S3\S3Client;

if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
    // Instantiate an Amazon S3 client.
    $s3Client = new S3Client([
        'version' => 'latest',
        'region'  => 'eu-central-1'
    ]);
    $project_id = $_DELETE["projectId"];
    $get_s3_url_sql = "SELECT solution_s3_url FROM projects where id = :project_id";
    $get_statement = $connection -> prepare($get_s3_url_sql);
    $get_statement -> execute(array("project_id" => $project_id));
    $solution_s3_url = $get_statement->fetchAll(PDO::FETCH_ASSOC)[0];

    $bucket = 'projects-functional-requirements';

    $result = $s3Client->deleteObject(array(
        'Bucket' => $bucket,
        'Key'    => $project_id
    ));

    $delete_s3_url_sql = "UPDATE projects SET solution_s3_url = NULL WHERE id = :project_id";
    $update_statement = $connection -> prepare($delete_s3_url_sql);
    $get_statement -> execute(array("project_id" => $project_id));
    http_response_code(200);
    echo json_encode(["message" => "Файлът е премахнат успешно."]);
}
?>
