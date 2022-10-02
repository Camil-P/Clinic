<?php

$descriptionCM00006 = "CM00006: Add relation AppointmentPatient_fk";

$CM00006 = "ALTER TABLE `appointment` 
            ADD CONSTRAINT `AppointmentPatient_fk` 
            FOREIGN KEY (`PatientId`) 
            REFERENCES `patient`(`Id`) 
            ON DELETE RESTRICT 
            ON UPDATE RESTRICT;";
