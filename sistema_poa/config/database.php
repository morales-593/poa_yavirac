<?php
class Database {
    public static function connect() {
        return new PDO(
            "mysql:host=localhost;dbname=poa_yavirac;charset=utf8mb4",
            "root",
            "",
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
}
