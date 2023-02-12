# sebconsole

# Nouveau projet laravel RRASK

Création d'un nouveau projet Laravel avec la bibliothèque RRAS

##  Installation Laravel

Projet: test

```shell
composer create-project laravel/laravel test
```

##  Paramètrer l'accès à la base de données
Dans le fichier /.env

##  Installation de UI
```shell
composer require laravel/ui
```

##  Installation de boostrap
```shell
php artisan ui bootstrap --auth
```

##  Installation des composants via npm
```shell
npm install && npm run dev
```
## Modifier le fichier /resources/wiews/layout/app.blade
```shell
@vite(['resources/sass/app.scss', 'resources/js/app.js']) 
=>
@vite([ 'resources/js/app.js'])
```

##  Ajout de npm run watch
Dans le fichier /package.json
```shell
"dev": "vite",
"watch": "vite build --watch",
"build": "vite build"
```

Vérifier avec 
```shell
npm run watch
```

## Remplace le contenu du fichier /resources/js/app.jss
```shell
import '../sass/app.scss'
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
```


## Instllation de la librairie rrask
```shell
composer require rras3k/sebconsole:dev-master   
```

## ajout des fichiers sass
Ajouter à la fin du fichier /resources.sass/app.css
```shell
@import 'ajout';
@import '_rras3k/console';
```

## Copie des fichiers de configuration
```shell
php artisan vendor:publish --force --tag=rras3k-config
```
```shell
php artisan vendor:publish --force --tag=rras3k-force
```

## Construction des tables et de quelques données ("seb" => root, admin)
```shell
php artisan migrate
php artisan db:seed --class=FirstSeeder
```

