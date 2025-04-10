# API REST

Nome: Ronderson de Almeida Florentino
Cargo: Desenvolvedor PHP Sênior

## Como rodar o projeto

Clone o projeto
```
git clone https://github.com/especializati/curso-de-laravel-10.git
```
Duplicar o arquivo ".env.example" e renomear para ".env".

Comando para executar os containers 
```
docker-compose up -d --build
```

Comando para entrar no container docker
```
docker-compose exec app bash
```
Instalar as dependências do PHP
```
composer install
```
Gerar a chave no arquivo .env
```
php artisan key:generate
```
Executar as migration
```
php artisan migrate
```
Executar as seed
```
php artisan db:seed
```

## Acessar os serviços
Agora, você pode acessar os seguintes serviços no navegador:

Laravel API: 👉 http://localhost:8000/api

Usuário: admin@admin.com

Senha: 123456

pgAdmin: 👉 http://localhost:5050

E-mail: admin@admin.com

Senha: admin

MinIO UI: 👉 http://localhost:9001

Usuário: minioadmin

Senha: minioadmin

Telescope: 👉 http://localhost:8000/telescope


Documentação para uso da API 👉 https://documenter.getpostman.com/view/6697252/2sB2cX7fqC#fff0ca43-8921-46a8-bdee-876269d1c546

