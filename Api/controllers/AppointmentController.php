<?php

require_once("../config/Database.php");
require_once("../models/Appointment.php");
require_once("../models/Response.php");

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

// Handle Get all Appointments by doctorId/patientId/servieName Request 
if (
    array_key_exists("doctorId", $_GET)
    && array_key_exists("patientId", $_GET)
    && array_key_exists("serviceName", $_GET)
) {

    $doctorId = $_GET["doctorId"];
    $patientId = $_GET["patientId"];
    $serviceName = $_GET["serviceName"];

    if (($doctorId == '' || !is_numeric($doctorId))
        && ($patientId == '' || !is_numeric($patientId))
        && !is_string($serviceName)
    ) {

        $response = new Response(false, 400);
        $response->addMessage("Query values are not valid");
        $response->send();
        exit();
    }
    try {
        $query = $readDB->prepare('SELECT
                                                Id,
                                                ServiceName,
                                                CompletionStatus,
                                                Date,
                                                StartingHour,
                                                PatientId,
                                                DoctorId
                                            FROM appointment
                                            WHERE 
                                                DoctorId = :doctorId 
                                                AND ServiceName = :serviceName 
                                                OR PatientId = :patientId');

        $query->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
        $query->bindParam(':patientId', $patientId, PDO::PARAM_INT);
        $query->bindParam(':serviceName', $serviceName, PDO::PARAM_STR);
        $query->execute();

        $rowCount = $query->rowCount();
        if ($rowCount === 0) {
            $response = new Response(false, 404);
            $response->addMessage("Appointments were not found.");
            $response->send();
            exit();
        }

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $appointment = new Appointment($row['Id'], $row["ServiceName"], $row['Date'], $row['StartingHour'], $row['PatientId'], $row['DoctorId']);
            $appointmentArray[] = $appointment->asArray();
        }

        $response = new Response(true, 200);
        $response->toCache(true);
        $response->setData($appointmentArray);
        $response->send();
        exit();
    } catch (AppointmentException $ex) {
        $response = new Response(false, 500);
        $response->addMessage($ex->getMessage());
        $response->send();
        exit();
    } catch (PDOException $ex) {
        $response = new Response(false, 500);
        $response->addMessage("Database conn error.");
        $response->send();

        error_log("Connection error: " . $ex->getMessage(), 0);
        exit();
    }
}

// Handle Methods that require appointmentId param
elseif (array_key_exists('appointmentId', $_GET)) {

    $appointmentId = $_GET['appointmentId'];
    if ($appointmentId == '' || !is_numeric($appointmentId)) {
        $response = new Response(false, 400);
        $response->addMessage('Param appointmentId is not valid');
        $response->send();
        exit();
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            try {
                $query = $readDB->prepare('SELECT
                                                Id,
                                                ServiceName,
                                                CompletionStatus,
                                                Date,
                                                StartingHour,
                                                PatientId,
                                                DoctorId
                                            FROM appointment
                                            WHERE 
                                                Id = :appointmentId;');

                $query->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
                $query->execute();

                $rowCount = $query->rowCount();
                if ($rowCount === 0) {
                    $response = new Response(false, 404);
                    $response->addMessage("Appointment was not found.");
                    $response->send();
                    exit();
                }

                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $appointment = new Appointment($row['Id'], $row["ServiceName"], $row['Date'], $row['StartingHour'], $row['PatientId'], $row['DoctorId']);
                    $appointmentArray = $appointment->asArray();
                }

                $response = new Response(true, 200);
                $response->toCache(true);
                $response->setData($appointmentArray);
                $response->send();
                exit();
            } catch (AppointmentException $ex) {
                $response = new Response(false, 500);
                $response->addMessage($ex->getMessage());
                $response->send();
                exit();
            } catch (PDOException $ex) {
                $response = new Response(false, 500);
                $response->addMessage("Database conn error.");
                $response->send();

                error_log("Connection error: " . $ex->getMessage(), 0);
                exit();
            }
            break;

        case "DELETE":

            break;

        case "PATCH":

            break;

        default:
            $response = new Response(false, 405);
            $response->addMessage("Request method is not allowed");
            $response->send();
            exit();
    }
}
