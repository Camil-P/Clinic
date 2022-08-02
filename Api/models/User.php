<?php
    class User{
        private $conn;
        private $table = 'user';

        public $id;
        public $nameSurname;
        public $username;
        public $email;
        public $password;
        public $country;
        public $gender;
        public $phoneNumber;

        public function __constract($db) {
            $this->conn = $db;
        }
    }