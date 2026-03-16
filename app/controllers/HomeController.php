<?php
/**
 * Controller: HomeController
 * Gerencia a página inicial e exibição de produtos
 */
require_once __DIR__ . '/../controllers/AuthController.php';

class HomeController
{
    private $auth;
    
    public function __construct()
    {
        $this->auth = new AuthController();
    }
    
    /**
     * Exibir página inicial
     */
    public function index()
    {
        $isLoggedIn = $this->auth->isLoggedIn();
        $user = $isLoggedIn ? $this->auth->getCurrentUser() : null;
        
        return [
            'isLoggedIn' => $isLoggedIn,
            'user' => $user,
            'title' => 'GameTech - Loja de Peças Gamer'
        ];
    }
    
    /**
     * Obter produtos em destaque
     */
    public function getFeaturedProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'NVIDIA GeForce RTX 4080',
                'category' => 'Placa de Vídeo',
                'price' => 4500.00
            ],
            [
                'id' => 2,
                'name' => 'Intel Core i9-13900K',
                'category' => 'Processador',
                'price' => 3800.00
            ],
            [
                'id' => 3,
                'name' => 'Corsair Vengeance RGB Pro 64GB DDR5',
                'category' => 'Memória RAM',
                'price' => 1800.00
            ],
        ];
    }
    
    /**
     * Filtrar produtos por categoria
     */
    public function getProductsByCategory($category)
    {
        $products = $this->getAllProducts();
        
        return array_filter($products, function($product) use ($category) {
            return strtolower($product['category']) === strtolower($category);
        });
    }
    
    /**
     * Obter todos os produtos
     */
    public function getAllProducts()
    {
        return [
            // Placas de Vídeo
            ['id' => 1, 'name' => 'NVIDIA GeForce RTX 4080', 'category' => 'Placa de Vídeo', 'price' => 4500.00],
            ['id' => 2, 'name' => 'AMD Radeon RX 7800 XT', 'category' => 'Placa de Vídeo', 'price' => 3200.00],
            ['id' => 3, 'name' => 'NVIDIA GeForce RTX 4070', 'category' => 'Placa de Vídeo', 'price' => 3000.00],
            
            // Processadores
            ['id' => 4, 'name' => 'Intel Core i9-13900K', 'category' => 'Processador', 'price' => 3800.00],
            ['id' => 5, 'name' => 'AMD Ryzen 9 7950X', 'category' => 'Processador', 'price' => 3600.00],
            
            // Memória RAM
            ['id' => 6, 'name' => 'Corsair Vengeance RGB Pro 64GB DDR5', 'category' => 'Memória RAM', 'price' => 1800.00],
            ['id' => 7, 'name' => 'Kingston Fury Beast 32GB DDR5', 'category' => 'Memória RAM', 'price' => 900.00],
        ];
    }
}
?>
