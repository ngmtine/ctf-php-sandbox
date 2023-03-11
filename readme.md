# docker compose で nginx と postgres のコンテナを立てる

環境は wsl 上の ubuntu にて作業

以下のディレクトリ構成

```sh
$ tree
.
├── docker-compose.yaml
├── init.sql
├── nginx
│   └── dockerfile
├── nginx.conf
└── postgresql
    └── dockerfile
```

dockerfile はそれぞれ以下の通り

```dockerfile
# Base image
FROM nginx:latest

# Copying custom configuration file
COPY nginx.conf /etc/nginx/nginx.conf

# Exposing Port 80
EXPOSE 80

```

```dockerfile
# Base image
FROM postgres:latest

# Creating a database, user and password for application use
ENV POSTGRES_USER dockeruser
ENV POSTGRES_PASSWORD dockerpass
ENV POSTGRES_DB mydatabase

# Copying the initialization script to allow it to run on startup
COPY init.sql /docker-entrypoint-initdb.d/init.sql

```

docker-compose.yaml は以下の通り

```docker-compose.yaml
version: "3"
services:
    web:
        build:
            context: ./nginx
        ports:
            - "80:80"
    db:
        build:
            context: ./postgresql
        ports:
            - "5432:5432"
        volumes:
            - postgres_data:/var/lib/postgresql/data/
        environment:
            POSTGRES_USER: dockeruser
            POSTGRES_PASSWORD: dockerpass
            POSTGRES_DB: mydatabase
volumes:
    postgres_data:
```

`sudo docker compose up`すると、以下で動作確認できる

nginx は win 側のブラウザで localhost:8080 にアクセスすると nginx が動いているのがわかる

postgresql は 別ターミナルから以下で DB に接続できるのがわかる
`psql -U dockeruser -h localhost -p 5432 -d mydatabase`
