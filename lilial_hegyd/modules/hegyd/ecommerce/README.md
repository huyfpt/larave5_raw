# E-COMMERCE (Hegyd package)
## Installation
### Fichier _composer.json_
Comme le package hegyd/news est privé, il n'est pas distribué sur packagist.org.

Il est alors nécessaire de rajouter un dépôt git dans votre _composer.json_

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@gitlab.hegyd.net:hegyd/hegyd-ecommerce.git"
    },
    {
        "type": "vcs",
        "url": "git@gitlab.hegyd.net:hegyd/hegyd-uploads.git"
    }
]
```

Ensuite lancer la commande ``` composer require hegyd/ecommerce```

### Models
#### Trait eCommerce
Ajouter le trait eCommerce dans le modèle User
```
use Hegyd\eCommerce\Models\Traits\eCommerce;

class User extends .... {

    use eCommerce;
    
}
```


### Publications
#### Assets (Obligatoire)
Publier les fichiers js/css

```php artisan vendor:publish --tag=hegyd_ecommerce_assets```

#### Migrations (Obligatoire)
Publier les fichiers de migrations

```php artisan vendor:publish --tag=hegyd_ecommerce_migrations```

Il faudra sûrement modifier le nom des migrations afin qu'elles s'executent après cellles de votre app.

#### Vues
Publier les vues

```php artisan vendor:publish --tag=hegyd_ecommerce_views```

#### Configuration
Publier le(s) fichier(s) de configuration

```php artisan vendor:publish --tag=hegyd_ecommerce_config```

#### Routes
Publier le(s) fichier(s) de routes

```php artisan vendor:publish --tag=hegyd_ecommerce_routes```

#### Langue
Publier le(s) fichier(s) de langues

```php artisan vendor:publish --tag=hegyd_ecommerce_lang```


### Seeder
Lors de l'installation il faut seeder une première fois le dossier "root" ainsi que les permissions

```
php artisan db:seed --class="Hegyd\eCommerce\Database\Seeds\PermissionsSeeder"
php artisan db:seed --class="Hegyd\eCommerce\Database\Seeds\SettingsSeeder"
php artisan db:seed --class="Hegyd\eCommerce\Database\Seeds\VatSeeder"
```

### Interfaces 
#### Header 
Ajouter ce code dans votre header:
```
<span class="cart-item" data-cart-template="cart-header">
    @include('hegyd-ecommerce::frontend.contents.cart.includes.cart-header')
</span>
```


### Commandes
#### Alerte stock produits
Envoi un email d'alerte concernant les seuils du stock produit
```
php artisan hegyd:ecommerce-product-stock-alert 
```

#### Suppression des paniers
Suppression des paniers qui n'ont pas été mis à jour depuis un certain temps.

Possibilité de changer ce temps en rajoutant le paramètre --timing=X
```
php artisan hegyd:ecommerce-clear-cart 
```

#### Kernel.php
```
/* Lancement des jobs présent dans la base de données */
$schedule->command('queue:work database --tries=3 --sleep=5')->everyMinute()->withoutOverlapping();
```


A FAIRE 
--------

CRÉATION D'UN MODEL Address

CRÉATION DES REPOSITORY Address

CRÉATION D'UN TRAIT POUR LE MODEL USER DANS LEQUEL IL Y A :
- La relation addresses
- La relation cart
- La relation orders


TRADUCTION address
