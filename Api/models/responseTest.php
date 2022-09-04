<?php

require_once('Response.php');

$response = new Response();

$response->setSuccess(true);
$response->setHttpStatusCode(200);
$response->addMessage("test message 1");
$response->addMessage("test message 2");

$response->send();