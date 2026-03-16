<?php
/**
 * Index.php - Ponto de entrada da aplicação
 * Arquivo público que redireciona as requisições
 */

require_once dirname(__DIR__) . '/app/config/config.php';

// Obter a rota solicitada
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = str_replace('/primeiroSite', '', $request);
$request = trim($request, '/');

// Se estiver vazio, é a página inicial
if (empty($request) || $request === 'index') {
    require_once APP_PATH . '/controllers/HomeController.php';
    $controller = new HomeController();
    $data = $controller->index();
    
    $content = '';
    ob_start();
    include APP_PATH . '/views/home/index.php';
    $content = ob_get_clean();
    
    include APP_PATH . '/views/layouts/main.php';
}
// Login
elseif ($request === 'login') {
    require_once APP_PATH . '/controllers/AuthController.php';
    $auth = new AuthController();
    
    $errors = [];
    $success = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $auth->login($_POST['username'] ?? '', $_POST['password'] ?? '');
        
        if ($result['success']) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        } else {
            $errors = $result['errors'];
        }
    }
    
    if ($auth->isLoggedIn()) {
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
    
    $isLoggedIn = $auth->isLoggedIn();
    $title = 'Login - GameTech';
    
    $content = '';
    ob_start();
    include APP_PATH . '/views/auth/login.php';
    $content = ob_get_clean();
    
    include APP_PATH . '/views/layouts/main.php';
}
// Registro
elseif ($request === 'register') {
    require_once APP_PATH . '/controllers/AuthController.php';
    require_once APP_PATH . '/models/User.php';
    
    $auth = new AuthController();
    
    if ($auth->isLoggedIn()) {
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
    
    $userModel = new User();
    $errors = [];
    $success = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $userModel->register(
            $_POST['username'] ?? '',
            $_POST['email'] ?? '',
            $_POST['password'] ?? '',
            $_POST['confirm_password'] ?? ''
        );
        
        if ($result['success']) {
            $success = $result['message'];
        } else {
            $errors = $result['errors'];
        }
    }
    
    $isLoggedIn = $auth->isLoggedIn();
    $title = 'Registro - GameTech';
    
    $content = '';
    ob_start();
    include APP_PATH . '/views/auth/register.php';
    $content = ob_get_clean();
    
    include APP_PATH . '/views/layouts/main.php';
}
// Dashboard
elseif ($request === 'dashboard') {
    require_once APP_PATH . '/controllers/DashboardController.php';
    
    $dashboard = new DashboardController();
    $data = $dashboard->index();
    
    $user = $data['user'];
    $title = $data['title'];
    
    $content = '';
    ob_start();
    include APP_PATH . '/views/dashboard/index.php';
    $content = ob_get_clean();
    
    include APP_PATH . '/views/layouts/main.php';
}
// Logout
elseif ($request === 'logout') {
    require_once APP_PATH . '/controllers/AuthController.php';
    $auth = new AuthController();
    $auth->logout();
}
// 404 - Página não encontrada
else {
    http_response_code(404);
    header('Location: ' . BASE_URL);
    exit;
}
?>
