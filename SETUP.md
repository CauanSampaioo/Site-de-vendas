# 📋 Guia de Instalação e Setup Local - GameTech

Bem-vindo! Este guia orienta você na configuração do GameTech em seu ambiente local.

## 🔧 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **PHP 7.4+** - Linguagem backend
- **MySQL 5.7+** - Banco de dados
- **Apache com mod_rewrite** - Servidor web
- **Git** - Controle de versão
- **Composer** (opcional) - Gerenciador de dependências PHP

### Recomendado para Windows

- **XAMPP** - Pacote completo com Apache, MySQL, PHP e phpMyAdmin

## 🚀 Passo 1: Clonar o Repositório

```bash
# Clone o repositório
git clone https://github.com/CauanSampaioo/Site-de-vendas.git

# Entre no diretório
cd Site-de-vendas
```

## ⚙️ Passo 2: Configurar Variáveis de Ambiente

```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Edite o arquivo .env com suas configurações
# Atualize os dados de conexão com o banco de dados
```

### Conteúdo Básico do `.env`

```env
# Banco de Dados
DATABASE_HOST=localhost
DATABASE_PORT=3306
DATABASE_NAME=gametech
DATABASE_USER=root
DATABASE_PASS=

# Aplicação
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost/primeiroSite

# Sessão
SESSION_LIFETIME=1800
SESSION_SECURE=false
SESSION_HTTPONLY=true
```

## 🗄️ Passo 3: Criar o Banco de Dados

### Opção 1: Via phpMyAdmin (Recomendado para iniciantes)

1. Abra `http://localhost/phpmyadmin`
2. Clique em "Nova" para criar novo banco
3. Nomeie como `gametech`
4. Execute o SQL abaixo:

```sql
-- Criar tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nome_completo VARCHAR(100),
    cpf VARCHAR(14) UNIQUE,
    telefone VARCHAR(15),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_login TIMESTAMP NULL,
    ativo TINYINT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criar tabela de pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10, 2),
    status ENUM('pendente', 'processando', 'enviado', 'entregue', 'cancelado') DEFAULT 'pendente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criar tabela de itens do pedido
CREATE TABLE pedidos_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_nome VARCHAR(255) NOT NULL,
    produto_categoria VARCHAR(100),
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Opção 2: Via MySQL CLI

```bash
# Acesse o MySQL
mysql -u root -p

# Execute o script SQL
source database/init.sql

# Ou manualmente copie e cole o SQL acima
```

## 🌐 Passo 4: Configurar o Servidor Web

### Para XAMPP:

1. **Copie o projeto** para `C:\xampp\htdocs\primeiroSite`

2. **Inicie XAMPP**:
   - Apache
   - MySQL

3. **Acesse**: `http://localhost/primeiroSite`

### Para Servidor Local (sem XAMPP):

Se estiver usando Apache nativo:

1. Coloque o projeto em `C:\Apache24\htdocs\primeiroSite` (Windows)
   ou `/var/www/html/primeiroSite` (Linux)

2. Configure o `.htaccess` para rewrite (já incluído no projeto)

3. Reinicie o Apache:
   ```bash
   sudo systemctl restart apache2  # Linux
   # ou no Windows: net stop Apache2.4 && net start Apache2.4
   ```

## 👤 Passo 5: Criar Usuário Teste

Após iniciar o servidor, acesse `http://localhost/primeiroSite/login` e:

1. Clique em **Registrar**
2. Preencha:
   - Usuário: `testgamer`
   - Email: `teste@gametech.com`
   - Senha: `Senha123`
3. Clique em **Registrar**

## ✅ Passo 6: Testar Fluxos Principais

- [ ] **Homepage**: `http://localhost/primeiroSite`
- [ ] **Login**: `http://localhost/primeiroSite/login` (testgamer / Senha123)
- [ ] **Registro**: `http://localhost/primeiroSite/register`
- [ ] **Dashboard**: `http://localhost/primeiroSite/dashboard` (após login)
- [ ] **Logout**: Clique em "Sair" na página de dashboard

## 🐛 Troubleshooting

### Erro: "Banco de dados não encontrado"
- **Solução**: Certifique-se que o banco `gametech` foi criado
- Verifique o `DATABASE_NAME` em `.env`

### Erro: "Acesso negado para usuário 'root'"
- **Solução**: Sua senha MySQL não é em branco
- Atualize `DATABASE_USER` e `DATABASE_PASS` em `.env`

### Erro: 404 ou "Página não encontrada"
- **Solução**: Verifique se o mod_rewrite está ativado em Apache
- Teste acessando: `http://localhost/primeiroSite/public/index.php`

### Erro: "Falha ao conectar ao banco"
- **Solução**: Certifique-se que MySQL está rodando
- XAMPP: Clique em "Start" ao lado de MySQL
- CLI: `mysql -u root` deve conectar

### Sessão expirando rapidamente
- **Solução**: Ajuste `SESSION_LIFETIME` em `.env` (em segundos)
- Padrão: 1800 = 30 minutos

## 📝 Estrutura de Diretórios

```
primeiroSite/
├── app/
│   ├── config/          # Configurações da aplicação
│   ├── controllers/     # Lógica de negócio
│   ├── models/          # Interação com banco de dados
│   └── views/           # Templates HTML
├── public/              # Arquivos públicos
│   ├── index.php        # Ponto de entrada
│   ├── css/             # Estilos
│   └── js/              # Scripts
├── database/            # Scripts SQL
├── storage/logs/        # Arquivos de log
├── .env                 # Variáveis de ambiente (criar)
├── .env.example         # Exemplo de variáveis
├── .gitignore          # Arquivos ignorados pelo Git
├── README.md           # Documentação principal
└── SETUP.md            # Este arquivo
```

## 🔒 Dicas de Segurança

### Para Desenvolvimento Local:
- Mantenha `APP_DEBUG=true` apenas em desenvolvimento
- Use `SESSION_SECURE=false` apenas localmente

### Para Produção:
- Altere `APP_DEBUG=false`
- Configure `SESSION_SECURE=true`
- Use HTTPS (SSL/TLS)
- Mude a senha padrão do banco de dados
- Configure `SESSION_SAMESITE=Strict`

## 📚 Próximos Passos

1. Abra [DEPLOYMENT.md](DEPLOYMENT.md) para publicar em produção
2. Veja [README.md](README.md) para documentação completa
3. Explore [app/](./app/) e estude a arquitetura MVC

## ❓ Dúvidas?

Consulte:
- [README.md](README.md) - Documentação principal
- [README_MVC.md](README_MVC.md) - Padrão MVC
- [DEPLOYMENT.md](DEPLOYMENT.md) - Deploy em produção
- [GUIA_RAPIDO.txt](GUIA_RAPIDO.txt) - Referência rápida

---

**Está tudo pronto!** 🎮 Comece a desenvolver seu GameTech agora!
