<?php

require_once('../config/Database.php');
require_once('../models/Response.php');

require_once('CM00001.php');
require_once('CM00002.php');

if ($_GET['username'] === 'clinic' && $_GET['password'] === 'clinic') {


    try {
        $writeDB = DB::connectWriteDB();
        $readDB = DB::connectReadDB();
        $response = new Response(true, 200);

        // Execute the above required migrations
        $stmt = $readDB->prepare($CM00001);
        $response->addMessage($descriptionCM00001);
        $stmt->execute();

        $stmt = $readDB->prepare($CM00002);
        $response->addMessage($descriptionCM00002);
        $stmt->execute();


        // Send response the migrations are valid
        $response->send();
    } catch (PDOException $ex) {
        $response = new Response(false, 500);
        $response->addMessage("Migration Error: " . $ex->getMessage());
        $response->send();

        error_log("Connection error: " . $ex->getMessage(), 0);
        exit();
    }
}
