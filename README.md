Este repositório é de um teste técnico da criação de um sistema básico desenvolvido em Laravel para gerenciamento de Produtos.

## Passo a Passo

#### Instale as dependências
Utilizando o Composer:

```
composer install
```

#### Crie um arquivo .env
Crie uma cópia do arquivo .env.example ou um arquivo do zero e configure o arquivo .env de acordo com seu ambiente.

#### Gere a chave da aplicação
```
php artisan key:generate
```

#### Configuração do banco de dados
No arquivo .env, altere e/ou configure as credenciais para o seu banco de dados.

```
DB_CONNECTION=mysql
DB_HOST=host
DB_PORT=porta
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

###### Depois, execute as migrações com o Artisan:
```
php artisan migrate
```

#### E por fim inicie o servidor
```
php artisan serve
```

Com isso, o sistema será executado em: http://localhost:8000

A aplicação possui um comando artisan para importação de produtos e categorias de uma API externa (https://fakestoreapi.com/docs):

```
php artisan products:import
```

Este comando possui um parâmetro opcional para importar somente um produto por vez:

```
php artisan products:import --id=2
```
