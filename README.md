# EscreveAi

### Integrantes da Equipe

| Nome | Matricula |
| :--- | :--- |
| Samuel Lucena | 22401946 |
| Kaique Guedes | 22400346 |
| Guilherme de Paiva | 22501215 |
| Isaac Ramos | 22502696 |
| Josué Nunes | 22500278 |

 ---

### Descrição do Sistema

O escreveaí é uma plataforma desenvolvida para auxiliar professores e instituições de Educação Infantil no acompanhamento da evolução da escrita dos alunos. O sistema permite registrar atividades, armazenar históricos, gerar relatórios pedagógicos e utilizar inteligência artificial para analisar o desenvolvimento das crianças e sugerir atividades personalizadas.

## Stack Utilizada

### Frontend

* HTML
* CSS
* javascript

### Backend

* PHP
* Laravel

### Banco de Dados

* Mysql

## Repositório

**GitHub**: https://github.com/samuelwingester/EscreveAi

## Containerização com docker

repositorio usado de exemplo: https://github.com/dockersamples/laravel-docker-examples


**Subir containers** - requer docker
```bash
docker compose -f compose.dev.yaml up -d
```

## Como Executar o Projeto

### Instalação

**Clonar o repositório**
```bash
git clone https://github.com/samuelwingester/EscreveAi
```

**Ir para o diretorio do laravel**
```bash
cd EscreveAi/backend
```

**Baixar Dependencias do Laravel**
```bash
composer install
```

**Gerar Loader do php**
```bash
composer dump-autoload
```

**Carregar o arquivo .env** | NOTA -> *Altere de acordo com suas configurações*
```bash
#Linux
cp .env.example .env

#Windows
copy .env.example .env
```

**Configuração do Laravel**
```bash
php artisan key:generate
```
**Criação das Tabelas**
```bash
php artisan migrate
```

**Inserir Dados de Teste**
```bash
php artisan db:seed 
```

### Rodando o Projeto

```bash
php artisan serve
```

 ## Documentação

### Caminhos e Comandos importantes
|   | Caminho | Comando `php artisan`  | Descrição |
| :---: | :--- | :--- | :--- |
| Controllers | app/Http/Controllers/ | `make:controller {nome}` | Cria um Controller |
| Models | app/Models | `make:model {nome}` | Cria uma Model |
| Migrations | database/migrations/ | `make:migration {nome}` | Cria uma Migração |
| Factories | database/factories/ | `make:factory --model={model} {nome}` | Cria uma Factory |
| Seeders | database/seeders/ | `make:seeder {nome}` | Cria um Seeder |
| Services | app/Services/ | `make:service {model} {nome}` | Cria um Service para uma Model |
| Tests | tests/Feature/ | `make:test {nome}` | Cria um Teste |

 ### Rotas
