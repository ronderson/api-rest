## Abaixo segue o que iremos resolver nessa aplicação:

# Passo a passo:

Comando para executar os containers 


```sh
docker-compose up -d --build

```

Comando para entrar no container docker


```sh
docker-compose exec app bash
```

Comando para sair do container

```sh
exit
```

comando para desativar uma imagem Docker

```sh
docker-compose down
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

Telescope: 👉 http://localhost:9001
