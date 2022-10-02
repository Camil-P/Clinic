<?php

$descriptionCM00005 = "CM00005: Create session table";

$CM00005 = "CREATE TABLE `clinic`.`session` ( 
                `Id` INT NOT NULL AUTO_INCREMENT, 
                `UserId` INT NOT NULL, 
                `AccessToken` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
                `AccessTokenExpiry` DATETIME NOT NULL,
                `RefreshToken` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
                `RefreshTokenExpiry` DATETIME NOT NULL,
                PRIMARY KEY (`Id`),
                UNIQUE (`AccessToken`),
                UNIQUE (`RefreshToken`)
            )
            ENGINE = InnoDB;";
