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

## Funcionalidades Implementadas
 * O usuario pode se cadastrar. 
 * O usuario pode logar.
 * O usuario pode deslogar. 
 
 * Criar turmas.
 * Editar turmas
 * Deletar turmas. 
 * Listar turmas.
 * Ver as estatisticas de turmas.

 * Criar estudantes.
 * Editar turmas
 * Deletar estudantes. 
 * Listar estudantes.

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

### Rotas

<figcaption align="top"><b>Turma</b></figcaption>

| Método | Rota | Descrição |
| :---: | :--- | :--- |
| `GET` | `/api/classroom` | Lista todas as turmas de um usuario |
| `GET` | `/api/classroom/{classroom}` | Busca uma turma por ID |
| `GET` | `/api/classroom/{classroom}/stats` | Retorna as estatísticas da turma |
| `POST` | `/api/classroom` | Cria uma nova turma |
| `PUT` / `PATCH` | `/api/classroom/{classroom}` | Atualiza os dados de uma turma |
| `DELETE` | `/api/classroom/{classroom}` | Exclui uma turma |

<figcaption align="top"><b>Aluno</b></figcaption>

| Método | Rota | Descrição |
| :---: | :--- | :--- |
| `GET` | `/api/classroom/{classroom}/student` | Lista todos os alunos da turma |
| `GET` | `/api/classroom/{classroom}/student/{student}` | Busca um aluno da turma por ID |
| `POST` | `/api/classroom/{classroom}/student` | Adiciona um novo aluno à turma |
| `PUT` / `PATCH` | `/api/classroom/{classroom}/student/{student}` | Atualiza os dados de um aluno |
| `DELETE` | `/api/classroom/{classroom}/student/{student}` | Remove um aluno da turma |

<figcaption align="top"><b>Autenticação</b></figcaption>

| Método | Rota | Descrição |
| :---: | :--- | :--- |
| `POST` | `/api/login` | Realiza o login do usuário |
| `POST` | `/api/register` | Registra um novo usuário |
| `POST` | `/api/logout` | Encerra a sessão do usuário autenticado |
| `GET` | `/api/user` | Retorna os dados do usuário autenticado |
