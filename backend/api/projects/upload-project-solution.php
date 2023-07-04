<?php
require '../../../vendor/autoload.php';
require_once("../../db/db.php");
session_start();
use Aws\S3\S3Client;

if(isset($_SESSION["userId"]) && isset($_SESSION["userRoleId"])) {
    $filename = $_FILES["files"]["tmp_name"][0];
    $filesize = $_FILES["files"]["size"];
    if(isset($_FILES['files']) && !empty($filename) && $filesize > 0) //{
    $s3Client = new S3Client([
        'version' => 'latest',
        'region'  => 'eu-central-1',
    ]);
        $project_id = $_POST["projectId"];
        // Check if file was uploaded without errors
            $allowed = array("zip" => "file/zip", "rar" => "file/rar");
            // $filetype = $_FILES["anyfile"]["type"];
            // Validate file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)){
                http_response_code(400);
                echo json_encode(["message" => "Error: Please select a valid file format. Allowed formats: zip, rar"]);
            }
            // Validate file size - 10MB maximum
            $maxsize = 10 * 1024 * 1024;
            if($filesize > $maxsize) {
                http_response_code(400);
                echo json_encode(["message" => "Error: Maximum file size is 10 MB"]);
            }
            //Validate type of the file
            if(in_array($filetype, $allowed)) {
            // Check whether file exists before uploading it
                // if(file_exists("upload/" . $filename)) {
                //     echo $filename . " is already exists.";
                // } else {
                //     if(move_uploaded_file($_FILES["anyfile"]["tmp_name"], "upload/" . $filename)) {
                        $bucket = 'projects-functional-requirements';
                        //$file_Path = __DIR__ . '/upload/'. $filename;
                        // try {
                            $result = $s3Client->putObject([
                                'Bucket' => $bucket,
                                'Key'    => $project_id . $filename,
                                'SourceFile'   => 'get-project.php',
                                'ACL'    => 'public-read', // make file 'public'
                            ]);
                        //     echo $result;
                        // }
//                            $file_url_in_s3 = $result->get('ObjectURL');
                //             // save S3 URL to database
                             //echo "File uploaded successfully. File path is: ";//. $file_url_in_s3;
                //             // $db = new DB();
                //             // $connection = $db->getConnection();
                //             // $sql = "UPDATE projects SET solution_s3_url=:solution_s3_url where id = :project_id";
                //             // $statement = $connection -> prepare($sql);
                //             // $statement -> execute(array("solution_s3_url" => $file_url_in_s3, "project_id" => $project_id));
                //             // $statement->fetchAll();
                //             http_response_code(200);
                //             echo json_encode(["message" => "File" . $file_url_in_s3 . "saved successfully"]);
                //         } catch (Aws\S3\Exception\S3Exception $e) {
                //             echo "There was an error uploading the file.\n";
                //             echo $e->getMessage();
                //         }
                //         echo "Your file was uploaded successfully.";
                //     } else {
                //         echo "File is not uploaded";
                //     }
                }
                http_response_code(200);
                echo json_encode(["message" => "great, ". $project_id, " files: " => $_FILES]);
        //     } else {
        //         http_response_code(418)
        //         echo "Error: There was a problem uploading your file. Please try again."; 
        //     }
        // } else {
        //     http_response_code(502);
        //     echo "Error: " . $_FILES["files"]["error"];
        // }
    //}
}
?>