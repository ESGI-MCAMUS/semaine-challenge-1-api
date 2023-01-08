# Semaine Challenge API

[![💻 Deploy to dev](https://github.com/ESGI-MCAMUS/semaine-challenge-1-api/actions/workflows/deploy-developement.yml/badge.svg)](https://github.com/ESGI-MCAMUS/semaine-challenge-1-api/actions/workflows/deploy-developement.yml)
[![🖥️ Deploy to prod](https://github.com/ESGI-MCAMUS/semaine-challenge-1-api/actions/workflows/deploy-production.yml/badge.svg)](https://github.com/ESGI-MCAMUS/semaine-challenge-1-api/actions/workflows/deploy-production.yml)

## 🖥️ How to start the project?

1. Clone the project
2. Run `docker compose build --pull --no-cache` in order to download and build the latest version of the images
3. Run `docker compose up` to start the project. You can add the option `-d` to run it in background

## 🔏 JWT Authentication

In order to generate JWT keys, you can use the following command:

```bash
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

## 🗃️ Database migrations

In order to make a migration after adding a new entity, you can use the following command:

```bash
docker compose exec [php-container-name] bin/console make:migration
```

Once the migration is created, you can run it with the following command in order to apply the migration to the database:

```bash
docker compose exec [php-container-name] bin/console doctrine:migrations:migrate
```

## 🧑‍💻 Test users

In order to use the test users, you need to run the fixtures first:

```bash
docker compose exec [php-container-name] bin/console doctrine:fixtures:load
```

Then you can use the following credentials:

| Email             | Password | Role       |
| ----------------- | -------- | ---------- |
| admin@example.com | admin    | ROLE_ADMIN |
| user@example.com  | user     | ROLE_USER  |
