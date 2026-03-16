<div style="max-width: 400px; margin: 40px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-left: 4px solid #00d4ff;">
    <a href="<?php echo BASE_URL; ?>" style="display: inline-block; margin-bottom: 20px; color: #00d4ff; text-decoration: none; font-weight: bold;">← Voltar à loja</a>
    
    <h2 style="color: #1a1a2e; text-align: center; margin-bottom: 30px; font-size: 1.8em;">Registrar</h2>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #c3e6cb;">
            <?php echo htmlspecialchars($success); ?>
        </div>
        <p style="text-align: center; margin-top: 20px;">
            <a href="<?php echo BASE_URL; ?>/login" style="color: #00d4ff; text-decoration: none; font-weight: bold;">Fazer login →</a>
        </p>
    <?php else: ?>
        <form method="POST">
            <div style="margin-bottom: 20px;">
                <label for="username" style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Usuário:</label>
                <input type="text" id="username" name="username" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box;"
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Email:</label>
                <input type="email" id="email" name="email" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box;"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Senha:</label>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box;">
                <div style="font-size: 0.85em; color: #666; margin-top: 5px;">Mínimo de 6 caracteres</div>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="confirm_password" style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Confirmar Senha:</label>
                <input type="password" id="confirm_password" name="confirm_password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box;">
            </div>

            <button type="submit" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%); color: white; border: none; border-radius: 4px; font-size: 1.1em; font-weight: bold; cursor: pointer;">Criar Conta</button>
        </form>

        <div style="text-align: center; margin-top: 20px; color: #666;">
            Já tem conta? <a href="<?php echo BASE_URL; ?>/login" style="color: #00d4ff; text-decoration: none; font-weight: bold;">Faça login aqui</a>
        </div>
    <?php endif; ?>
</div>
