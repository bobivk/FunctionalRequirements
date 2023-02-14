<?php 
//session_start();
require_once("../../db/db.php");
 
/**
    * Check if CSV File has been sent successfully otherwise return error
    */
var_dump(["FILES" => $_FILES['files']]);
if(isset($_FILES['files']) && !empty($_FILES['files']['tmp_name'])){
 
    // Read CSV File
    $csv_file = fopen($_FILES['tmp_name'], "r"); 
    var_dump($csv_file);
    // Row Iteration
    $rowCount = 0;
 
    //Data to insert for batch insertion
    $data = [];

    $db = new DB();
    $connection = $db->getConnection();
 
    // Read CSV Data by row
    while(($row = fgetcsv($csv_file, 1000, ",")) !== FALSE){
        if($rowCount > 0){
            //Sanitizing Data
            $number = addslashes($connection->real_escape_string($row[0]));
            $name = addslashes($connection->real_escape_string($row[1]));
            $description = addslashes($connection->real_escape_string($row[2]));
            $status = addslashes($connection->real_escape_string($row[3]));
 
            // Add Row data to insert value
            $data[] =  "('{$number}', '{$name}', '{$description}', '{$status})";
        }
        $rowCount++;
    }
 
    // Close the CSV File
    fclose($csv_file);
 
    /**
        * Check if there's data to insert otherwise return error
        */
    if(count($data) > 0) {
        // Convert Data values from array to string w/ comma seperator
        $insert_values = implode(", ", $data);
        var_dump(["insert values" => $insert_values]);
 
        //MySQL INSERT Statement
        $insert_sql = "INSERT INTO projects (number, name, description, status) VALUES {$insert_values}";
 
        var_dump(["insert sql" => $insert_sql]);
        // $sql = "INSERT INTO projects (name, number, description, status) VALUES (:name, :number, :description, :status)";
        // $statement = $connection -> prepare($sql);
        // $statement -> execute(array("name" => $projectData["name"], "number" => $projectData["number"], "description" => $projectData["description"], "status" => $projectData["status"]));

        // Execute Insertion
        //$connection->prepare
        $insert = $connection->query($insert_sql);
 
        if($insert){
            // Data Insertion is successful
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Data has been imported succesfully.';
        }else{
            // Data Insertion has failed
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Import Failed! Error: '. $connection->error;
        }
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'CSV File Data is empty.';
    }
 
}else{
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'CSV File Data is missing.';
}
 
?>