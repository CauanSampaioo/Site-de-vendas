<?php
/**
 * Classe Database - Gerencia conexão com o banco de dados
 * Padrão: Singleton
 */
class Database
{
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'gametech';
    
    private function __construct()
    {
        $this->connect();
    }
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function connect()
    {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
        
        if ($this->connection->connect_error) {
            die("Erro na conexão: " . $this->connection->connect_error);
        }
        
        $this->connection->set_charset("utf8mb4");
    }
    
    public function getConnection()
    {
        return $this->connection;
    }
    
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }
    
    public function __clone() {}
    
    public function __wakeup() {}
}
?>
