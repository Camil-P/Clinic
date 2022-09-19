<?php

// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');

include_once('../config/Database.php');
include_once('../models/Response.php');
include_once('../models/User.php');
include_once('../requestModels/CreateUser.php');

try {
    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
} catch (PDOException $ex) {
    $response = new Response(false, 500);
    $response->addMessage("Database conn error.");
    $response->send();

    error_log("Connection error: " . $ex->getMessage(), 0);
    exit();
}

// ONLY POST IS ALLOWED

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response = new Response(false, 405);
    $response->addMessage("Method not allowed.");
    $response->send();
    exit();
}

if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
    $response = new Response(false, 400);
    $response->addMessage("Content type header not set to JSON.");
    $response->send();
    exit();
}

if (!$jsonData = json_decode(file_get_contents('php://input'))) {
    $response = new Response(false, 400);
    $response->addMessage("Request body is not valid JSON.");
    $response->send();
    exit();
}

try {
    $createUser = new CreateUser($writeDB,
                                 $jsonData->name,
                                 $jsonData->surname,
                                 $jsonData->gender,
                                 $jsonData->birthPlace,
                                 $jsonData->birthDate,
                                 $jsonData->jmbg,
                                 $jsonData->phoneNumber,
                                 $jsonData->email,
                                 $jsonData->password);

    

    
} catch (UserException $ex) {
    $response = new Response(false, 400);
    $response->addMessage($ex->getMessage());
    $response->send();
    exit();
}


