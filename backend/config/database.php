<?php
class Database {
    // Credenciais do banco de dados
    private $host = "127.0.0.1";
    private $db_name = "simple_api_db";
    private $username = "root";
    private $password = "root_pass";
    public $conn;

    // Método para estabelecer a conexão com o banco de dados
    public function getConnection() {
        $this->conn = null;
        try {
            // Cria uma nova instância da classe PDO para a conexão
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            // Define o modo de erro para exceções
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }

        // Retorna a conexão
        return $this->conn;
    }
}
