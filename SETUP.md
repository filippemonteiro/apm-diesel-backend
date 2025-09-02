# Guia de Configuração - APM Diesel Backend

## Pré-requisitos

Antes de executar este projeto Laravel, você precisa ter instalado:

### 1. PHP (versão 7.2.5 ou superior)
- Baixe em: https://www.php.net/downloads
- Certifique-se de que o PHP está no PATH do sistema
- Extensões necessárias:
  - php_pdo_mysql
  - php_mbstring
  - php_openssl
  - php_tokenizer
  - php_xml
  - php_ctype
  - php_json
  - php_bcmath
  - php_fileinfo

### 2. Composer
- Baixe em: https://getcomposer.org/download/
- Instale globalmente ou use o composer.phar incluído no projeto

### 3. MySQL/MariaDB
- MySQL 5.7+ ou MariaDB 10.2+
- Crie um banco de dados chamado `controllcarcom_db`

### 4. Node.js e NPM (opcional, para assets)
- Baixe em: https://nodejs.org/

## Passos para Configuração

### 1. Instalar Dependências PHP
```bash
# Se o Composer estiver instalado globalmente:
composer install

# Ou usando o composer.phar do projeto:
php composer.phar install
```

### 2. Configurar Ambiente
```bash
# Copie o arquivo de exemplo (se necessário):
cp .env.example .env

# Gere a chave da aplicação:
php artisan key:generate
```

### 3. Configurar Banco de Dados
Edite o arquivo `.env` com suas credenciais:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controllcarcom_db
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Executar Migrações
```bash
php artisan migrate
```

### 5. Instalar Dependências Node.js (opcional)
```bash
npm install
npm run dev
```

### 6. Configurar Permissões (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 7. Executar o Servidor
```bash
php artisan serve
```

O projeto estará disponível em: http://localhost:8000

## Problemas Comuns

### Erro: "composer command not found"
- Instale o Composer globalmente ou use `php composer.phar` em vez de `composer`

### Erro: "php command not found"
- Instale o PHP e adicione ao PATH do sistema
- No Windows, adicione o diretório do PHP às variáveis de ambiente

### Erro de conexão com banco
- Verifique se o MySQL está rodando
- Confirme as credenciais no arquivo `.env`
- Certifique-se de que o banco `controllcarcom_db` existe

### Erro de permissões
- No Windows, execute o terminal como administrador
- No Linux/Mac, ajuste as permissões das pastas storage e bootstrap/cache

## Estrutura do Projeto

Este é um sistema de gestão de veículos com:
- **Veículos**: Cadastro e gerenciamento de frota
- **Reservas**: Sistema de reserva de veículos
- **Serviços**: Controle de manutenções e serviços
- **Usuários**: Sistema de autenticação com JWT
- **Relatórios**: Geração de relatórios em PDF

## APIs Principais

- `POST /api/login` - Autenticação
- `GET /api/veiculos` - Listar veículos
- `GET /api/reservas` - Listar reservas
- `GET /api/servicos` - Listar serviços
- `GET /api/relatorios` - Gerar relatórios

## Tecnologias Utilizadas

- **Laravel 8**: Framework PHP
- **MySQL**: Banco de dados
- **JWT Auth**: Autenticação
- **Laravel Sanctum**: API tokens
- **DomPDF**: Geração de PDFs
- **AWS SDK**: Integração com AWS
- **Intervention Image**: Manipulação de imagens

## Suporte

Para problemas ou dúvidas, consulte:
- Documentação do Laravel: https://laravel.com/docs
- Issues do projeto no repositório