<?php
require_once 'config.php';
require_once 'auth.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    $result = registerUser($username, $email, $password, $confirm_password);
    
    if ($result['success']) {
        $success = $result['message'];
    } else {
        $errors = $result['errors'];
    }
}

// Se já está logado, redireciona
if (isLoggedIn()) {
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - GameTech</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container {
            max-width: 400px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #00d4ff;
        }

        .auth-container h2 {
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 5px rgba(0, 212, 255, 0.3);
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 212, 255, 0.3);
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #f5c6cb;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #c3e6cb;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-link a {
            color: #00d4ff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #ff006e;
        }

        .home-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #00d4ff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .home-link:hover {
            color: #ff006e;
        }

        .password-hint {
            font-size: 0.85em;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>GameTech</h1>
        <p>Criar Nova Conta</p>
    </header>

    <div class="auth-container">
        <a href="index.html" class="home-link">← Voltar à loja</a>
        
        <h2>Registrar</h2>

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <p style="text-align: center; margin-top: 20px;">
                <a href="login.php" style="color: #00d4ff; text-decoration: none; font-weight: bold;">Fazer login →</a>
            </p>
        <?php else: ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Usuário:</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" required>
                    <div class="password-hint">Mínimo de 6 caracteres</div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Senha:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn-register">Criar Conta</button>
            </form>

            <div class="login-link">
                Já tem conta? <a href="login.php">Faça login aqui</a>
            </div>
        <?php endif; ?>
    </div>

    <footer style="margin-top: 60px;">
        <p>&copy; 2026 GameTech - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
