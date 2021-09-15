<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../config/Database.php';
    include_once '../models/Stroj1.php';

    $request_method = $_SERVER["REQUEST_METHOD"];

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate stroj1 object
    $stroj1 = new Stroj1($db);

    switch($request_method)
    {
        case 'GET':
            // Stroj1 query 

            // If id is set, pass id to function and retrieve only that data
            if(!empty($_GET["id"]))
            {
                $id = $_GET["id"];
                $result = $stroj1->get($id);
            }
            // else, if id is not set, retrieve all data
            else {
                $result = $stroj1->get();
            }
            // Get row count
            $numRows = $result->rowCount();

            // Check for data
            if($numRows > 0) {
                // Stroj1 array
                $stroj1_arr = array();

                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $stroj1_item = array(
                        'idmjerenja' => $idmjerenja,
                        'vibr'       => $vibr,
                        'avibr'      => $avibr,
                        'temper'     => $temper
                    );

                    // Push to array
                    array_push($stroj1_arr, $stroj1_item);
                }

                // Turn to JSON & output
                echo json_encode($stroj1_arr);
            }
            else {
                // No data
                echo json_encode(
                    array('messagee' => 'No data found for Stroj1')
                );
            }
            break;
        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode("Sorry, but only method allowed is GET :(");
            break;
    }