# GameTech - Arquitetura MVC

## 📁 Estrutura do Projeto

```
primeiroSite/
├── public/                    # Arquivos públicos e ponto de entrada
│   ├── index.php             # Ponto de entrada da aplicação
│   ├── css/
│   │   └── style.css         # Estilos CSS
│   └── js/
│       └── script.js         # JavaScript do cliente
│
├── app/                       # Código da aplicação
│   ├── config/               # Configurações
│   │   ├── config.php        # Configurações gerais
│   │   └── Database.php      # Classe de conexão com BD
│   │
│   ├── models/               # Modelos (banco de dados)
│   │   └── User.php          # Model de usuários
│   │
│   ├── controllers/          # Controladores (lógica)
│   │   ├── AuthController.php     # Login, registro, logout
│   │   ├── HomeController.php     # Página inicial
│   │   └── DashboardController.php # Painel do usuário
│   │
│   └── views/                # Visualizações (templates)
│       ├── layouts/          # Layouts compartilhados
│       │   ├── main.php      # Layout principal
│       │   ├── header.php    # Cabeçalho
│       │   └── footer.php    # Rodapé
│       ├── home/             # Views da home
│       │   └── index.php
│       ├── auth/             # Views de autenticação
│       │   ├── login.php
│       │   └── register.php
│       └── dashboard/        # Views do dashboard
│           └── index.php
│
├── database/                 # Scripts do banco de dados
│   └── database.sql         # Schema inicial
│
├── storage/                  # Armazenamento
│   └── logs/                # Logs da aplicação
│
├── .htaccess                # Rewrite rules
├── GUIA_RAPIDO.txt          # Guia de instalação
└── README_LOGIN.md          # Documentação de autenticação
```

## 🏗️ Padrão MVC

### Model (Modelo)
Localizado em `app/models/`

**Responsabilidade**: Gerenciar dados e lógica de banco de dados
- `User.php` - Operações com usuários (CRUD)

```php
$user = new User();
$result = $user->login($username, $password);
```

### Controller (Controlador)
Localizado em `app/controllers/`

**Responsabilidade**: Processar requisições e coordenar entre Model e View

- `AuthController.php` - Autenticação (login, registro, logout)
- `HomeController.php` - Página inicial e produtos
- `DashboardController.php` - Painel do usuário

```php
$controller = new HomeController();
$data = $controller->index();
```

### View (Visualização)
Localizado em `app/views/`

**Responsabilidade**: Apresentar dados ao usuário

- Exemplo de uma view simples:
```php
// app/views/home/index.php
<h1><?php echo $title; ?></h1>
```

## 🔄 Fluxo de Requisição

1. Requisição entra em `public/index.php`
2. Arquivo de config carrega configurações e classes
3. URL é analisada para determinar qual controller
4. Controller processa a lógica
5. Model interage com o banco de dados
6. View apresenta os dados

```
URL → index.php → Router → Controller → Model/View → HTML
```

## 🚀 Como Usar

### 1. Adicionar Rota
Edite `public/index.php` para adicionar nova rota:

```php
elseif ($request === 'nova-pagina') {
    require_once APP_PATH . '/controllers/NovoController.php';
    // ... código
}
```

### 2. Criar Controller
Crie arquivo em `app/controllers/NovoController.php`:

```php
class NovoController
{
    public function index()
    {
        return ['title' => 'Minha Página'];
    }
}
```

### 3. Criar Model
Crie arquivo em `app/models/Novo.php`:

```php
class Novo
{
    private $db;
    private $table = 'novos';
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
}
```

### 4. Criar View
Crie arquivo em `app/views/novo/index.php`:

```php
<h1><?php echo $title; ?></h1>
```

## 📚 Funções Auxiliares

Disponíveis em `app/config/config.php`:

```php
view($viewName, $data = [])     // Renderizar view
redirect($url)                   // Redirecionar
isLoggedIn()                     // Verificar login
getUsername()                    // Obter nome do usuário
sanitize($data)                  // Sanitizar entrada
formatPrice($price)              // Formatar preço
log_error($message)              // Registrar erro
```

## 🔐 Segurança

- **SQL Injection**: Prepared Statements
- **XSS**: htmlspecialchars() em outputs
- **CSRF**: Verificação de sessão
- **Autenticação**: password_hash() para senhas
- **Autorização**: Verificação de sessão em rotas protegidas

## ♻️ Auto-load de Classes

As classes são carregadas automaticamente pela função em `config.php`:

```php
spl_autoload_register(function ($class) {
    // Procura em models/, controllers/, config/
});
```

Não precisa fazer `require_once` manualmente!

## 🗄️ Banco de Dados

### Singleton Pattern
`Database.php` usa Singleton para garantir uma única conexão:

```php
$db = Database::getInstance();
$connection = $db->getConnection();
```

### Prepared Statements
Sempre use prepared statements:

```php
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
```

## 📝 Convenções

- **Nomes de Classes**: PascalCase (UserController, User)
- **Nomes de Arquivos**: PascalCase.php (UserController.php)
- **Nomes de Métodos**: camelCase (getUserById)
- **Nomes de Variáveis**: camelCase (userName, totalItems)
- **Constantes**: UPPER_CASE (APP_NAME, DB_HOST)

## 🧪 Testando

### Teste LocalHost
```
http://localhost/primeiroSite/
http://localhost/primeiroSite/login
http://localhost/primeiroSite/register
http://localhost/primeiroSite/dashboard
```

### Verificar Logs
```
/storage/logs/errors.log
```

## 📊 Extensões Futuras

1. **Adicionar novo Model**
   - Criar arquivo em `app/models/`
   - Implementar métodos CRUD

2. **Adicionar novo Controller**
   - Criar arquivo em `app/controllers/`
   - Adicionar rota em `public/index.php`

3. **Adicionar nova View**
   - Criar pasta em `app/views/`
   - Criar arquivo `.php` com HTML

4. **Adicionar nova Rota**
   - Editar `public/index.php`
   - Adicionar `elseif` para nova URL

## 🚨 Troubleshooting

**Erro: Class not found**
- Verify classe está em `models/`, `controllers/` ou `config/`
- Check nome do arquivo e classe coincidem

**Erro: view não encontrada**
- Verify caminho está correto
- Check se arquivo `.php` existe

**Banco de dados não conecta**
- Verifique credenciais em `app/config/config.php`
- Confirme MySQL está rodando
- Execute `install.php`

## 📖 Referências

- [PHP PDO](https://www.php.net/manual/pt_BR/book.pdo.php)
- [MVC Architecture](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)
- [PHP Best Practices](https://www.php-fig.org/psr/)

---

**GameTech © 2026** - Loja de Peças Gamer com Arquitetura MVC
