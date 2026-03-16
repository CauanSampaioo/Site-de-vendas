<?php
require_once 'config.php';

// Se está logado, mostrar opção de dashboard
$is_logged_in = isLoggedIn();
$current_user = $is_logged_in ? getUsername() : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameTech - Peças para PCs Gamer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div>
                <h1>GameTech</h1>
                <p>Sua loja especializada em peças para computadores gamers</p>
            </div>
            <div style="text-align: right; color: #00d4ff;">
                <?php if ($is_logged_in): ?>
                    <p style="margin-bottom: 10px;">Bem-vindo, <strong><?php echo htmlspecialchars($current_user); ?></strong>!</p>
                    <a href="dashboard.php" style="color: #00d4ff; text-decoration: none; font-weight: bold; margin-right: 15px;">📊 Dashboard</a>
                    <a href="login.php?logout=true" style="color: #ff006e; text-decoration: none; font-weight: bold;">🚪 Sair</a>
                <?php else: ?>
                    <a href="login.php" style="color: #00d4ff; text-decoration: none; font-weight: bold; margin-right: 15px;">🔐 Login</a>
                    <a href="register.php" style="color: #ff006e; text-decoration: none; font-weight: bold;">📝 Registrar</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="#inicio">Início</a></li>
            <li><a href="#produtos">Produtos</a></li>
            <li><a href="#sobre">Sobre</a></li>
            <li><a href="#contato">Contato</a></li>
        </ul>
    </nav>

    <main>
        <section id="inicio">
            <h2>Bem-vindo à GameTech</h2>
            <p>Encontre as melhores peças para montar seu PC gamer com desempenho e qualidade garantidos.</p>
            <?php if (!$is_logged_in): ?>
                <p style="margin-top: 20px; text-align: center;">
                    <a href="register.php" style="background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%); color: white; padding: 12px 30px; border-radius: 4px; text-decoration: none; font-weight: bold; display: inline-block;">
                        Criar Conta Agora →
                    </a>
                </p>
            <?php endif; ?>
        </section>

        <section id="produtos">
            <h2>Nossas Categorias</h2>

            <article>
                <h3>Placas de Vídeo (GPUs)</h3>
                <ul>
                    <li>NVIDIA GeForce RTX 4080 - R$ 4.500,00</li>
                    <li>AMD Radeon RX 7800 XT - R$ 3.200,00</li>
                    <li>NVIDIA GeForce RTX 4070 - R$ 3.000,00</li>
                    <li>AMD Radeon RX 7700 - R$ 2.200,00</li>
                </ul>
            </article>

            <article>
                <h3>Processadores (CPUs)</h3>
                <ul>
                    <li>Intel Core i9-13900K - R$ 3.800,00</li>
                    <li>AMD Ryzen 9 7950X - R$ 3.600,00</li>
                    <li>Intel Core i7-13700K - R$ 2.500,00</li>
                    <li>AMD Ryzen 7 7700X - R$ 1.900,00</li>
                </ul>
            </article>

            <article>
                <h3>Placas Mãe</h3>
                <ul>
                    <li>ASUS ROG STRIX Z790-E - R$ 2.100,00</li>
                    <li>MSI MPG B850E EDGE WIFI - R$ 1.800,00</li>
                    <li>Gigabyte Z790 AORUS Master - R$ 1.600,00</li>
                    <li>ASRock B850 Steel Legend - R$ 1.200,00</li>
                </ul>
            </article>

            <article>
                <h3>Memória RAM</h3>
                <ul>
                    <li>Corsair Vengeance RGB Pro 64GB DDR5 - R$ 1.800,00</li>
                    <li>Kingston Fury Beast 32GB DDR5 - R$ 900,00</li>
                    <li>G.Skill Trident Z5 32GB DDR5 - R$ 950,00</li>
                    <li>Team T-Force Delta RGB 16GB DDR5 - R$ 500,00</li>
                </ul>
            </article>

            <article>
                <h3>Armazenamento SSD</h3>
                <ul>
                    <li>Samsung 990 Pro 2TB NVMe - R$ 1.400,00</li>
                    <li>WD Black SN850X 2TB NVMe - R$ 1.100,00</li>
                    <li>Corsair MP600 CORE XT 1TB NVMe - R$ 600,00</li>
                    <li>Kingston A3000 500GB NVMe - R$ 300,00</li>
                </ul>
            </article>

            <article>
                <h3>Fontes de Energia</h3>
                <ul>
                    <li>Corsair RM1000x 1000W - R$ 1.200,00</li>
                    <li>Seasonic Focus Plus Gold 850W - R$ 900,00</li>
                    <li>EVGA SuperNOVA 750 G6 750W - R$ 700,00</li>
                    <li>Thermaltake Toughpower 650W - R$ 500,00</li>
                </ul>
            </article>

            <article>
                <h3>Resfriamento</h3>
                <ul>
                    <li>Noctua NH-D15 Aircooler - R$ 600,00</li>
                    <li>Corsair H150i Elite Capellix AIO - R$ 1.100,00</li>
                    <li>NZXT Kraken X63 280mm AIO - R$ 900,00</li>
                    <li>be quiet! Dark Rock Pro 4 - R$ 450,00</li>
                </ul>
            </article>

            <article>
                <h3>Gabinetes</h3>
                <ul>
                    <li>Corsair iCUE 5000T RGB - R$ 1.800,00</li>
                    <li>Lian Li LANCOOL 3 RGB - R$ 1.000,00</li>
                    <li>NZXT H7 Flow RGB - R$ 800,00</li>
                    <li>Fractal Design Core 1000 - R$ 300,00</li>
                </ul>
            </article>
        </section>

        <section id="sobre">
            <h2>Sobre a GameTech</h2>
            <p>Somos uma loja especializada em componentes para computadores gamers. Oferecemos os melhores produtos do mercado com garantia e suporte técnico.</p>
            <p>Nossa missão é ajudar gamers e entusiastas a montarem o PC dos seus sonhos com as melhores peças disponíveis.</p>
        </section>

        <section id="contato">
            <h2>Entre em Contato</h2>
            <p>Email: contato@gametech.com.br</p>
            <p>Telefone: (11) 3456-7890</p>
            <p>Endereço: Rua dos Gamers, 123 - São Paulo, SP</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 GameTech - Todos os direitos reservados.</p>
        <p>Loja especializada em peças para computadores gamers</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
