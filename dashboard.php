<?php
require_once 'config.php';
require_once 'auth.php';

// Verificar se está logado
if (!isLoggedIn()) {
    redirect('login.php');
}

// Verificar timeout de sessão
checkSessionTimeout();

$username = getUsername();

// Processar logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logoutUser();
}

// Buscar histórico de compras (simulado)
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GameTech</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #00d4ff;
            padding: 30px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .dashboard-header h2 {
            margin: 0;
            font-size: 1.8em;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logout-btn {
            background-color: #ff006e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #e60058;
        }

        .dashboard-content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #00d4ff;
            text-align: center;
        }

        .dashboard-card h3 {
            color: #1a1a2e;
            margin-bottom: 15px;
        }

        .dashboard-card .value {
            font-size: 2.5em;
            color: #00d4ff;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section-title {
            color: #1a1a2e;
            border-bottom: 3px solid #00d4ff;
            padding-bottom: 10px;
            margin-bottom: 30px;
            font-size: 1.8em;
            text-transform: uppercase;
        }

        .products-table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .products-table thead {
            background-color: #1a1a2e;
            color: #00d4ff;
        }

        .products-table th {
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }

        .products-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .products-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .price {
            color: #00d4ff;
            font-weight: bold;
        }

        .add-to-cart-btn {
            background-color: #00d4ff;
            color: #1a1a2e;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #ff006e;
            color: white;
        }

        .cart-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #ff006e;
        }

        .empty-message {
            text-align: center;
            color: #999;
            padding: 20px;
            font-style: italic;
        }

        .welcome-box {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #00d4ff;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 40px;
            text-align: center;
        }

        .welcome-box h3 {
            font-size: 1.8em;
            margin: 0 0 10px 0;
        }

        .back-to-store {
            display: inline-block;
            margin-top: 20px;
            background-color: #00d4ff;
            color: #1a1a2e;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .back-to-store:hover {
            background-color: #ff006e;
            color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <h2>🎮 GameTech - Dashboard</h2>
        <div class="user-info">
            <span>Bem-vindo, <strong><?php echo htmlspecialchars($username); ?></strong>!</span>
            <form method="POST" style="margin: 0;">
                <button type="submit" name="logout" class="logout-btn">Sair</button>
            </form>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="welcome-box">
            <h3>Bem-vindo ao seu painel!</h3>
            <p>Você está logado como <strong><?php echo htmlspecialchars($username); ?></strong></p>
            <a href="index.html" class="back-to-store">← Voltar à loja</a>
        </div>

        <h2 class="section-title">📊 Resumo da Conta</h2>
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Meus Pedidos</h3>
                <div class="value">0</div>
                <p>Nenhum pedido registrado ainda</p>
            </div>

            <div class="dashboard-card">
                <h3>Itens no Carrinho</h3>
                <div class="value" id="cart-count">0</div>
                <p>Produtos salvos</p>
            </div>

            <div class="dashboard-card">
                <h3>Gasto Total</h3>
                <div class="value">R$ 0,00</div>
                <p>Em todas as compras</p>
            </div>
        </div>

        <h2 class="section-title">🛒 Produtos em Destaque</h2>
        <table class="products-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NVIDIA GeForce RTX 4080</td>
                    <td>Placa de Vídeo</td>
                    <td class="price">R$ 4.500,00</td>
                    <td><button class="add-to-cart-btn" onclick="addToCart('RTX 4080')">Adicionar</button></td>
                </tr>
                <tr>
                    <td>Intel Core i9-13900K</td>
                    <td>Processador</td>
                    <td class="price">R$ 3.800,00</td>
                    <td><button class="add-to-cart-btn" onclick="addToCart('i9-13900K')">Adicionar</button></td>
                </tr>
                <tr>
                    <td>Corsair Vengeance RGB Pro 64GB DDR5</td>
                    <td>Memória RAM</td>
                    <td class="price">R$ 1.800,00</td>
                    <td><button class="add-to-cart-btn" onclick="addToCart('Corsair 64GB DDR5')">Adicionar</button></td>
                </tr>
                <tr>
                    <td>Samsung 990 Pro 2TB NVMe</td>
                    <td>SSD</td>
                    <td class="price">R$ 1.400,00</td>
                    <td><button class="add-to-cart-btn" onclick="addToCart('Samsung 990 Pro')">Adicionar</button></td>
                </tr>
                <tr>
                    <td>Corsair RM1000x 1000W</td>
                    <td>Fonte de Energia</td>
                    <td class="price">R$ 1.200,00</td>
                    <td><button class="add-to-cart-btn" onclick="addToCart('Corsair 1000W')">Adicionar</button></td>
                </tr>
            </tbody>
        </table>

        <h2 class="section-title" style="margin-top: 40px;">🛍️ Meu Carrinho</h2>
        <div class="cart-section">
            <div id="cart-items"></div>
            <div class="empty-message" id="empty-cart">Seu carrinho está vazio</div>
        </div>
    </div>

    <footer style="margin-top: 60px;">
        <p>&copy; 2026 GameTech - Todos os direitos reservados.</p>
    </footer>

    <script>
        // Atualizar cartinho
        function updateCartUI() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartCount = document.getElementById('cart-count');
            const cartItems = document.getElementById('cart-items');
            const emptyCart = document.getElementById('empty-cart');

            cartCount.textContent = cart.length;

            if (cart.length > 0) {
                emptyCart.style.display = 'none';
                let html = '<ul style="list-style: none; padding: 0;">';
                cart.forEach((item, index) => {
                    html += `<li style="padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                        <span><strong>${item.name}</strong> - ${item.date}</span>
                        <button onclick="removeFromCart(${index})" style="background-color: #ff006e; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Remover</button>
                    </li>`;
                });
                html += '</ul>';
                cartItems.innerHTML = html;
            } else {
                emptyCart.style.display = 'block';
                cartItems.innerHTML = '';
            }
        }

        function addToCart(productName) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({
                name: productName,
                date: new Date().toLocaleString('pt-BR')
            });
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
            alert(productName + ' adicionado ao carrinho!');
        }

        function removeFromCart(index) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        }

        // Inicializar ao carregar
        updateCartUI();
    </script>
</body>
</html>
