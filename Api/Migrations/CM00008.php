<?php

$descriptionCM00006 = "CM00006: Add relation PatientUser_pk";

$CM00006 = "ALTER TABLE `patient` 
            ADD CONSTRAINT `PatientUser_pk` 
            FOREIGN KEY (`UserId`) 
            REFERENCES `user`(`Id`) 
            ON DELETE RESTRICT
            ON UPDATE RESTRICT;";
