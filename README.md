# APM Diesel Backend

Sistema de gerenciamento de veículos e solicitações de serviços para APM Diesel.

## Sobre o Projeto

Este é o backend da aplicação APM Diesel, desenvolvido em Laravel 8, que oferece:

- **Gerenciamento de Veículos**: CRUD completo para veículos da frota
- **Sistema de Check-in/Check-out**: Controle de uso dos veículos
- **Solicitações de Serviços**: Gerenciamento de pedidos de combustível e manutenção
- **Dashboard**: Relatórios e estatísticas em tempo real
- **Autenticação**: Sistema seguro com Laravel Sanctum
- **API RESTful**: Endpoints para integração com frontend

## Tecnologias Utilizadas

- **Laravel 8.83.29**
- **PHP 8.4.12**
- **MySQL**
- **Laravel Sanctum** (Autenticação)
- **CORS** configurado para frontend

## Configuração do Ambiente

### Pré-requisitos

- PHP 8.1+ (recomendado)
- Composer
- MySQL/MariaDB
- Node.js (opcional)

### Instalação

1. Clone o repositório
2. Instale as dependências:
   ```bash
   composer install
   ```

3. Configure o arquivo `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure o banco de dados no `.env`
5. Execute as migrations:
   ```bash
   php artisan migrate
   ```

6. Inicie o servidor:
   ```bash
   php artisan serve --host=0.0.0.0 --port=9000
   ```

## Endpoints da API

### Autenticação
- `POST /api/login` - Login do usuário
- `POST /api/me` - Dados do usuário autenticado

### Veículos
- `GET /api/veiculos` - Listar veículos
- `POST /api/veiculos` - Criar veículo
- `PUT /api/veiculos/{id}` - Atualizar veículo
- `DELETE /api/veiculos/{id}` - Remover veículo

### Check-in/Check-out
- `POST /api/checkin` - Fazer check-in de veículo
- `POST /api/checkout` - Fazer check-out de veículo

### Solicitações de Serviços
- `GET /api/servicos` - Listar solicitações
- `POST /api/servicos` - Criar solicitação

### Dashboard
- `GET /api/dashboard/totais` - Estatísticas gerais

## Credenciais de Teste

- **Email**: `admin@admin.com`
- **Senha**: `123456`

## Status do Projeto

✅ **Funcional e Operacional**

- Todas as APIs implementadas e testadas
- Autenticação funcionando
- CORS configurado
- Dashboard com dados consistentes
- Sistema de check-in/check-out operacional

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
