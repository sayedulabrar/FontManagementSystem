<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=fontdb', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
?>
