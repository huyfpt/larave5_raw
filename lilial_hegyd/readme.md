# Projet de référence

Création d’un projet de « référence » qui peux servir de base pour d’autre nouveau projet. Normalement tout fonctionne.

- Le multi-enseigne est de base.
- Un role super-administrateur a été créé.
- Les personnalisations sont par enseignes. Mais ne sont pas copiés lors de la création d’une enseigne, mais lors de la redifinition.


# Installation
```bash
$ cp .env.example .env
$ php artisan key:generate
```

Remplacez les valeurs du fichier ```.env``` par celles de votre environnement

```bash
$ composer install
$ bower install
$ php artisan --seed
$ chmod -R 777 storage/logs storage/framework/ storage/debugbar
$ chmod -R 775 storage/app
```