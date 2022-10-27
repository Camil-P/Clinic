<?php

$descriptionCM00014 = "Created MessagePatientId_fk relation";

$CM00014 = "ALTER TABLE `message` 
            ADD CONSTRAINT `MessagePatientId_fk` 
            FOREIGN KEY (`PatientId`) 
            REFERENCES `user`(`Id`) 
            ON DELETE RESTRICT 
            ON UPDATE RESTRICT;";