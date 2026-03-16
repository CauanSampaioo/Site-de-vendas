<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: #00d4ff; padding: 30px; border-radius: 8px; margin-bottom: 40px; text-align: center;">
        <h3 style="font-size: 1.8em; margin: 0 0 10px 0;">Bem-vindo ao seu painel!</h3>
        <p style="margin: 0;">Você está logado como <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
        <a href="<?php echo BASE_URL; ?>" style="display: inline-block; margin-top: 15px; background-color: #00d4ff; color: #1a1a2e; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">← Voltar à loja</a>
    </div>

    <h2 style="color: #1a1a2e; border-bottom: 3px solid #00d4ff; padding-bottom: 10px; margin-bottom: 30px; font-size: 1.8em; text-transform: uppercase;">📊 Resumo da Conta</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-bottom: 40px;">
        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-left: 4px solid #00d4ff; text-align: center;">
            <h3 style="color: #1a1a2e; margin-bottom: 15px;">Meus Pedidos</h3>
            <div style="font-size: 2.5em; color: #00d4ff; font-weight: bold; margin-bottom: 10px;">0</div>
            <p style="color: #555;">Nenhum pedido registrado ainda</p>
        </div>

        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-left: 4px solid #00d4ff; text-align: center;">
            <h3 style="color: #1a1a2e; margin-bottom: 15px;">Itens no Carrinho</h3>
            <div style="font-size: 2.5em; color: #00d4ff; font-weight: bold; margin-bottom: 10px;" id="cart-count">0</div>
            <p style="color: #555;">Produtos salvos</p>
        </div>

        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-left: 4px solid #00d4ff; text-align: center;">
            <h3 style="color: #1a1a2e; margin-bottom: 15px;">Gasto Total</h3>
            <div style="font-size: 2.5em; color: #00d4ff; font-weight: bold; margin-bottom: 10px;">R$ 0,00</div>
            <p style="color: #555;">Em todas as compras</p>
        </div>
    </div>

    <h2 style="color: #1a1a2e; border-bottom: 3px solid #00d4ff; padding-bottom: 10px; margin-bottom: 30px; font-size: 1.8em; text-transform: uppercase;">🛒 Produtos em Destaque</h2>
    
    <table style="width: 100%; background: white; border-collapse: collapse; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <thead style="background-color: #1a1a2e; color: #00d4ff;">
            <tr>
                <th style="padding: 15px; text-align: left; font-weight: bold;">Produto</th>
                <th style="padding: 15px; text-align: left; font-weight: bold;">Categoria</th>
                <th style="padding: 15px; text-align: left; font-weight: bold;">Preço</th>
                <th style="padding: 15px; text-align: left; font-weight: bold;">Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px 15px;">NVIDIA GeForce RTX 4080</td>
                <td style="padding: 12px 15px;">Placa de Vídeo</td>
                <td style="padding: 12px 15px; color: #00d4ff; font-weight: bold;">R$ 4.500,00</td>
                <td style="padding: 12px 15px;"><button style="background-color: #00d4ff; color: #1a1a2e; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Adicionar</button></td>
            </tr>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px 15px;">Intel Core i9-13900K</td>
                <td style="padding: 12px 15px;">Processador</td>
                <td style="padding: 12px 15px; color: #00d4ff; font-weight: bold;">R$ 3.800,00</td>
                <td style="padding: 12px 15px;"><button style="background-color: #00d4ff; color: #1a1a2e; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Adicionar</button></td>
            </tr>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px 15px;">Corsair Vengeance RGB Pro 64GB DDR5</td>
                <td style="padding: 12px 15px;">Memória RAM</td>
                <td style="padding: 12px 15px; color: #00d4ff; font-weight: bold;">R$ 1.800,00</td>
                <td style="padding: 12px 15px;"><button style="background-color: #00d4ff; color: #1a1a2e; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Adicionar</button></td>
            </tr>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px 15px;">Samsung 990 Pro 2TB NVMe</td>
                <td style="padding: 12px 15px;">SSD</td>
                <td style="padding: 12px 15px; color: #00d4ff; font-weight: bold;">R$ 1.400,00</td>
                <td style="padding: 12px 15px;"><button style="background-color: #00d4ff; color: #1a1a2e; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Adicionar</button></td>
            </tr>
            <tr>
                <td style="padding: 12px 15px;">Corsair RM1000x 1000W</td>
                <td style="padding: 12px 15px;">Fonte de Energia</td>
                <td style="padding: 12px 15px; color: #00d4ff; font-weight: bold;">R$ 1.200,00</td>
                <td style="padding: 12px 15px;"><button style="background-color: #00d4ff; color: #1a1a2e; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Adicionar</button></td>
            </tr>
        </tbody>
    </table>

    <h2 style="color: #1a1a2e; border-bottom: 3px solid #ff006e; padding-bottom: 10px; margin-bottom: 30px; margin-top: 40px; font-size: 1.8em; text-transform: uppercase;">🛍️ Meu Carrinho</h2>
    
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-left: 4px solid #ff006e;">
        <div id="cart-items" style="list-style: none; padding: 0;"></div>
        <div class="empty-message" id="empty-cart" style="text-align: center; color: #999; padding: 20px; font-style: italic;">Seu carrinho está vazio</div>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="<?php echo BASE_URL; ?>/logout" style="background-color: #ff006e; color: white; padding: 12px 30px; border-radius: 4px; text-decoration: none; font-weight: bold;">Sair da Conta</a>
    </div>
</div>

<script>
    // Simular carrinho
    function updateCartUI() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCount = document.getElementById('cart-count');
        const cartItems = document.getElementById('cart-items');
        const emptyCart = document.getElementById('empty-cart');

        cartCount.textContent = cart.length;

        if (cart.length > 0) {
            emptyCart.style.display = 'none';
            let html = '';
            cart.forEach((item, index) => {
                html += `<div style="padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                    <span><strong>${item.name}</strong></span>
                    <button onclick="removeFromCart(${index})" style="background-color: #ff006e; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Remover</button>
                </div>`;
            });
            cartItems.innerHTML = html;
        } else {
            emptyCart.style.display = 'block';
            cartItems.innerHTML = '';
        }
    }

    function removeFromCart(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    }

    updateCartUI();
</script>
