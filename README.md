# The Ocho API

An API for driving The Ocho Apps:
- Tournament tool for quick & easy tournament management
- Review tool for annotation of competitive videos

This is a Laravel Lumen 10.x project running on PHP 8.1.

## Setup

You will need Docker installed an an internet connection.

By default, the API will be shared to ```localhost:8080```. If you already have service on that port, you will need to modify ```docker-compose.yml```.

MariaDb will be shared to ```13306```, again, in the hopes that we avoid collisions. This may require modification. This is also configured in ```docker-compose.yml```.

The steps for setting up are as follows:
1. Install docker (if not done already)
2. Run docker compose (below) - this will create a pair of containers (pretty much virtual machines running linux) that will have their own private virtual network.
3. "Log in" to the API container and continue set up within the virtual machine
4. Setup consists of running the composer tool to fetch dependencies for the project (below)

### On Mac, Linux:

```bash
> docker compose up --build -d
```

### On Windows

This stack relies on sharing mariadb data files from host to guest, so there may be some issues with permissions. I really don't know.

Do some WSL2 stuff, then:

```bash
> docker compose up --build -d
```

### After Docker Compose

Log in to the API container:

```
> docker exec -it api-api-1 bash
> cd cd api
> composer install
> cd migration-strategy
> composer install
```

## Development

Endpoints are defined in ```/src/routes/web.php```. A functional style is used generally, particularly for the reviews app.

Database schema updates can be handled by direct modification of the database or by the production of migrations (see below).

## Database

The database us automatically provisioned via ```docker compose up```.

The API container connects directly to the database container on ```3306``` via the ```ochonet``` virtual network, so no need to bother your pretty about that. The hostname on that network is ```db```.

If changes to the schema are necessary, use the ```phinx``` and ```phinx-migrations-generator``` in ```src/migration-strategy``` under ```vendor/bin/[phinx|phinx-migrations]```.

```phinx-migrations-generator``` can be used to generate phinx migrations by inspection of the modified schema. In general, you should not delete or modify existing columns or indexes.

This can (should) be done from within the API container:
```
> docker exec -it api-api-1 bash
> cd cd api/migration-strategy/
```

To generate a new migration:
```
> vendor/bin/phinx-migrations generate -e production
```

Migrations can be applied with ```phinx```:
```
> vendor/bin/phinx migrate -e production
```

If you need access the database host, you can do so directly with ```exec``` or from the api host via the hostname ```db```:

1. Log into the API host
```
> docker exec -it api-api-1 bash
```
2. Acces the mysql instance
```
> mysql -h db -u root -p ocho
```
