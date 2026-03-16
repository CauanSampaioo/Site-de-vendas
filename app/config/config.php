<?php
/**
 * Arquivo de Configuração Principal
 * Define constantes e configurações globais da aplicação
 */

// Inicia a sessão
session_start();

// Define o timezone
date_default_timezone_set('America/Sao_Paulo');

// URLs base
define('ROOT_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Para desenvolvimento local
define('BASE_URL', 'http://localhost/primeiroSite');
define('ASSETS_URL', BASE_URL . '/public');

// Configurações de banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gametech');

// Configurações da aplicação
define('APP_NAME', 'GameTech');
define('APP_TIMEZONE', 'America/Sao_Paulo');
define('SESSION_TIMEOUT', 30 * 60); // 30 minutos

// Modo debug
define('DEBUG_MODE', true);

// Auto-load de classes
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/models/',
        APP_PATH . '/controllers/',
        APP_PATH . '/config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Funções auxiliares
function view($viewName, $data = [])
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    
    $viewPath = APP_PATH . '/views/' . $viewName . '.php';
    
    if (!file_exists($viewPath)) {
        die("View não encontrada: {$viewName}");
    }
    
    include $viewPath;
}

function redirect($url)
{
    header("Location: " . BASE_URL . $url);
    exit;
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function getUsername()
{
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function formatPrice($price)
{
    return 'R$ ' . number_format($price, 2, ',', '.');
}

function log_error($message)
{
    $logFile = ROOT_PATH . '/storage/logs/errors.log';
    $message = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
    file_put_contents($logFile, $message, FILE_APPEND);
}
?>
