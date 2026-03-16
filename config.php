<?php
// Configuração de conexão com banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gametech');

// Conectar ao banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Definir charset
$conn->set_charset("utf8mb4");

// Variáveis de sessão
session_start();

// Funções auxiliares
function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUsername() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : '';
}

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
