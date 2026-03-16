# 🎮 GameTech - Site de Vendas de Peças Gamer

## 📁 Estrutura do Projeto (Padrão MVC)

```
primeiroSite/
│
├── public/                          # Arquivos acessíveis publicamente
│   ├── index.php                   # Ponto de entrada (router principal)
│   ├── css/
│   │   ├── style.css              # Estilos CSS da aplicação
│   │   └── bootstrap.css          # (opcional) Framework CSS
│   ├── js/
│   │   ├── script.js              # JavaScript do frontend
│   │   └── jquery.js              # (opcional) Biblioteca JS
│   └── uploads/                    # Diretório para uploads de usuários
│
├── app/                             # Código da aplicação (não acessível)
│   │
│   ├── config/                     # Configurações
│   │   ├── config.php             # Constantes e configurações globais
│   │   └── Database.php           # Classe de conexão com BD
│   │
│   ├── controllers/                # Controladores
│   │   ├── HomeController.php     # Controlador da página inicial
│   │   ├── AuthController.php     # Controlador de autenticação
│   │   ├── DashboardController.php# Controlador do dashboard
│   │   └── ProductController.php  # Controlador de produtos
│   │
│   ├── models/                     # Modelos (classes de dados)
│   │   ├── User.php               # Modelo de usuário
│   │   ├── Product.php            # Modelo de produto
│   │   └── Order.php              # Modelo de pedido
│   │
│   ├── views/                      # Visualizações (HTML)
│   │   ├── layouts/
│   │   │   ├── main.php           # Layout principal
│   │   │   ├── header.php         # Cabeçalho comum
│   │   │   └── footer.php         # Rodapé comum
│   │   ├── auth/
│   │   │   ├── login.php          # Página de login
│   │   │   └── register.php       # Página de registro
│   │   ├── home/
│   │   │   └── index.php          # Página inicial
│   │   ├── dashboard/
│   │   │   └── index.php          # Dashboard do usuário
│   │   └── products/
│   │       ├── list.php           # Listagem de produtos
│   │       └── detail.php         # Detalhe do produto
│   │
│   └── helpers/                    # Funções auxiliares
│       ├── AuthHelper.php         # Funções de autenticação
│       └── ValidationHelper.php   # Validações
│
├── database/                        # Scripts SQL
│   └── gametech.sql               # Script de criação do BD
│
├── storage/                         # Arquivos de armazenamento
│   └── logs/                       # Logs da aplicação
│
├── public_html/                     # (Opcional) Cópia de public para produção
│
├── .htaccess                        # Rewrite rules (Apache)
├── .gitignore                       # Arquivos a ignorar no Git
├── .env.example                     # Exemplo de variáveis de ambiente
├── README.md                        # Este arquivo
└── GUIA_RAPIDO.txt                # Guia de instalação rápida
```

## 🚀 Como Iniciar

### 1. **Requisitos**
- PHP 7.4+
- MySQL 5.7+
- Apache com mod_rewrite
- Composer (opcional)

### 2. **Instalação**

```bash
# 1. Clonar ou baixar o projeto
git clone https://github.com/CauanSampaioo/Site-de-vendas.git
cd primeiroSite

# 2. Criar arquivo .env (cópia de .env.example)
cp .env.example .env

# 3. Configurar banco de dados em .env
# DATABASE_HOST=localhost
# DATABASE_USER=root
# DATABASE_PASS=
# DATABASE_NAME=gametech

# 4. Criar banco de dados
mysql -u root < database/gametech.sql

# 5. Iniciar servidor (XAMPP) ou:
php -S localhost:8000 -t public
```

### 3. **Acessar a Aplicação**

- **Desenvolvimento**: `http://localhost:8000`
- **Produção**: `http://seu-dominio.com`
- **Login**: `http://localhost:8000/auth/login`
- **Registro**: `http://localhost:8000/auth/register`
- **Dashboard**: `http://localhost:8000/dashboard` (logado)

## 📋 Padrão MVC Explicado

### **Model** (Modelo)
- Representa os dados da aplicação
- Interage com o banco de dados
- Exemplos: `User.php`, `Product.php`

```php
class User {
    public static function findById($id) { ... }
    public function save() { ... }
}
```

### **View** (Visualização)
- Arquivos HTML/PHP que exibem dados
- Recebem dados do Controller
- Localizadas em `app/views/`

```php
<!-- app/views/products/list.php -->
<?php foreach ($products as $product): ?>
    <div><?php echo $product['name']; ?></div>
<?php endforeach; ?>
```

### **Controller** (Controlador)
- Processa requisições do usuário
- Chama Models para obter dados
- Retorna Views com dados
- Localizadas em `app/controllers/`

```php
class ProductController {
    public function list() {
        $products = Product::all();
        return [
            'view' => 'products/list',
            'data' => $products
        ];
    }
}
```

## 🔄 Fluxo de Uma Requisição

```
1. Usuário acessa: http://localhost/produtos
   ↓
2. public/index.php (index.php) captura a rota
   ↓
3. Router identifica: ProductController::list()
   ↓
4. ProductController processa e chama Model
   ↓
5. Model::all() busca dados no BD
   ↓
6. Dados retornam ao Controller
   ↓
7. Controller passa dados para View
   ↓
8. View renderiza HTML com dados
   ↓
9. Usuário vê a página
```

## 🔐 Segurança

### ✅ Implementado
- Senhas criptografadas (password_hash)
- Prepared Statements (previne SQL Injection)
- Sanitização de entrada (XSS prevention)
- Sessões seguras
- CSRF tokens

### 🔒 Recomendações de Produção
```php
// .env
DEBUG=false
SESSION_SECURE=true
SESSION_HTTPONLY=true
SSL=https
```

## 📦 Estrutura de Arquivos Importantes

| Arquivo | Função |
|---------|--------|
| `public/index.php` | Entrada da aplicação (única página acessível) |
| `app/config/config.php` | Configurações globais |
| `app/config/Database.php` | Classe de conexão com BD |
| `.htaccess` | Rewrite rules (URL amigável) |
| `.gitignore` | Arquivos a ignorar no Git |

## 🎯 Funcionalidades Implementadas

### ✅ Autenticação
- [x] Registro de usuário
- [x] Login seguro
- [x] Logout
- [x] Sessão com timeout
- [x] Recuperação de senha (TODO)

### ✅ Produtos
- [x] Listagem de produtos
- [x] Detalhes do produto
- [x] Carrinho de compras (localStorage)
- [x] Filtro por categoria

### ✅ Dashboard
- [x] Informações do usuário
- [x] Histórico de compras
- [x] Perfil do usuário
- [x] Logout

### 🔄 Em Desenvolvimento
- [ ] Integração de pagamento
- [ ] Avaliações de produtos
- [ ] Cupons de desconto
- [ ] Admin panel

## 📱 Responsividade

O projeto usa CSS com media queries:
```css
/* Mobile first */
@media (min-width: 768px) { }
@media (min-width: 1024px) { }
```

## 🧪 Teste Rápido

```bash
# 1. Registre uma conta
Usar: username=testuser, email=test@test.com, password=123456

# 2. Faça login
Usar as credenciais acima

# 3. Explore o dashboard
Adicione produtos ao carrinho

# 4. Verifique no console (F12)
localStorage mostra o carrinho
```

## 🛠️ Ferramentas e Tecnologias

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Servidor**: Apache
- **Versionamento**: Git/GitHub

## 📚 Estrutura de Pastas - Checklist

```
✓ public/           - Arquivos públicos (index.php, css/, js/)
✓ app/config/       - Configuração (config.php, Database.php)
✓ app/controllers/  - Controladores (Home, Auth, Dashboard, Product)
✓ app/models/       - Modelos (User, Product, Order)
✓ app/views/        - Views (layouts/, auth/, home/, dashboard/, products/)
✓ app/helpers/      - Funções auxiliares
✓ database/         - Scripts SQL
✓ storage/logs/     - Logs da aplicação
✓ .gitignore        - Arquivo de ignoração Git
✓ .htaccess         - Rewrite rules
```

## 📝 Convenções de Código

### Nomeação de Classes
```php
// Controllers (sufixo "Controller")
class ProductController { }

// Models (singular)
class User { }

// Helpers (sufixo "Helper")
class ValidationHelper { }
```

### Nomeação de Métodos
```php
// GET data
public function index() { }    // Listar todos
public function show($id) { }  // Mostrar um

// POST/PUT/DELETE
public function store() { }    // Criar
public function update() { }   // Atualizar
public function destroy() { }  // Deletar
```

## 🐛 Troubleshooting

### Erro: "File not found"
- Verifique se mod_rewrite está ativado
- Verifique o path das requires nos controllers

### Erro: "Database connection failed"
- Verifique credenciais em `.env`
- Certifique-se que MySQL está rodando
- Execute `database/gametech.sql`

### Erro: "Class not found"
- Verifique se o arquivo existe no caminho correto
- Verifique se a classe tem o mesmo nome do arquivo

## 📞 Suporte

- 📖 Documentação: [README.md](README.md)
- 🐛 Issues: [GitHub Issues](https://github.com/CauanSampaioo/Site-de-vendas/issues)
- 💬 Discussões: [GitHub Discussions](https://github.com/CauanSampaioo/Site-de-vendas/discussions)

---

**GameTech © 2026** - Loja Especializada em Peças para Computadores Gamers

Desenvolvido com ❤️ usando o padrão MVC
