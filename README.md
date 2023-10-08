Please follow these steps to set up and run the application using Docker:

```bash
   git clone <repository-url>
```

Navigate to the project directory:

cd <project-directory>

Copy the Docker Compose configuration file and environment variables file:


```bash
cp docker-compose-example.yml docker-compose.yml
```
```bash
cp .env.example .env
```

Open the .env file and configure the environment variables if needed.
Build and start the Docker containers:

```bash
docker-compose up --build
```

```bash
docker exec ip-guardian-app composer install
```

```bash
docker exec ip-guardian-app php artisan key:generate
```

```bash
docker exec ip-guardian-app php artisan migrate --seed
```

```bash
docker exec ip-guardian-app npm i && npm run build
```