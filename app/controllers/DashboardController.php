<?php
/**
 * Controller: DashboardController
 * Gerencia o painel do usuário logado
 */
require_once __DIR__ . '/../controllers/AuthController.php';

class DashboardController
{
    private $auth;
    
    public function __construct()
    {
        $this->auth = new AuthController();
    }
    
    /**
     * Exibir dashboard (verificar se está logado)
     */
    public function index()
    {
        if (!$this->auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        
        $this->auth->checkSessionTimeout();
        $user = $this->auth->getCurrentUser();
        
        return [
            'user' => $user,
            'title' => 'Dashboard - GameTech'
        ];
    }
    
    /**
     * Obter resumo da conta
     */
    public function getAccountSummary()
    {
        return [
            'totalOrders' => 0,
            'totalSpent' => 0.00,
            'cartItems' => 0
        ];
    }
    
    /**
     * Obter pedidos do usuário
     */
    public function getUserOrders($userId)
    {
        // Implementar consulta ao banco
        return [];
    }
    
    /**
     * Obter itens do carrinho
     */
    public function getCartItems()
    {
        if (isset($_SESSION['cart'])) {
            return json_decode($_SESSION['cart'], true);
        }
        return [];
    }
    
    /**
     * Adicionar produto ao carrinho
     */
    public function addToCart($productId, $productName, $price)
    {
        $cart = $this->getCartItems();
        
        $cart[] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $price,
            'date' => date('d/m/Y H:i:s')
        ];
        
        $_SESSION['cart'] = json_encode($cart);
        
        return ['success' => true, 'message' => 'Produto adicionado ao carrinho'];
    }
    
    /**
     * Remover product do carrinho
     */
    public function removeFromCart($index)
    {
        $cart = $this->getCartItems();
        
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart);
            $_SESSION['cart'] = json_encode($cart);
            return ['success' => true, 'message' => 'Produto removido'];
        }
        
        return ['success' => false, 'errors' => ['Produto não encontrado']];
    }
    
    /**
     * Limpar carrinho
     */
    public function clearCart()
    {
        unset($_SESSION['cart']);
        return ['success' => true, 'message' => 'Carrinho limpo'];
    }
}
?>
