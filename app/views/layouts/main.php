<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'GameTech'; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">
</head>
<body>
    <?php include APP_PATH . '/views/layouts/header.php'; ?>
    
    <main>
        <?php echo $content ?? ''; ?>
    </main>
    
    <?php include APP_PATH . '/views/layouts/footer.php'; ?>
    
    <script src="<?php echo ASSETS_URL; ?>/js/script.js"></script>
</body>
</html>
