<?php
require_once 'config.php';
require_once 'auth.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = loginUser($username, $password);
    
    if ($result['success']) {
        redirect('dashboard.php');
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
    <title>Login - GameTech</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container {
            max-width: 400px;
            margin: 80px auto;
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

        .btn-login {
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

        .btn-login:hover {
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

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .register-link a {
            color: #00d4ff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .register-link a:hover {
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
    </style>
</head>
<body>
    <header>
        <h1>GameTech</h1>
        <p>Sistema de Login</p>
    </header>

    <div class="auth-container">
        <a href="index.html" class="home-link">← Voltar à loja</a>
        
        <h2>Login</h2>

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Entrar</button>
        </form>

        <div class="register-link">
            Não tem conta? <a href="register.php">Registre-se aqui</a>
        </div>
    </div>

    <footer style="margin-top: 60px;">
        <p>&copy; 2026 GameTech - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
