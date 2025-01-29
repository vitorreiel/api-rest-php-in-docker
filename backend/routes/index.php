<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once '../config/database.php';
require_once '../models/User.php';
require '../vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;
use Prometheus\RenderTextFormat;

// Inicializa o Prometheus com APCu para persistência
$adapter = new APC();
$registry = new CollectorRegistry($adapter);

// Captura os dados da requisição
$method = $_SERVER['REQUEST_METHOD'];
$endpoint = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Obtém apenas o caminho
$normalized_endpoint = str_replace("/", "_", trim($endpoint, "/"));

// Nome da métrica baseado no endpoint
$metric_name = "http_requests_" . ($normalized_endpoint ?: "root");

// Contador para rastrear requisições HTTP por endpoint
$counter = $registry->getOrRegisterCounter(
    'api_rest_php',
    $metric_name,
    "Número total de requisições HTTP para $endpoint",
    ['method', 'endpoint']
);

// Incrementa a métrica
$counter->inc([$method, $endpoint]);

// Responde ao preflight (CORS)
if ($method == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Rota para exibir métricas do Prometheus
if ($method === 'GET' && $endpoint === '/metrics') {
    $renderer = new RenderTextFormat();
    header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
    echo $renderer->render($registry->getMetricFamilySamples());
    exit();
}

// Cria a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Rota para registrar um novo usuário
if ($method === 'POST' && $endpoint === '/register') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;

        if ($user->emailExists()) {
            http_response_code(400);
            echo json_encode(["message" => "Este e-mail já está registrado."]);
        } else {
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
} elseif ($method === 'GET' && $endpoint === '/users') {
    $stmt = $user->read();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);

// Resposta para endpoints desconhecidos
} else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint não encontrado."]);
}
