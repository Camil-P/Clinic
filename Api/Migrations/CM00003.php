<?php

$descriptionCM00003 = "CM00003: Create Basic User table";

$CM00003 = "CREATE TABLE `user` (
                `Id` int(11) NOT NULL AUTO_INCREMENT,
                `Name` varchar(25) NOT NULL,
                `Surname` int(25) NOT NULL,
                `Gender` enum('Male','Female') NOT NULL,
                `BirthPlace` varchar(25) NOT NULL,
                `BirthDate` date NOT NULL,
                `JMBG` varchar(15) NOT NULL,
                `PhoneNumber` varchar(15) NOT NULL,
                `email` varchar(25) NOT NULL,
                `Role` enum('Admin','Doctor','Patient') NOT NULL DEFAULT 'Patient',
                `Password` varchar(255) NOT NULL,
                PRIMARY KEY (Id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
