<?php
/**
 * Controller: AuthController
 * Gerencia lógica de autenticação (login, registro, logout)
 */
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
    }
    
    /**
     * Processar registro
     */
    public function register($username, $email, $password, $confirm_password)
    {
        return $this->userModel->register($username, $email, $password, $confirm_password);
    }
    
    /**
     * Processar login
     */
    public function login($username, $password)
    {
        $result = $this->userModel->login($username, $password);
        
        if ($result['success']) {
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['username'] = $result['user']['username'];
            $_SESSION['email'] = $result['user']['email'];
            $_SESSION['login_time'] = time();
        }
        
        return $result;
    }
    
    /**
     * Fazer logout
     */
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
    
    /**
     * Verificar se está logado
     */
    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Obter dados do usuário logado
     */
    public function getCurrentUser()
    {
        if ($this->isLoggedIn()) {
            return $this->userModel->getUserById($_SESSION['user_id']);
        }
        return null;
    }
    
    /**
     * Verificar timeout de sessão (30 minutos)
     */
    public function checkSessionTimeout()
    {
        $timeout = 30 * 60;
        
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
            $this->logout();
        }
        
        $_SESSION['login_time'] = time();
    }
}
?>
