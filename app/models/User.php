<?php
/**
 * Model: User
 * Gerencia operações com usuários no banco de dados
 */
require_once __DIR__ . '/../config/Database.php';

class User
{
    private $db;
    private $table = 'usuarios';
    private $id;
    private $username;
    private $email;
    private $password;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Registrar novo usuário
     */
    public function register($username, $email, $password, $confirm_password)
    {
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
        
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        // Verificar duplicatas
        $username = htmlspecialchars(stripslashes(trim($username)));
        $email = htmlspecialchars(stripslashes(trim($email)));
        
        $sql = "SELECT id FROM {$this->table} WHERE username = ? OR email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $errors[] = "Usuário ou email já cadastrado";
            return ['success' => false, 'errors' => $errors];
        }
        
        $stmt->close();
        
        // Registrar usuário
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO {$this->table} (username, email, password, data_criacao) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'Usuário registrado com sucesso!'];
        }
        
        $stmt->close();
        return ['success' => false, 'errors' => ['Erro ao registrar usuário']];
    }
    
    /**
     * Fazer login
     */
    public function login($username, $password)
    {
        $errors = [];
        
        if (empty($username) || empty($password)) {
            $errors[] = "Usuário e senha são obrigatórios";
        }
        
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $username = htmlspecialchars(stripslashes(trim($username)));
        $sql = "SELECT id, username, email, password FROM {$this->table} WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->email = $user['email'];
                
                $stmt->close();
                return ['success' => true, 'user' => $user];
            } else {
                $errors[] = "Senha incorreta";
            }
        } else {
            $errors[] = "Usuário não encontrado";
        }
        
        $stmt->close();
        return ['success' => false, 'errors' => $errors];
    }
    
    /**
     * Buscar usuário por ID
     */
    public function getUserById($id)
    {
        $sql = "SELECT id, username, email, data_criacao FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    /**
     * Atualizar usuário
     */
    public function update($id, $username, $email)
    {
        $sql = "UPDATE {$this->table} SET username = ?, email = ?, data_atualizacao = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $username, $email, $id);
        return $stmt->execute();
    }
    
    /**
     * Deletar usuário
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    /**
     * Listar todos os usuários
     */
    public function getAll()
    {
        $sql = "SELECT id, username, email, data_criacao FROM {$this->table}";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}
?>
