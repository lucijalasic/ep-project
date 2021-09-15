<?php 
    class Stroj1 {
        // DB attributes
        private $connection;
        private $table = 'stroj1';

        // GET Properties
        public $idmjerenja;
        public $vibr;
        public $avibr;
        public $temper;

        // Constructor with DB
        public function __construct($db) {
            $this->connection = $db;
        }

        // Get data

        public function get( $id=0 ) {
            // Create query
            if($id != 0) {
                $query = 'SELECT
                    s.idmjerenja,
                    s.vibr,
                    s.avibr,
                    s.temper
                FROM
                    ' . $this->table .' s
                WHERE s.idmjerenja=' . $id . ' LIMIT 1';
            }
            else {
                $query = 'SELECT
                    s.idmjerenja,
                    s.vibr,
                    s.avibr,
                    s.temper
                FROM
                    ' . $this->table .' s
                ORDER BY 
                    s.idmjerenja DESC';
            }
            
            // Prepare statement
            $stmt = $this->connection->prepare($query);

            // Execute statement
            $stmt->execute();

            return $stmt;
        }
    }