Nome: Ronderson de Almeida Florentino
Cargo: Desenvolvedor PHP Sênior


## Abaixo segue o que iremos resolver nessa aplicação:

# Passo a passo:

Comando para executar os containers 
```
docker-compose up -d --build
```

Comando para entrar no container docker
```
docker-compose exec app bash
```

Comando para sair do container
```
exit
```
comando para desativar uma imagem Docker
```
docker-compose down
```

## Como rodar o projeto

Duplicar o arquivo ".env.example" e renomear para ".env".


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

📌 Acessar os serviços
Agora, você pode acessar os seguintes serviços no navegador:

Laravel API: 👉 http://localhost:8000

pgAdmin: 👉 http://localhost:5050

E-mail: admin@admin.com

Senha: admin

MinIO UI: 👉 http://localhost:9001

Usuário: minioadmin

Senha: minioadmin

Telescope: 👉 http://localhost:8000/telescope


