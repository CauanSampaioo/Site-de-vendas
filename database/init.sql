-- ================================================================
-- Script de Inicialização do Banco de Dados - GameTech
-- ================================================================
-- Este script cria todas as tabelas necessárias para o GameTech
-- Execute este arquivo no seu banco de dados MySQL

-- ================================================================
-- Tabela: usuarios
-- ================================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL COMMENT 'Nome de usuário único',
    email VARCHAR(100) UNIQUE NOT NULL COMMENT 'Email para login',
    senha VARCHAR(255) NOT NULL COMMENT 'Senha criptografada com bcrypt',
    nome_completo VARCHAR(100) COMMENT 'Nome completo do usuário',
    cpf VARCHAR(14) UNIQUE COMMENT 'CPF para validação de compra',
    telefone VARCHAR(15) COMMENT 'Telefone de contato',
    endereco_rua VARCHAR(255) COMMENT 'Rua do endereço de entrega',
    endereco_numero VARCHAR(10) COMMENT 'Número do endereço',
    endereco_bairro VARCHAR(100) COMMENT 'Bairro',
    endereco_cidade VARCHAR(100) COMMENT 'Cidade',
    endereco_estado VARCHAR(2) COMMENT 'Estados (UF)',
    endereco_cep VARCHAR(10) COMMENT 'CEP de entrega',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criação da conta',
    ultimo_login TIMESTAMP NULL COMMENT 'Último acesso do usuário',
    ativo TINYINT DEFAULT 1 COMMENT 'Status ativo/inativo',
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_data_criacao (data_criacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabela de usuários do sistema';

-- ================================================================
-- Tabela: pedidos
-- ================================================================
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL COMMENT 'ID do usuário que fez o pedido',
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Data/hora do pedido',
    valor_total DECIMAL(10, 2) NOT NULL COMMENT 'Valor total do pedido',
    status ENUM('pendente', 'processando', 'enviado', 'entregue', 'cancelado') DEFAULT 'pendente' COMMENT 'Status do pedido',
    nota_descricao LONGTEXT COMMENT 'Notas adicionais do pedido',
    data_entrega TIMESTAMP NULL COMMENT 'Data prevista de entrega',
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_status (status),
    INDEX idx_data_pedido (data_pedido)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabela de pedidos (vendas)';

-- ================================================================
-- Tabela: pedidos_itens
-- ================================================================
CREATE TABLE IF NOT EXISTS pedidos_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL COMMENT 'ID do pedido relacionado',
    produto_nome VARCHAR(255) NOT NULL COMMENT 'Nome do produto',
    produto_categoria VARCHAR(100) COMMENT 'Categoria (CPU, GPU, RAM, etc)',
    quantidade INT NOT NULL COMMENT 'Quantidade de itens',
    preco_unitario DECIMAL(10, 2) NOT NULL COMMENT 'Preço unitário',
    subtotal DECIMAL(10, 2) NOT NULL COMMENT 'quantidade x preco_unitario',
    
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    INDEX idx_pedido_id (pedido_id),
    INDEX idx_categoria (produto_categoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Itens individuais de cada pedido';

-- ================================================================
-- Tabela: produtos (Futura - para controle de estoque)
-- ================================================================
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao LONGTEXT,
    categoria VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT DEFAULT 0,
    ativo TINYINT DEFAULT 1,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_categoria (categoria),
    INDEX idx_preco (preco)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Catálogo de produtos';

-- ================================================================
-- Tabela: categorias_produtos
-- ================================================================
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) UNIQUE NOT NULL,
    descricao TEXT,
    imagem_url VARCHAR(255),
    ativa TINYINT DEFAULT 1,
    
    INDEX idx_nome (nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Categorias de produtos';

-- ================================================================
-- Inserir Dados Iniciais
-- ================================================================

-- Inserir categorias padrão
INSERT IGNORE INTO categorias (nome, descricao) VALUES 
('CPU', 'Processadores (Intel, AMD)'),
('GPU', 'Placas de vídeo (NVIDIA, AMD)'),
('RAM', 'Memória RAM'),
('SSD', 'Unidades de armazenamento SSD'),
('Placa-mãe', 'Placas mãe diversos soquetes'),
('Fonte', 'Fontes de alimentação'),
('Cooling', 'Sistemas de resfriamento (Ar/Água)'),
('Gabinete', 'Gabinetes para PC');

-- Criar usuário de teste (OPCIONAL)
-- Username: testgamer
-- Email: teste@gametech.com
-- Senha: Senha123
-- Senha criptografada com password_hash('Senha123', PASSWORD_BCRYPT)
INSERT IGNORE INTO usuarios 
(username, email, senha, nome_completo, data_criacao, ativo) 
VALUES 
('testgamer', 'teste@gametech.com', '$2y$10$YourHashedPasswordHere', 'Teste Gamer', NOW(), 1);

-- ================================================================
-- Views (Opcional - para relatórios)
-- ================================================================

-- View: Resumo de Pedidos por Usuário
CREATE OR REPLACE VIEW vw_pedidos_usuario AS
SELECT 
    u.id,
    u.username,
    u.email,
    COUNT(p.id) as total_pedidos,
    SUM(p.valor_total) as valor_total_gasto,
    MAX(p.data_pedido) as ultimo_pedido
FROM usuarios u
LEFT JOIN pedidos p ON u.id = p.usuario_id
GROUP BY u.id, u.username, u.email;

-- View: Produtos mais vendidos
CREATE OR REPLACE VIEW vw_produtos_populares AS
SELECT 
    pi.produto_nome,
    pi.produto_categoria,
    COUNT(*) as vezes_vendido,
    SUM(pi.quantidade) as quantidade_total,
    AVG(pi.preco_unitario) as preco_medio
FROM pedidos_itens pi
GROUP BY pi.produto_nome, pi.produto_categoria
ORDER BY vezes_vendido DESC;

-- ================================================================
-- Índices Adicionais para Performance
-- ================================================================

ALTER TABLE usuarios ADD UNIQUE INDEX idx_unique_cpf (cpf);
ALTER TABLE pedidos ADD INDEX idx_valor_total (valor_total);
ALTER TABLE pedidos_itens ADD INDEX idx_categoria_produto (produto_categoria);

-- ================================================================
-- Fim do Script
-- ================================================================
-- Para executar este script:
-- mysql -u root -p gametech < database/init.sql
--
-- Ou via phpMyAdmin:
-- 1. Criar banco 'gametech'
-- 2. Ir para aba SQL
-- 3. Copiar e colar este conteúdo
-- 4. Executar

-- ================================================================
-- Verificação Final
-- ================================================================
SHOW TABLES;
SELECT COUNT(*) as total_usuarios FROM usuarios;
SELECT COUNT(*) as total_pedidos FROM pedidos;
