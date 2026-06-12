#!/bin/bash

set -e

echo - Verificando Dependencias

command -v php >/dev/null 2>&1 || {
    echo "    -> ERRO: PHP nao encontrado no PATH."
    exit 1
}

echo "    -> PHP ja instalado"

command -v composer >/dev/null 2>&1 || {
    echo "    -> ERRO: Composer nao encontrado no PATH."
    exit 1
}

echo "    -> Composer ja instalado"

command -v git >/dev/null 2>&1 || {
    echo "    -> ERRO: Git nao encontrado no PATH."
    exit 1
}

echo "    -> GIT ja instalado"
echo

echo - copiando Projeto do repositorio - https://github.com/samuelwingester/EscreveAi
echo

git clone https://github.com/samuelwingester/EscreveAi

cd EscreveAi

echo - Baixando Dependencias
echo

composer install

echo - Criando arquivo .env
echo

cp .env.example .env

echo - Setup Completo
echo - Para rodar o projeto execute - php artisan serve