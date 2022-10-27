<?php

$descriptionCM00015 = "Created MessageDocotrId_fk relation";

$CM00015 = "ALTER TABLE `message` 
            ADD CONSTRAINT `MessageDoctorId_fk` 
            FOREIGN KEY (`DoctorId`) 
            REFERENCES `user`(`Id`) 
            ON DELETE RESTRICT 
            ON UPDATE RESTRICT;";