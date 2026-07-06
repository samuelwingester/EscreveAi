@echo off

echo Verificando dependencias...

where php >nul 2>nul
if errorlevel 1 (
    echo ERRO: PHP nao encontrado.
    pause
    exit /b 1
)

where composer >nul 2>nul
if errorlevel 1 (
    echo ERRO: Composer nao encontrado.
    pause
    exit /b 1
)

where git >nul 2>nul
if errorlevel 1 (
    echo ERRO: Git nao encontrado.
    pause
    exit /b 1
)

where npm >nul 2>nul
if errorlevel 1 (
    echo ERRO: NPM nao encontrado.
    pause
    exit /b 1
)

echo Dependencias encontradas.

echo Clonando repositorio...
git clone https://github.com/samuelwingester/EscreveAi

if errorlevel 1 (
    echo Erro ao clonar o repositorio.
    pause
    exit /b 1
)

cd EscreveAi/backend

echo Instalando dependencias...

composer install
npm install

if errorlevel 1 (
    echo Erro ao instalar as dependencias.
    popd
    pause
    exit /b 1
)

if not exist .env (
    copy .env.example .env >nul
)

php artisan key:generate

echo.
echo Setup concluido.
echo Execute:
echo     php artisan serve
