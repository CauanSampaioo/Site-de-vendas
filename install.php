<?php
/**
 * Script de Verificação e Instalação do Sistema
 * Execute este arquivo em: http://localhost/primeiroSite/install.php
 */

session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'gametech';

$status = [
    'php_version' => phpversion(),
    'php_pdo' => extension_loaded('pdo') ? '✓' : '✗',
    'php_mysql' => extension_loaded('mysqli') ? '✓' : '✗',
    'database' => 'Não verificado',
    'tables' => 'Não verificado'
];

$message = '';
$error = '';

// Se clicou em instalar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install'])) {
    // Conectar ao MySQL sem banco de dados específico
    $conn = new mysqli($db_host, $db_user, $db_pass);
    
    if ($conn->connect_error) {
        $error = "Erro de conexão: " . $conn->connect_error;
    } else {
        // Criar banco de dados
        $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
        if ($conn->query($sql)) {
            $message .= "✓ Banco de dados criado/verificado<br>";
            
            // Conectar ao banco novo
            $conn->select_db($db_name);
            
            // Tabela de usuários
            $sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                ativo TINYINT DEFAULT 1,
                INDEX idx_username (username),
                INDEX idx_email (email)
            )";
            
            if ($conn->query($sql_usuarios)) {
                $message .= "✓ Tabela 'usuarios' criada/verificada<br>";
            } else {
                $error .= "Erro ao criar tabela usuarios: " . $conn->error . "<br>";
            }
            
            // Tabela de pedidos
            $sql_pedidos = "CREATE TABLE IF NOT EXISTS pedidos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL,
                total DECIMAL(10, 2),
                data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                status VARCHAR(20) DEFAULT 'pendente',
                FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
                INDEX idx_usuario_pedidos (usuario_id)
            )";
            
            if ($conn->query($sql_pedidos)) {
                $message .= "✓ Tabela 'pedidos' criada/verificada<br>";
            } else {
                $error .= "Erro ao criar tabela pedidos: " . $conn->error . "<br>";
            }
            
            // Tabela de itens de pedido
            $sql_itens = "CREATE TABLE IF NOT EXISTS pedidos_itens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                pedido_id INT NOT NULL,
                produto_nome VARCHAR(100),
                preco DECIMAL(10, 2),
                quantidade INT DEFAULT 1,
                FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE
            )";
            
            if ($conn->query($sql_itens)) {
                $message .= "✓ Tabela 'pedidos_itens' criada/verificada<br>";
            } else {
                $error .= "Erro ao criar tabela pedidos_itens: " . $conn->error . "<br>";
            }
            
            $_SESSION['install_complete'] = true;
        } else {
            $error = "Erro ao criar banco de dados: " . $conn->error;
        }
        
        $conn->close();
    }
}

// Verificar status atual
$conn = @new mysqli($db_host, $db_user, $db_pass);

if ($conn->connect_error) {
    $status['database'] = '✗ Não conectado';
} else {
    $status['database'] = '✓ Conectado';
    
    // Verificar se banco existe
    $result = @$conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
    
    if ($result && $result->num_rows > 0) {
        $conn->select_db($db_name);
        
        // Verificar tabelas
        $tables_sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name'";
        $tables_result = $conn->query($tables_sql);
        
        if ($tables_result && $tables_result->num_rows >= 3) {
            $status['tables'] = '✓ Todas (3/3)';
        } else {
            $status['tables'] = '✗ Incompletas (' . ($tables_result ? $tables_result->num_rows : 0) . '/3)';
        }
    } else {
        $status['tables'] = '✗ Banco não existe';
    }
    
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalação - GameTech Login System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 212, 255, 0.2);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #1a1a2e;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            color: #999;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.9em;
        }

        .status-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 30px;
            border-left: 4px solid #00d4ff;
        }

        .status-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .status-item:last-child {
            border-bottom: none;
        }

        .status-label {
            font-weight: bold;
            color: #333;
        }

        .status-value {
            color: #00d4ff;
            font-weight: bold;
        }

        .message-box {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }

        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #f5c6cb;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        button {
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-install {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
        }

        .btn-install:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 212, 255, 0.3);
        }

        .btn-back {
            background: #ccc;
            color: #333;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background: #999;
        }

        .ready {
            text-align: center;
            padding: 30px;
        }

        .ready-icon {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .ready h2 {
            color: #28a745;
            margin-bottom: 15px;
        }

        .links {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .links a {
            display: inline-block;
            padding: 10px 20px;
            background: #00d4ff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            transition: background 0.3s;
        }

        .links a:hover {
            background: #0099cc;
        }

        .info-text {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            color: #0c3a5a;
            font-size: 0.9em;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎮 GameTech - Sistema de Login</h1>
        <p class="subtitle">Verificação e Instalação de Banco de Dados</p>

        <div class="status-box">
            <div class="status-item">
                <span class="status-label">Versão PHP:</span>
                <span class="status-value"><?php echo $status['php_version']; ?></span>
            </div>
            <div class="status-item">
                <span class="status-label">PDO ativo:</span>
                <span class="status-value"><?php echo $status['php_pdo']; ?></span>
            </div>
            <div class="status-item">
                <span class="status-label">MySQLi ativo:</span>
                <span class="status-value"><?php echo $status['php_mysql']; ?></span>
            </div>
            <div class="status-item">
                <span class="status-label">Banco de Dados:</span>
                <span class="status-value"><?php echo $status['database']; ?></span>
            </div>
            <div class="status-item">
                <span class="status-label">Tabelas:</span>
                <span class="status-value"><?php echo $status['tables']; ?></span>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message-box">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="error-box">
                <strong>Erro:</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['install_complete']) && $_SESSION['install_complete']): ?>
            <div class="ready">
                <div class="ready-icon">✓</div>
                <h2>Sistema Pronto!</h2>
                <p>Banco de dados e tabelas criados com sucesso.</p>
                <div class="info-text">
                    <strong>Próximos passos:</strong><br>
                    1. Acesse a página de registro para criar uma conta<br>
                    2. Faça login com suas credenciais<br>
                    3. Explore o dashboard personalizado
                </div>
                <div class="links">
                    <a href="register.php">📝 Criar Conta</a>
                    <a href="login.php">🔐 Fazer Login</a>
                    <a href="index.html">🛒 Voltar à Loja</a>
                </div>
            </div>
        <?php else: ?>
            <div class="info-text">
                <strong>ℹ️ Instruções:</strong><br>
                1. Certifique-se de que MySQL está rodando<br>
                2. Clique em "Instalar" para criar o banco de dados<br>
                3. Use as credenciais padrão (root sem senha)<br>
                4. Se usar outras credenciais, edite config.php
            </div>

            <form method="POST">
                <div class="button-group">
                    <button type="submit" name="install" class="btn-install">🚀 Instalar Sistema</button>
                    <a href="index.html" class="btn-back">← Voltar</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
