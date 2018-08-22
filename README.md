# Web Application Security

```
composer install  --no-plugins
```

edit .env with MySQL settings

```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
bin/console doctrine:database:import workshop-db.sql
bin/console server:run
```
