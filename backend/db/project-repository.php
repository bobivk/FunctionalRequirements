<?php
    $product_id = $_GET["product_id"];
    if (isset($product_id)) {


    $connection = new PDO('mysql:host=localhost:3307;dbname=store', 'root', '');

    $sql = "SELECT * FROM products where id  = ?";
    $connection -> prepare($sql);
    $statement -> execute(["product_id" => $product_id]); //map
    // sql injection vulnerable - $statement = $connection -> query($sql);
    $products = $statement->fetchAll();
    }
  

//    while($rpow = $statement -> fetch()) { }

?>