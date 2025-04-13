# Sistema de Chamados

Este é um sistema de gerenciamento de chamados desenvolvido com Laravel 12, Tailwind CSS e Laravel Filament (em implementação).

## Requisitos

- PHP 8.2 ou superior
- PostgreSQL
- Composer
- Node.js e npm

## Configuração

1. Clone o repositório
2. Instale as dependências do Composer:
```
composer install
```

3. Instale as dependências do npm:
```
npm install
```

4. Copie o arquivo .env.example para .env e configure as credenciais do banco de dados PostgreSQL:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=chamados
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

5. Gere a chave da aplicação:
```
php artisan key:generate
```

6. Execute as migrações e seeders para criar as tabelas e usuários iniciais:
```
php artisan migrate --seed
```

7. Compile os assets:
```
npm run dev
```

8. Inicie o servidor:
```
php artisan serve
```

## Credenciais de Acesso Padrão

### Administrador
- Email: admin@example.com
- Senha: password

### Operador
- Email: operator@example.com
- Senha: password

### Cliente
- Email: client@example.com
- Senha: password

## Roles e Permissões

O sistema utiliza três níveis de acesso:

1. **Administrator**: Acesso total ao sistema.
2. **Operator**: Acesso ao dashboard com funcionalidades limitadas.
3. **Client**: Acesso apenas à área logada básica e ao próprio perfil.

## Estrutura de Arquivos

- `app/` - Contém os modelos, controladores e outras classes PHP
- `config/` - Arquivos de configuração
- `database/` - Migrations e seeders
- `resources/` - Assets, views e arquivos de linguagem
- `routes/` - Definições de rotas da aplicação
- `public/` - Arquivos públicos e ponto de entrada

## Desenvolvimento

Para compilar os assets durante o desenvolvimento:
```
npm run dev
```

Para compilar os assets para produção:
```
npm run build
```

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
