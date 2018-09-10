# PLANS (Hegyd package)
## Installation
### Fichier _composer.json_
Comme le package hegyd/plans est privé, il n'est pas distribué sur packagist.org.

Il est alors nécessaire de rajouter un dépôt git dans votre _composer.json_

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@gitlab.hegyd.net:hegyd/hegyd-plans.git"
    },
    {
        "type": "vcs",
        "url": "git@gitlab.hegyd.net:hegyd/hegyd-uploads.git"
    }
]
```

Ensuite lancer la commande ``` composer require hegyd/plans```

### Models
#### Trait Plans
Ajouter le trait Plans dans le modèle User
```
use Hegyd\Plans\Models\Traits\Plans;

class User extends .... {

    use Plans;
    
}
```


### Publications
#### Assets (Obligatoire)
Publier les fichiers js/css

```php artisan vendor:publish --tag=hegyd_plans_assets```

#### Migrations (Obligatoire)
Publier les fichiers de migrations

```php artisan vendor:publish --tag=hegyd_plans_migrations```

Il faudra sûrement modifier le nom des migrations afin qu'elles s'executent après cellles de votre app.

#### Vues
Publier les vues

```php artisan vendor:publish --tag=hegyd_plans_views```

#### Configuration
Publier le(s) fichier(s) de configuration

```php artisan vendor:publish --tag=hegyd_plans_config```

#### Routes
Publier le(s) fichier(s) de routes

```php artisan vendor:publish --tag=hegyd_plans_routes```

#### Langue
Publier le(s) fichier(s) de langues

```php artisan vendor:publish --tag=hegyd_plans_lang```


### Seeder
Lors de l'installation il faut seeder une première fois le dossier "root" ainsi que les permissions

```
php artisan db:seed --class="Hegyd\Plans\Database\Seeds\PermissionSeeder"
php artisan db:seed --class="Hegyd\Plans\Database\Seeds\PlansCategoryTableSeeder"
php artisan db:seed --class="Hegyd\Plans\Database\Seeds\PlansTableSeeder"
```

```
php artisan db:seed --class="Database\Seeds\ACL\CategoryPermissionSeeder"
php artisan db:seed --class="Database\Seeds\ACL\PermissionSeeder"
php artisan db:seed --class="Database\Seeds\Content\PlansCategoryTableSeeder"
php artisan db:seed --class="Database\Seeds\Content\PlansTableSeeder"
```