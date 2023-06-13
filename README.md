# <p align="center" style="color:MediumOrchid;">AbiratoBook</p>

Cette API est une partie d'un projet qui deviendra ensuite le site de référence dans la gestion et la vente de livres anciens.
<br><br>
Enfin, à mon échelle hein.
<br><br>
***

## <p align="center" style="color:LightSteelBlue;">Particularités</p>
***
<br><br>
Dans les fonctions d'IsbnCode, la fonction "search" fait appel à l'api Google Books.
<br><br>

Elle va recherché si l'ISBN rentré par l'utilisateur n'existe pas déjà en base de données.
<br><br>
Ensuite, s'il n'exite pas, elle fait appel à l'api Google pour récupérer le nom de l'auteur, la date de parution, l'éditeur et le ou les auteurs.
<br><br>
Elle crée ensuite un nouveau livre, enregistre l'ISBN qui lui est lié, lie ou ajoute l'éditeur et le ou les auteurs.
<br><br>
Enfin, elle retourne le livre trouvé ou le livre créé en base de données.
<br><br>
***
## <p align="center" style="color:LightSteelBlue;">Prérequis</p>
***
<br><br>
Assurez-vous d'avoir installé les éléments suivants avant de commencer :
<br><br>
- PHP >= 7.4
- Composer
- Laravel CLI
- MySQL / MariaDB

<br>
Vérifiez votre version de Laravel en exécutant la commande suivante :

<br>

```shell
php artisan --version
```
<br>

***

## <p align="center" style="color:LightSteelBlue;">Installation</p>

***

<br>

Clonez ce dépôt dans le répertoire de votre choix :
<br><br>

```shell
git clone https://github.com/G8ite/ApiBirato.git
```

<br>

### Configurez votre environnement en créant le fichier .env à partir du modèle .env.example. 

<br>
Remplacez les valeurs entre crochets par les informations appropriées :

<br>

```shell
cp .env.example .env
```

<br>
Créez une base de données dans phpMyAdmin avec le nom "abirato_lrv" et l'encodage "utf8mb3_general_ci".

<br>

### Installez les dépendances du projet avec Composer :
<br>

```shell
composer install
```

<br>

### Exécutez les migrations pour créer les tables de la base de données :
<br>

```shell
php artisan migrate
```
<br>

### Exécutez les seeders pour peupler la base de données avec des données de test :
<br>

```shell
php artisan db:seed
```
<br>

### Générez la documentation de l'API en utilisant L5 Swagger :
<br>

```shell
php artisan l5-swagger:generate
```
<br>

***

## <p align="center" style="color:LightSteelBlue;">Utilisation</p>
***
<br>

### Démarrez le serveur de développement Laravel :
<br>

```shell
php artisan serve
```
<br>

### Accédez à l'adresse suivante dans votre navigateur :
<br>

```bash
http://127.0.0.1:8000/api/documentation#/
```
<br>

Vous devriez maintenant voir la documentation de l'API et pouvoir commencer à interagir avec votre application.


