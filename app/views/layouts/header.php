<header>
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <div>
            <h1>GameTech</h1>
            <p>Sua loja especializada em peças para computadores gamers</p>
        </div>
        <div style="text-align: right; color: #00d4ff;">
            <?php if (isLoggedIn()): ?>
                <p style="margin-bottom: 10px;">Bem-vindo, <strong><?php echo htmlspecialchars(getUsername()); ?></strong>!</p>
                <a href="<?php echo BASE_URL; ?>/dashboard" style="color: #00d4ff; text-decoration: none; font-weight: bold; margin-right: 15px;">📊 Dashboard</a>
                <a href="<?php echo BASE_URL; ?>/logout" style="color: #ff006e; text-decoration: none; font-weight: bold;">🚪 Sair</a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/login" style="color: #00d4ff; text-decoration: none; font-weight: bold; margin-right: 15px;">🔐 Login</a>
                <a href="<?php echo BASE_URL; ?>/register" style="color: #ff006e; text-decoration: none; font-weight: bold;">📝 Registrar</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<nav>
    <ul>
        <li><a href="<?php echo BASE_URL; ?>/#inicio">Início</a></li>
        <li><a href="<?php echo BASE_URL; ?>/#produtos">Produtos</a></li>
        <li><a href="<?php echo BASE_URL; ?>/#sobre">Sobre</a></li>
        <li><a href="<?php echo BASE_URL; ?>/#contato">Contato</a></li>
    </ul>
</nav>
