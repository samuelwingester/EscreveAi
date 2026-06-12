@echo off

echo - Verificando Dependencias

where php >nul 2>nul
if %errorlevel% neq 0 (
    echo "     -> ERRO: PHP nao encontrado no PATH."
    pause
    exit /b 1
)

echo "     -> PHP ja instalado"

where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo "    -> ERRO: Composer nao encontrado no PATH."
    pause
    exit /b 1
)

echo "    -> Composer ja instalado"

where git >nul 2>nul
if %errorlevel% neq 0 (
    echo "    -> ERRO: Git nao encontrado no PATH."
    pause
    exit /b 1
)

echo "    -> GIT ja instalado"

echo -> copiando Projeto do repositorio - https://github.com/samuelwingester/EscreveAi

git copy https://github.com/samuelwingester/EscreveAi

cd EscreveAi

echo - Baixando Dependencias

composer install

echo - Criando arquivo .env

copy .env.example .env

echo - Setup Completo
echo - Para rodar o projeto execute - php artisan serve