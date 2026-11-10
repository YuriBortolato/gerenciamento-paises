# Sistema de Gerenciamento de Países

Projeto desenvolvido utilizando PHP 8.3, Laravel 12, PostgreSQL, Docker, Docker Compose e JWT.

## Tecnologias Utilizadas

- PHP 8.3
- Laravel 12
- PostgreSQL
- Docker
- Docker Compose
- Laravel Blade
- JWT Authentication
- Bootstrap 5

---

# Objetivo

Consumir informações de países através da API REST Countries e armazená-las no PostgreSQL.

O sistema disponibiliza:

- Autenticação JWT
- Importação de países
- Listagem de países
- Consulta de países
- Cadastro de países
- Atualização de países
- Exclusão de países
- Interface Blade para gerenciamento

---

# Estrutura

## Container App

Responsável por:

- Laravel 12
- PHP 8.3
- Composer

## Container Database

Responsável por:

- PostgreSQL 16

---

# Instalação

## Clonar projeto

```bash
git clone <repositorio>
```

ou copiar a pasta do projeto.

---

## Configuração do Ambiente (.env) e Token da API

Copie o arquivo de exemplo `.env.example` para gerar seu arquivo `.env`:

```bash
cp .env.example .env
```

> [!IMPORTANT]
> ### ⚠️ Atenção sobre o Token da API REST Countries
>
> Por motivos de segurança e privacidade (já que este repositório é público), **o token pessoal do autor foi removido deste projeto** e não está presente nos arquivos versionados.
>
> Para que a funcionalidade de **Importação de Países** funcione com sucesso (tanto via endpoint `/api/countries/import` quanto pelo botão da interface web), você precisa fornecer seu próprio token de API:
>
> 1. Cadastre-se e obtenha sua chave de API gratuita em: **[https://restcountries.com/](https://restcountries.com/)**
> 2. Abra o arquivo `.env` na raiz do projeto.
> 3. Localize a linha `REST_COUNTRIES_API_KEY=` e insira seu token:
>    ```env
>    REST_COUNTRIES_API_KEY=rc_live_seu_token_aqui
>    ```

---

## Subir containers

```bash
docker compose up -d --build
```

---

## Executar migrations

```bash
docker exec -it countries_app php artisan migrate
```

---

## Executar seed

```bash
docker exec -it countries_app php artisan db:seed
```

---

## Limpar cache

```bash
docker exec -it countries_app php artisan optimize:clear
```

---

# Credenciais

Usuário:

```text
admin@admin.com
```

Senha:

```text
123456
```

---

# Autenticação JWT

## Login

```http
POST /api/auth/login
```

Exemplo:

```json
{
    "email": "admin@admin.com",
    "password": "123456"
}
```

---

## Usuário autenticado

```http
GET /api/auth/me
```

---

## Logout

```http
POST /api/auth/logout
```

---

# Países

## Importar

```http
POST /api/countries/import
```

Importa os países da API REST Countries.

---

## Listar

```http
GET /api/countries
```

---

## Consultar

```http
GET /api/countries/{id}
```

---

## Cadastrar

```http
POST /api/countries
```

---

## Atualizar

```http
PUT /api/countries/{id}
```

---

## Excluir

```http
DELETE /api/countries/{id}
```

---

# Evitando Duplicidades

O campo:

```text
cca2
```

representa o código ISO do país.

Foi definido como:

```php
unique
```

na migration.

Durante importações é utilizado:

```php
updateOrCreate()
```

para evitar registros duplicados.

---

# API Externa

O sistema consome dados da API **REST Countries**:

- **Site Oficial:** [https://restcountries.com/](https://restcountries.com/)
- **Endpoint Utilizado:** `https://api.restcountries.com/countries/v5`
- **Autenticação:** Bearer Token via cabeçalho HTTP (`Authorization: Bearer <REST_COUNTRIES_API_KEY>`)

> [!NOTE]
> **Aviso de Segurança e Chave de Acesso:**  
> O token pessoal de acesso do autor foi removido. Para realizar a sincronização e importação dos países, você deve obter seu próprio token gratuitamente no link oficial [https://restcountries.com/](https://restcountries.com/) e configurá-lo no seu arquivo `.env` na variável `REST_COUNTRIES_API_KEY`.

### Dados consumidos:

- Nome
- Código ISO
- Capital
- Região
- População
- Bandeira

---

# Autor

Yuri Gabriel Bortolato

