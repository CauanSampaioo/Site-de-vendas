# Sistema de Login PHP - GameTech

## 📋 Descrição
Sistema completo de autenticação e login para a loja GameTech, desenvolvido com PHP e MySQL.

## 🚀 Arquivos Criados

### 1. **config.php**
- Configuração de conexão com banco de dados
- Definição de constantes
- Funções auxiliares

### 2. **auth.php**
- Função `registerUser()` - Registra novo usuário
- Função `loginUser()` - Faz login de usuário
- Função `logoutUser()` - Faz logout
- Função `checkSessionTimeout()` - Verifica timeout de sessão (30 minutos)
- Validações de segurança

### 3. **login.php**
- Página de login
- Validação de credenciais
- Redirecionamento automático se já estiver logado

### 4. **register.php**
- Página de registro de novo usuário
- Validação de formulário
- Verificação de user/email duplicados
- Hash de senha com `password_hash()`

### 5. **dashboard.php**
- Página protegida (somente logados)
- Exibição de informações do usuário
- Tabela de produtos em destaque
- Funcionalidade de carrinho (localStorage)
- Resumo da conta

### 6. **database.sql**
- Script para criar banco de dados
- Tabelas: usuarios, pedidos, pedidos_itens
- Índices para performance

## ⚙️ Instalação

### 1. Criar Banco de Dados
```bash
# Abra o phpMyAdmin ou MySQL Client e execute:
mysql -u root < database.sql
```

Ou copie todo o conteúdo de `database.sql` e execute no phpMyAdmin.

### 2. Configurar `config.php`
Edite as constantes de conexão se necessário:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Sua senha MySQL
define('DB_NAME', 'gametech');
```

### 3. Coloque os arquivos na pasta do servidor
- **XAMPP**: `C:\xampp\htdocs\primeiroSite`
- **WAMP**: `C:\wamp\www\primeiroSite`
- **LAMP**: `/var/www/html/primeiroSite`

### 4. Acesse pela URL
```
http://localhost/primeiroSite/index.html
```

## 🔐 Recursos de Segurança

- ✅ Senhas criptografadas com `password_hash()`
- ✅ Proteção contra SQL Injection (Prepared Statements)
- ✅ XSS prevention com `htmlspecialchars()`
- ✅ Sanitização de entrada com `stripslashes()` e `trim()`
- ✅ Timeout de sessão (30 minutos)
- ✅ Validação de email
- ✅ Confirmação de senha no registro

## 📱 Fluxo de Navegação

```
index.html (Loja pública)
    ↓
    ├→ [Link de Login] → login.php
    │      ↓
    │      ├→ [Registrar] → register.php
    │      │     ↓
    │      │     [Login bem-sucedido] → dashboard.php
    │      │
    │      └→ [Login bem-sucedido] → dashboard.php
    │
    └→ [Botão Minha Conta] → dashboard.php (se logado)

dashboard.php (Área Protegida)
    ↓
    ├→ [Sair] → logout (volta a login.php)
    ├→ [Voltar à Loja] → index.html
    └→ [Funções: Adicionar ao Carrinho, Ver Pedidos, etc.]
```

## 🎨 Funcionalidades

### Para Usuários Não Logados
- Visualizar loja e produtos
- Página de login
- Página de registro

### Para Usuários Logados
- Dashboard pessoal
- Ver resumo de conta
- Visualizar produtos em destaque
- Adicionar/remover itens do carrinho
- Ver histórico de compras (expandível)
- Logout seguro

## 💾 Estrutura do Banco de Dados

### Tabela `usuarios`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | ID único |
| username | VARCHAR(50) | Nome de usuário único |
| email | VARCHAR(100) | Email único |
| password | VARCHAR(255) | Senha criptografada |
| data_criacao | TIMESTAMP | Data de registro |
| data_atualizacao | TIMESTAMP | Última atualização |
| ativo | TINYINT | Status do usuário |

### Tabela `pedidos`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | ID único |
| usuario_id | INT | Referência ao usuário |
| total | DECIMAL | Valor total |
| data_pedido | TIMESTAMP | Data do pedido |
| status | VARCHAR(20) | Status (pendente/completo) |

### Tabela `pedidos_itens`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | ID único |
| pedido_id | INT | Referência ao pedido |
| produto_nome | VARCHAR(100) | Nome do produto |
| preco | DECIMAL | Preço unitário |
| quantidade | INT | Quantidade |

## 🔗 URLs Principais

- `http://localhost/primeiroSite/index.html` - Loja principal
- `http://localhost/primeiroSite/login.php` - Login
- `http://localhost/primeiroSite/register.php` - Registro
- `http://localhost/primeiroSite/dashboard.php` - Dashboard (protegido)

## 🧪 Teste Rápido

1. Abra `register.php`
2. Crie uma conta: 
   - Username: `testuser`
   - Email: `test@example.com`
   - Senha: `123456`
3. Faça login com estas credenciais
4. Você será redirecionado para o dashboard

## ⚠️ Notas Importantes

- O arquivo `config.php` contém dados sensíveis - não fazer upload em repositórios públicos!
- Para produção, use variáveis de ambiente em vez de hardcoded
- Considerar adicionar CSRF tokens para melhor segurança
- Implementar rate limiting para evitar brute force
- Adicionar logs de login para auditoria

## 📝 Próximas Melhorias (Opcional)

- [ ] Recuperação de senha por email
- [ ] Autenticação de dois fatores (2FA)
- [ ] OAuth/Login social
- [ ] Confirmação de email ao registrar
- [ ] Histórico detalhado de compras
- [ ] Sistema de comentários/avaliações
- [ ] Cupons e promoções
- [ ] Dashboard administrativo

## 📧 Suporte
Para dúvidas, consulte a documentação PHP oficial ou entre em contato.

---
**GameTech © 2026** - Loja Especializada em Peças para Computadores Gamers
