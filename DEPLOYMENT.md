# 🚀 Guia de Deploy em Produção - GameTech

Este documento orienta você na publicação do GameTech em um servidor de produção.

## 📋 Checklist Pré-Deploy

Antes de fazer deploy, verifique:

- [ ] Todo código está testado e funcionando localmente
- [ ] Todos os arquivos estão commitados no Git
- [ ] Branch `main` está atualizado e sem conflitos
- [ ] Base de dados está otimizada (índices criados)
- [ ] Credenciais sensíveis estão em `.env` (nunca no Git)
- [ ] SSL/HTTPS está configurado no servidor
- [ ] Backups automáticos estão configurados
- [ ] Logs estão sendo salvos em `storage/logs/`

## 🌩️ Deploy em Hosting (Hospedagem Compartilhada)

### Passo 1: Escolher Hospedagem

Recomendações:
- **Bluehost** - Bom suporte a PHP/MySQL
- **SiteGround** - Excelente performance
- **Hostinger** - Preço/qualidade
- **AWS** - Escalabilidade profissional
- **DigitalOcean** - Droplets Linux

### Passo 2: Preparar o Servidor

1. **SSH para o servidor**:
   ```bash
   ssh seu_usuario@seu_servidor.com
   cd public_html  # ou onde hospedar
   ```

2. **Clonar repositório**:
   ```bash
   git clone https://github.com/CauanSampaioo/Site-de-vendas.git primeiroSite
   cd primeiroSite
   ```

### Passo 3: Configurar Variáveis de Ambiente

```bash
# Editar/criar .env para produção
nano .env

# Adicione (substituindo valores):
APP_ENV=production
APP_DEBUG=false
DATABASE_HOST=seu_db_host
DATABASE_NAME=seu_db_name
DATABASE_USER=seu_db_user
DATABASE_PASS=sua_db_pass_segura
APP_URL=https://seudominio.com
SESSION_SECURE=true
SESSION_SAMESITE=Strict
MAIL_DRIVER=smtp
MAIL_HOST=seu_smtp_host
MAIL_USERNAME=seu_email
MAIL_PASSWORD=sua_senha_email
```

### Passo 4: Preparar Banco de Dados

```bash
# Conectar ao MySQL no servidor
mysql -u seu_usuario -p

# Executar SQL de criação (veja SETUP.md)
CREATE DATABASE gametech;
USE gametech;
-- Cole o SQL das tabelas aqui
```

### Passo 5: Configurar Apache/Nginx

#### Se usar Apache:

1. Ativar mod_rewrite:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. Configurar VirtualHost:
   ```apache
   <VirtualHost *:80>
       ServerName seudominio.com
       ServerAlias www.seudominio.com
       
       DocumentRoot /home/seu_usuario/public_html/primeiroSite/public
       
       <Directory /home/seu_usuario/public_html/primeiroSite/public>
           AllowOverride All
           Require all granted
       </Directory>
       
       # Redirect HTTP to HTTPS
       RewriteEngine On
       RewriteCond %{HTTPS} off
       RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   </VirtualHost>
   ```

#### Se usar Nginx:

```nginx
server {
    listen 443 ssl http2;
    server_name seudominio.com www.seudominio.com;
    
    root /home/seu_usuario/public_html/primeiroSite/public;
    index index.php;
    
    ssl_certificate /etc/letsencrypt/live/seudominio.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/seudominio.com/privkey.pem;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location ~ /\. {
        deny all;
    }
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name seudominio.com www.seudominio.com;
    return 301 https://$server_name$request_uri;
}
```

### Passo 6: Certificado SSL/HTTPS

#### Usar Let's Encrypt (Grátis):

```bash
# Instalar Certbot
sudo apt-get install certbot python3-certbot-apache

# Gerar certificado
sudo certbot certonly --apache -d seudominio.com -d www.seudominio.com

# Auto-renew
sudo certbot renew --dry-run
```

#### Ou usar Cloudflare:

1. Adicione o domínio ao Cloudflare
2. Configure SSL/TLS como "Full (strict)"
3. Aponte os nameservers para Cloudflare

### Passo 7: Definir Permissões

```bash
# Dar permissão de escrita para logs e uploads
chmod -R 755 primeiroSite/
chmod -R 775 primeiroSite/storage/logs/
chmod -R 775 primeiroSite/public/uploads/

# Mudar proprietário (se necessário)
sudo chown -R www-data:www-data primeiroSite/
```

### Passo 8: Instalar Dependências (se houver)

```bash
# Se usar Composer
cd primeiroSite
composer install --optimize-autoloader --no-dev
```

### Passo 9: Otimizar Performance

```bash
# Cache de opcodes (adicione ao php.ini)
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.validate_timestamps=0

# Reiniciar PHP-FPM
sudo systemctl restart php7.4-fpm
```

## ☁️ Deploy com GitHub Actions (CI/CD)

### Configurar Auto-Deploy

1. Criar arquivo `.github/workflows/deploy.yml`:

```yaml
name: Deploy to Production

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Deploy via SSH
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.HOST }}
        username: ${{ secrets.USERNAME }}
        password: ${{ secrets.PASSWORD }}
        script: |
          cd ~/public_html/primeiroSite
          git pull origin main
          composer install --optimize-autoloader
          
    - name: Notify Slack
      run: echo "Deploy concluído!"
```

2. Adicionar secrets no GitHub Settings

## 📊 Monitoramento em Produção

### Configurar Logs

Adicione ao `.env`:
```env
LOG_LEVEL=info
LOG_PATH=storage/logs
LOG_MAX_SIZE=10485760  # 10MB
LOG_MAX_FILES=14       # 2 semanas
```

### usar ferramentas de monitoramento:

- **New Relic** - APM e performance
- **Datadog** - Monitoramento full-stack
- **Sentry** - Rastreamento de erros
- **Google Analytics** - Tráfego do site

### Backup Automático

```bash
# Criar script de backup diário
crontab -e

# Adicionar:
0 2 * * * /home/seu_usuario/backup.sh

# Arquivo backup.sh:
#!/bin/bash
BACKUP_DIR="/home/seu_usuario/backups"
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u root -p$DB_PASSWORD gametech > $BACKUP_DIR/gametech_$DATE.sql
tar -czf $BACKUP_DIR/primeiroSite_$DATE.tar.gz /home/seu_usuario/public_html/primeiroSite/
```

## 🔒 Segurança em Produção

### Proteger Arquivos Sensíveis

1. Mover `.env` fora da raiz web:
   ```bash
   mv .env /home/seu_usuario/.env.gametech
   ```

2. Adicionar ao `config.php`:
   ```php
   $envFile = '/home/seu_usuario/.env.gametech';
   // Carregar variáveis
   ```

3. Proteger `app/` com `.htaccess`:
   ```apache
   <FilesMatch "\.php$">
       Deny from all
   </FilesMatch>
   ```

### Hardening de Segurança

```php
// Adiciones a config.php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/home/seu_usuario/error.log');

// Headers de segurança
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Content-Security-Policy: default-src \'self\'');
```

### Firewall (UFW - Ubuntu)

```bash
sudo ufw enable
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
```

## 📞 Troubleshooting Produção

| Erro | Causa | Solução |
|------|-------|---------|
| 500 Internal Error | Erro no código/servidor | Verificar `error_log` do Apache |
| 404 Not Found | Rewrite não configurado | Ativar `mod_rewrite` |
| Conexão recusada ao DB | Credenciais erradas | Validar `.env` |
| Página branca | PHP fatal error | Ativar `DEBUG_MODE` temporariamente |
| Lento | Performance pobre | Ativar opcache, CDN, cache |

## 📈 Após Deploy - Monitoramento

1. Testar todas as funcionalidades:
   - [ ] Homepage carrega rápido
   - [ ] Registro funciona
   - [ ] Login funciona
   - [ ] Dashboard acessível
   - [ ] Logout funciona
   - [ ] Tráfego de dados

2. Monitorar métricas:
   - Tempo de resposta < 2s
   - Taxa de erro < 1%
   - Uptime > 99%

3. Revisar logs diariamente:
   ```bash
   tail -f storage/logs/*
   ```

## 🔄 Atualizar Código em Produção

```bash
# Conectar via SSH
ssh seu_usuario@seu_servidor.com

# Ir para diretório
cd ~/public_html/primeiroSite

# Pull das atualizações
git pull origin main

# Reiniciar PHP-FPM (se aplicável)
sudo systemctl restart php7.4-fpm

# Limpar cache (se houver)
rm -rf storage/cache/*
```

## 📚 Referências

- [PHP Best Practices](https://www.php-fig.org/psr/)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Let's Encrypt](https://letsencrypt.org/)
- [Apache Documentation](https://httpd.apache.org/)
- [Nginx Documentation](https://nginx.org/)

---

**Parabéns!** 🎮 Seu GameTech está em produção! 🚀
