#!/bin/bash

echo "===== Configurando o sistema de chamados ====="

# Instalar dependências do Composer
echo "Instalando dependências do Composer..."
composer install

# Instalar dependências NPM
echo "Instalando dependências NPM..."
npm install

# Gerar chave da aplicação
echo "Gerando chave da aplicação..."
php artisan key:generate

# Criar o banco de dados (opcional - apenas se tiver psql instalado)
echo "Você deseja criar o banco de dados PostgreSQL? (s/n)"
read create_db
if [ "$create_db" = "s" ]; then
  echo "Criando banco de dados chamados..."
  psql -U postgres -c "CREATE DATABASE chamados;"
fi

# Executar migrações e seeders
echo "Executando migrações e seeders..."
php artisan migrate:fresh --seed

# Compilar assets
echo "Compilando assets..."
npm run dev

echo "===== Configuração concluída ====="
echo ""
echo "Para iniciar o servidor, execute:"
echo "php artisan serve"
echo ""
echo "Credenciais de acesso:"
echo "Admin: admin@example.com / password"
echo "Operator: operator@example.com / password"
echo "Client: client@example.com / password" 