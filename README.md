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

**Carregar o arquivo .env**
```bash
#Linux
cp .env.example .env

#Windows
copy .env.example .env
```


Alternativamente, baixe o arquivo de setup em "setup/" ( setup.sh -> linux | setup.bat -> windows )
e o execute no terminal ou diretamente

### Rodando o Projeto

```bash
php artisan serve
```

 ## Documentação

### Caminhos e Comandos importantes
| Camada | Caminho | Comando `php artisan` + |
| :---: | :--- | :--- |
| Controllers | app/Http/Controllers/ | `make:controller {nome}` |
| Models | app/Models | `make:model {nome}` |
| Migrations | database/migrations/ | `make:migration {nome}` |
| Factories | database/factories/ | `make:factory --model={model} {nome}` |
| Seeders | database/seeders/ | `make:seeder {nome}` |
| Services | app/Services | `make:service {model} {nome}` |
| Rotas:api | routes/api.php|  |

 ---

 ### Rotas

<figcaption align="top"><b>Model -> Turma | Controller -> TurmaController </b></figcaption>

| Método | Rota | Service | Descrição |
| :---: | :--- | :---: | :--- |
| `GET` | `/api/turma` |  `Null` | Lista todas as turmas |
| `GET` | `/api/turma/{id}` | `Null` | Busca uma turma por ID |
| `POST` | `/api/turma` |  `CreateTurmaService` | Cria uma nova turma |
| `PUT` `PATCH` | `/api/turma/{id}` | `UpdateTurmaService` | Atualiza os dados de uma turma |
| `DELETE` | `/api/turma/{id}` | `DeleteTurmaService` | Exclui uma tarefa do banco |