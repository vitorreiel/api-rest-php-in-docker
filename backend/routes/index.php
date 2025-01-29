<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once '../config/database.php';
require_once '../models/User.php';

// Captura o método HTTP da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Cria a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // Responde com status OK para o preflight
    exit();
}

// Rota para registro de um novo usuário
if ($method === 'POST' && $_SERVER['REQUEST_URI'] === '/register') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {
        // Atribuindo os dados
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;

        // Verifica se o e-mail já existe no banco
        if ($user->emailExists()) {
            http_response_code(400);
            echo json_encode(["message" => "Este e-mail já está registrado."]);
        } else {
            // Se o e-mail não existe, cria o usuário
            if ($user->create()) {
                http_response_code(201);
                echo json_encode(["message" => "Usuário registrado com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Não foi possível registrar o usuário."]);
            }
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Dados incompletos."]);
    }

// Rota para listar todos os usuários
} elseif ($method === 'GET' && $_SERVER['REQUEST_URI'] === '/users') {
    $stmt = $user->read();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint não encontrado."]);
}
?>
