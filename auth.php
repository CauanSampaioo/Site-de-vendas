<?php
require_once 'config.php';

// Registrar novo usuário
function registerUser($username, $email, $password, $confirm_password) {
    global $conn;
    $errors = [];

    // Validações
    if (empty($username)) {
        $errors[] = "Nome de usuário é obrigatório";
    }
    if (empty($email)) {
        $errors[] = "Email é obrigatório";
    }
    if (empty($password)) {
        $errors[] = "Senha é obrigatória";
    }
    if ($password !== $confirm_password) {
        $errors[] = "As senhas não correspondem";
    }
    if (strlen($password) < 6) {
        $errors[] = "A senha deve ter no mínimo 6 caracteres";
    }

    // Verificar se user já existe
    $username = sanitize($username);
    $email = sanitize($email);
    
    $sql = "SELECT id FROM usuarios WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Usuário ou email já cadastrado";
    }
    $stmt->close();

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    // Registrar usuário
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (username, email, password, data_criacao) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $stmt->close();
        return ['success' => true, 'message' => 'Usuário registrado com sucesso! Faça login para continuar.'];
    } else {
        $stmt->close();
        return ['success' => false, 'errors' => ['Erro ao registrar usuário']];
    }
}

// Fazer login
function loginUser($username, $password) {
    global $conn;
    $errors = [];

    if (empty($username) || empty($password)) {
        $errors[] = "Usuário e senha são obrigatórios";
    }

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $username = sanitize($username);
    $sql = "SELECT id, username, email, password FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['login_time'] = time();
            
            $stmt->close();
            return ['success' => true, 'message' => 'Login realizado com sucesso!'];
        } else {
            $errors[] = "Senha incorreta";
        }
    } else {
        $errors[] = "Usuário não encontrado";
    }

    $stmt->close();
    return ['success' => false, 'errors' => $errors];
}

// Fazer logout
function logoutUser() {
    session_destroy();
    redirect('login.php');
}

// Verificar sessão expirada (30 minutos)
function checkSessionTimeout() {
    $timeout = 30 * 60; // 30 minutos
    
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
        logoutUser();
    }
    
    $_SESSION['login_time'] = time();
}
?>
