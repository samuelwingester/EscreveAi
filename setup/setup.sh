#!/usr/bin/env bash

set -e

echo "Verificando dependências..."

for cmd in php composer git npm; do
    if ! command -v "$cmd" >/dev/null 2>&1; then
        echo "ERRO: $cmd não encontrado no PATH."
        exit 1
    fi
done

echo "Clonando repositório..."
git clone https://github.com/samuelwingester/EscreveAi

cd EscreveAi/backend

echo "Instalando dependências..."

composer install
npm install

[ -f .env ] || cp .env.example .env

php artisan key:generate

echo "Setup concluído."
echo "Execute: php artisan serve"