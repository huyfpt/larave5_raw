# PERMISSION (Droits et Rôles)(Hegyd package)
## Installation
### Fichier _composer.json_
Comme le package hegyd/permissions est privé, il n'est pas distribué sur packagist.org.

Il est alors nécessaire de rajouter un dépôt git dans votre _composer.json_

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@gitlab.hegyd.net:hegyd/hegyd-permissions.git"
    }
]
```

Rajouter ensuite dans la section require

```
"hegyd/permissions": "5.4.*"
```

Ensuite lancer la commande ``` composer install ``` ou ``` composer update```

### Fichier _config/app.php_
Il faut ajouter dans _config/app.php_ le ServiceProvider

```
Hegyd\Permissions\PermissionsServiceProvider::class,
```

dans le tableau ```providers```

## Configuration

Il faut publier la configuration de base dans l'application, pour cela il faut executer cette commande

```
php artisan vendor:publish --tag=hegyd-permissions
```
Les routes et la configuration devrait être copiés dans l'application, à vous d'ajuster les informations par rapport à votre app. 

Pour créer le controller : 

```
php artisan hegyd:permissions-controller
```

## Models

Ces trois models sont utilisés dans le package :
- Role
- Permission
- CategoryPermission

Vous pouvez créer un model héritant de ceux-ci, ou les utiliser en direct.

Si vous utilisez le module Entrust, il faudra certainement modifier le fichier de configuration présent dans ``` config/entrust.php ```

## Données

Lancer la migration qui créera les tables requisent :

```
php artisan hegyd:permissions-migration
```
Un seeder est disponible afin de créer les catégories ainsi que les permissions requisent au module.

Lancer la commande : 
```
php artisan db:seed --class=Hegyd\\Permissions\\Seeders\\BasePermissionsSeeder
```

Vous pouvez aussi ajouter cette ligne dans la méthode ``` run()``` de la classe ``` DatabaseSeeder ``` :
```
$this->call(\Hegyd\Permissions\Seeders\BasePermissionsSeeder::class);
```