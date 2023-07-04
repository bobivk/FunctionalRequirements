<?php
    class DB {
        private $connection;

        function __construct() {
            $this->connection = new PDO('mysql:host=projects-1.cbg9du0f4wts.eu-central-1.rds.amazonaws.com:3306;dbname=functionalrequirements', 'bobina', 'vitosha_0610');
        }

        public function getConnection() {
            return $this->connection;
        }
    }

?>