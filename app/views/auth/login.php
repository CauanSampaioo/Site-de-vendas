<div style="max-width: 400px; margin: 80px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-left: 4px solid #00d4ff;">
    <a href="<?php echo BASE_URL; ?>" style="display: inline-block; margin-bottom: 20px; color: #00d4ff; text-decoration: none; font-weight: bold;">← Voltar à loja</a>
    
    <h2 style="color: #1a1a2e; text-align: center; margin-bottom: 30px; font-size: 1.8em;">Login</h2>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom: 20px;">
            <label for="username" style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Usuário:</label>
            <input type="text" id="username" name="username" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box; transition: border-color 0.3s;"
                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Senha:</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box; transition: border-color 0.3s;">
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%); color: white; border: none; border-radius: 4px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">Entrar</button>
    </form>

    <div style="text-align: center; margin-top: 20px; color: #666;">
        Não tem conta? <a href="<?php echo BASE_URL; ?>/register" style="color: #00d4ff; text-decoration: none; font-weight: bold;">Registre-se aqui</a>
    </div>
</div>
