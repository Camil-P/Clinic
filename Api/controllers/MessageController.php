<?php

require_once("../config/Database.php");
require_once("../models/Message.php");
require_once("../models/Response.php");
require_once("../config/Auth.php");

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

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    $response = new Response(true, 200);
    $response->send();
    exit();
}

// AUTH

$authorizedUser = authorize($writeDB);

if (empty($_GET)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            $response = new Response(false, 400);
            $response->addMessage("Content type header is not set to JSON");
            $response->send();
            exit();
        }

        try {

            $rawPOSTData = file_get_contents('php://input');
            $jsonData = json_decode($rawPOSTData);
            if (!$jsonData) {
                $response = new Response(false, 400);
                $response->addMessage("Request body is not valid");
                $response->send();
                exit();
            }

            if ($authorizedUser['role'] === 'Patient') {
                $jsonData = (array)$jsonData;
                $jsonData['patientId'] = $authorizedUser['id'];
                $jsonData = (object)$jsonData;
            } else {
                $jsonData = (array)$jsonData;
                $jsonData['doctorId'] = $authorizedUser['id'];
                $jsonData = (object)$jsonData;
            }

            $query = $writeDB->prepare("INSERT INTO message (
                                            PatientId,
                                            DoctorId,
                                            Content
                                        ) 
                                        values (
                                            :patientId,
                                            :doctorId,
                                            :content);");
                                        //     $jsonData->patientId,
                                        //     $jsonData->doctorId,
                                        //    '$jsonData->content');");
            $query->bindParam(':patientId', $jsonData->patientId, PDO::PARAM_INT);
            $query->bindParam(':doctorId', $jsonData->doctorId, PDO::PARAM_INT);
            $query->bindParam(':content', $jsonData->content, PDO::PARAM_STR);
            $query->execute();

            $rowCount = $query->rowCount();
            if ($rowCount === 0) {
                $response = new Response(false, 500);
                $response->addMessage("Message was not created. Please try again");
                $response->send();
                exit();
            }

            $lastMessageCreated = $writeDB->lastInsertId();
            
            $jsonData = (array)$jsonData;
            $jsonData['id'] = $lastMessageCreated;

            $response = new Response(true, 201);
            $response->addMessage("Successfully created Message");
            $response->setData($jsonData);
            $response->send();
            exit();
        } catch (PDOException $ex) {
            $response = new Response(false, 500);
            $response->addMessage("There was a problem with creating a message in DB: " . $ex->getMessage());
            $response->send();

            error_log("DB error: " . $ex->getMessage(), 0);
            exit();
        }
    }
}
elseif(array_key_exists('id', $_GET) && ($_SERVER['REQUEST_METHOD'] === 'GET')){

    if ($authorizedUser['role'] === 'Patient') {
        $doctorId = $_GET['id'];
        $query = $writeDB->prepare("SELECT * 
                                    FROM message 
                                    WHERE DoctorId = $doctorId;");
    } else {
        $patientId = $_GET['id'];
        $query = $writeDB->prepare("SELECT * 
                                    FROM message 
                                    WHERE PatientId = $patientId;");
    }

    $query->execute();

    $rowCount = $query->rowCount();
    if ($rowCount === 0) {
        $response = new Response(false, 500);
        $response->addMessage("Unable to get messages for the provided id.");
        $response->send();
        exit();
    }

    $messageArray = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $message = array();
        $message['Id'] = $row['Id'];
        $message['Content'] = $row['Content'];
        $message['PatientId'] = $row['PatientId'];
        $message['DoctorId'] = $row['DoctorId'];
        $messageArray[] = $message;
    }

    $response = new Response(true, 200);
    $response->addMessage("Successfully fetched messages");
    $response->setData($messageArray);
    $response->send();
    exit();
}
 else {
    $response = new Response(false, 404);
    $response->addMessage("Request unknown.");
    $response->send();
    exit();
}