<?php
class User {
    private $conn;
    public $id;
    public $name;
    public $email;
    public $password;

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para verificar se o e-mail já existe no banco de dado
    public function emailExists(): bool {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $this->email]);
        return $stmt->rowCount() > 0;
    }

    // Método para criar um novo usuário
    public function create(): bool {
        // Verifica se o e-mail já existe
        if ($this->emailExists()) return false;

        // Consulta SQL para inserir um novo usuário no banco
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Criptografa a senha antes de armazená-la no banco de dados
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        return $stmt->execute([
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password
        ]);
    }

    // Método para buscar todos os usuários no banco de dados
    public function read() {
        $stmt = $this->conn->prepare("SELECT id, name, email FROM users");
        $stmt->execute();
        return $stmt;
    }
}
?>