<?php

    class ValueValidation{
        public static function isValueEmpty($value){
            if (empty(trim($value)))
                return false;

            return true;
        }

        public static function doesValueMatchPattern($pattern, $value){
            if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($value)))
                return false;

            return true;
        }
    }