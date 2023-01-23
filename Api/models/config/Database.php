<?php

class DB
{
    private static $writeDBConnection;
    private static $readDBConnection;

    public static function connectWriteDB()
    {
        if (self::$writeDBConnection === null) {
            self::$writeDBConnection = new PDO('mysql:host=localhost;dbname=u907277441_clinic;utf8', 'u907277441_clinicwetrust', 'Clinicwetrust123');
            self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return self::$writeDBConnection;
    }

    public static function connectReadDB()
    {
        if (self::$readDBConnection === null) {
            self::$readDBConnection = new PDO('mysql:host=localhost;dbname=u907277441_clinic;utf8', 'u907277441_clinicwetrust', 'Clinicwetrust123');
            self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return self::$readDBConnection;
    }
}
