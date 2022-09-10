<?php

require_once('Response.php');
require_once('Appointment.php');
date_default_timezone_set('Europe/Belgrade');

$response = new Response(true, 200);
try {
    $appointment = new Appointment(1232, "lezanje", "2021-09-05", "7", 1, 1);
    $response->setData($appointment->asArray());
    $response->send();
} catch (Throwable $th) {
    echo $th->getMessage();
}
