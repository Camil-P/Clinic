<?php

$descriptionCM00010 = "CM00010: Add relation AppointmentDoctor_fk";

$CM00010 = "ALTER TABLE `patient`
            ADD CONSTRAINT `PatientDoctor_pk`
            FOREIGN KEY (`DoctorId`)
            REFERENCES `user`(`Id`)
            ON DELETE RESTRICT
            ON UPDATE RESTRICT;";
