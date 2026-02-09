<?php
/**
 * Classe Database - Protection contre SQL Injection avec requêtes préparées
 */
class Database {
    private static $instance = null;
    private $connection;

    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    // Constructeur privé (Singleton)
    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false
            ];
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            error_log("Erreur de connexion DB: " . $e->getMessage());
            die("Erreur de connexion à la base de données");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Obtenir la connexion PDO
    public function getConnection() {
        return $this->connection;
    }


    private function __clone() {}

    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
