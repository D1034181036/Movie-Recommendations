<?php

class DBConnection {
    protected $con;

    public function __construct() {
        try {
            $DB_HOST = constant('DB_HOST');
            $DB_NAME = constant('DB_NAME');
            $DB_USERNAME = constant('DB_USERNAME');
            $DB_PASSWORD = constant('DB_PASSWORD');

            $this->con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USERNAME, $DB_PASSWORD);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $this->con->exec("SET NAMES UTF8");
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->con;
    }
}