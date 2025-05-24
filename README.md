![Static Badge](/public/badges/PHP.svg)   
![Static Badge](/public/badges/MySQL.svg)   
![Static Badge](/public/badges/Laravel.svg)   
![Static Badge](/public/badges/Apache.svg)   
![Static Badge](/public/badges/XAMPP.svg)   
![Static Badge](/public/badges/Composer.svg)   

<div id="top"></div>

## Menu   

1. **[Informations générales](#informations-générales)**   
2. **[Technologies utilisées](#technologies)**    
3. **[Liste pré-requis](#liste-pre-requis)**   
4. **[Installation exécution de l'application](#installation-execution-application)**   
5. **[Test degré de parenté](#test-degré)**   
6. **[Évolution des données pour le système de modifications](#système-modifications)**    
7. **[Schéma de base de données](#schéma-bdd)**  
8. **[Envoi d'email](#envoi-email)**     
9. **[Interface de l'application](#interface-application)**   
10. **[Auteurs et contact](#auteur-contact)**   

### Projet Généalogie App

- Ce projet consiste à développer un site de généalogie permettant aux utilisateurs de créer et gérer des arbres familiaux.

<div id="informations-générales"></div>

##### Fonctionnalités principales

- ``Gestion des personnes`` : Création, consultation et modification des fiches individuelles   
- ``Relations familiales`` : Établissement des liens parent/enfant entre les personnes   
- ``Calcul de parenté`` : Détermination du degré de relation entre deux individus   
- ``Système collaboratif`` : Validation communautaire des modifications proposées   
    &nbsp;   

- ``Ajout de Membres de la Famille`` :   
    - L'utilisateur ajoute des membres de sa famille en créant de nouvelles fiches personnes et en définissant des relations familiales entre ces personnes.

-  ``Invitations`` :   
    - L'utilisateur peut inviter d'autres membres de la famille à rejoindre le site après leur avoir créé leur fiche personne.   
    - Une fois inscris, ces utilisateurs acquièrent la fiche personne créée pour eux.

- ``Inscription sans invitation`` :
    - Un utilisateur s'inscrit sur le site sans y avoir été invité, et crée directement sa propre fiche personne.

- ``Propositions de Modifications`` :
    - Les utilisateurs peuvent proposer des modifications aux informations des personnes ou proposer d'ajouter de nouvelles relations.
    - Ces modifications ne sont pas validées tant qu'elles ne sont pas acceptées par au moins 3 membres de la communauté.
    - Si 3 membres les refusent, elles sont définitivement invalidées.   

- ``Validation des Modifications`` :
    - Les propositions de modification / ajout de relations sont examinées par chaque utilisateur concerné et peuvent être acceptées ou refusées.
    - Nous garderons un historique des acceptations / refus.

--------------------------------------------------------------------------------------------------------------------------------

<div id="technologies"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

#### Technologies utilisées

- **PHP** 8.x avec le framework **Laravel**
- Base de données **MySQL**
- Architecture **MVC** (Modèles, Vues, Contrôleurs)

##### Le projet se décompose en trois parties principales :

- Implémentation de base avec **CRUD** des personnes et relations
- Algorithme de calcul des degrés de parenté
- Système de validation collaborative des modifications

--------------------------------------------------------------------------------------------------------------------------------

<div id="liste-pre-requis"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Liste pré-requis   

- Application conçue avec les technologies suivantes :   
  &nbsp;   

  - **PHP** 8.3.21 disponible à l'adresse suivante ➔ https://www.php.net/   
  - **MySQL** 8.0.42 disponible à l'adresse suivante ➔ https://www.mysql.com/   
  - **Composer** 2.8.9 disponible à l'adresse suivante ➔ https://getcomposer.org/   
  - **XAMMPP** 8.2.12 disponible à l'adresse suivante ➔ https://www.apachefriends.org/   
  - **APACHE** 2.4.63 disponible à l'adresse suivante ➔ https://www.apachelounge.com/   
  - **Laravel** 12.14.1   
  - **Windows 11** Professionnel
    &nbsp; 

--------------------------------------------------------------------------------------------------------------------------------

<div id="installation-execution-application"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Installation et exécution de l'application   

1. Créer la base de données dans un terminal **MySQL** ou **phpMyAdmin** :

```bash
$ mysql -u root -p
```

```bash
$ mysql> CREATE DATABASE genealogie CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Dans un terminal effectuer les migrations :

```bash
$ php artisan migrate
```

3. Importer les données avec **MySQL** dans un terminal (ou via **phpMyAdmin** avec "Désactiver la vérification des clés étrangères") :

```bash
$ mysql -u root -p genealogie < database/import/data.sql
```

4. Dans un terminal exécuter les commandes suivantes :

```bash
$ composer require laravel/breeze --dev
```   

```php
$ php artisan breeze:install (Choisissez l'option "blade" )
```

```bash
$  npm install
```
- Ensuite vous pouvez accéder à l'application   
  - Backend (**Laravel**) : http://localhost:8000 (avec la commande ``php artisan serve``)   

  - Dans un terminal exécuter :   

  ```php
  $ php artisan serve
  ```

  - Frontend (**Laravel Vite**) : http://localhost:5173 (avec la commande ``npm run dev``)
  - Dans un terminal exécuter :

  ```bash
  $ npm run dev
  ```   
- Vous pouvez maintenent accéder à l'application   

- Inscrivez-vous via http://localhost:8000/register   
- Connectez-vous via http://localhost:8000/login   

##### Fichier .env

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=genealogie
DB_USERNAME=*************    # Votre nom d'utilisateur MySQL
DB_PASSWORD=**************** # Votre mot de passe MySQL
```

>_**Note :** Pour le premier utilisateur je recommande de créer d'abord l'utilisateur **Admin** qui sera lié au données importer à partir du fichier **data.sql**._   

--------------------------------------------------------------------------------------------------------------------------------

<div id="test-degré"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Test degré de parenté   

##### Objectif

- Calculer le degré de parenté entre deux personnes en trouvant le chemin le plus court dans l'arbre généalogique.   
- Test de la méthode ``getDegreeWith()`` ➔ ([Person.php](/app/Models/Person.php))   
- Méthode ➔ ([RelationshipsRealDataTest.php](/tests/Feature/RelationshipsRealDataTest.php))   
  &nbsp;

- Pour exécuter le test utiliser la commmmande :   

```php
$ php artisan test tests/Feature/RelationshipsRealDataTest.php
```

```php
c:\GenealogieApp>php artisan test tests/Feature/RelationshipsRealDataTest.php
array:4 [
"degree" => 13
"path" => "84->248->47->37->287->197->624->626->745->790->1257->1259->1263->1265"
"time_seconds" => 0.7083
"queries_count" => 2
] // tests\Feature\RelationshipsRealDataTest.php:28

PASS  Tests\Feature\RelationshipsRealDataTest
✓ degree between 84 and 1265            0.86s  

Tests:    1 passed (5 assertions)
Duration: 1.02s
```

##### Résultats du test   

- Pour la paire (84, 1265) :
  - **Degré de parenté** : 13
  - **Chemin le plus court** : 84➔ 248➔ 47➔ 37➔ 287➔ 197➔ 624➔ 626➔ 745➔ 790➔ 1257➔ 1259➔ 1263➔ 1265
  - **Temps d'exécution** : ~0.7 secondes
  - **Nombre de requêtes SQL** : 2
    &nbsp;

- Ce test valide que la solution est à la fois :
  - **Correcte** (retourne le bon degré et chemin)   
  - **Performante** (temps d'exécution court)   
  - **Efficiente** (nombre minimal de requêtes SQL)   

--------------------------------------------------------------------------------------------------------------------------------

<div id="système-modifications"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Évolution des données pour le système de modifications

##### Flux de Données pour les Modifications Collaboratives

##### 1. Modification d'une Fiche Personne (**Workflow**)

  - Utilisateur A :
  - Proposant (Utilisateur A)
  - Validateurs (3 utilisateurs)

- Étapes :

  - Proposition :
  - Utilisateur A soumet : "Changer le prénom de 'DUPONT' à 'DUPOND' pour Jean (ID:84)"
    &nbsp;
  
- Système crée une entrée :

```bash
{
  "type": "person",
  "target_id": 84,
  "field": "last_name",
  "old_value": "DUPONT",
  "new_value": "DUPOND",
  "status": "pending"
}
```

##### 2. Notification :

```bash
A[Proposition] --> B[Notification aux membres]
B --> C[Utilisateur B]
B --> D[Utilisateur C]
B --> E[Utilisateur D]
```

##### 3. Votation :

```bash
Utilisateur B : ("Accepter")
Utilisateur C : ("Accepter")
Utilisateur D : ("Accepter")
```

##### 4. Résolution :

- Après 3 votes positifs :
  - Statut passe à "approved"
  - La fiche est automatiquement mise à jour.
  - Historique des modifications Accepter ou Refuser conservé. 

--------------------------------------------------------------------------------------------------------------------------------

<div id="schéma-bdd"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Schéma de base de données

- Le schéma de la base de données avec l'application **DBdiagram.io**
- Voir le diagramme interactif ➔ [DB Schéma](https://dbdiagram.io/d/6830ef4ab9f7446da3ebcc46)  

<iframe 
  src="https://dbdiagram.io/e/6830ef4ab9f7446da3ebcc46/6831284cb9f7446da3eea41c" 
  width="100%" 
  height="500px"
  style="border:none; background:transparent;"
  title="Diagramme de Base de Données"
></iframe>

--------------------------------------------------------------------------------------------------------------------------------

<div id="envoi-email"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Envoi d'email   

- La fonctionnalité d'envoi d'email à était testé avec **Mailtrap.io**.

1. Créer un compte **Mailtrap**
  - Allez sur [Mailtrap.io](https://mailtrap.io/) et inscrivez-vous (version gratuite disponible).
  - Une fois connecté, accédez à votre Inbox (boîte de réception de test).

2. Configurer **Laravel** pour utiliser **Mailtrap**
   Modifiez votre fichier ``.env`` avec les identifiants SMTP de **Mailtrap** :

```bash
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=e6605f0ab84dec   # Votre username Mailtrap
MAIL_PASSWORD=****2b94         # Votre mot de passe Mailtrap (remplacez les *)
MAIL_ENCRYPTION=tls
```

- Dans **Mailtrap**, allez dans **Email Testing**.
- Cliquez sur **My inbox** dans **Codes Samples** choisissez **Laravel 9+** et récupérer les informations nécessaires.
- Vous pouvez tester dans l'application ou dans un terminal avec ces commandes :

```php
$ php artisan tinker
```
- Puis dans **Tinker** :

```bash
Mail::raw('Test Mailtrap', function($message) {
    $message->to('test@mailtrap.io')->subject('Test Laravel avec Mailtrap');
});
```

--------------------------------------------------------------------------------------------------------------------------------

<div id="interface-application"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Interface de l'application   

##### L'application est exécutée dans une page web.   

- Interface d'une fiche utilisateur ou on peut effectuer une demande de modfication.

<div style="display: flex; justify-content: flex-start; margin: 20px 0;">
    <div style="border: 1px solid #8d8d8d; border-radius: 5px; padding: 10px; padding-bottom: 2px; display: inline-block; margin-right: 10px; margin-left: 20px;">
        <img src="/public/img/screen-information.png" alt="Screen interface" style="width: 1200px; height: auto;">
    </div>
</div>

- Interface d'un vote.

<div style="display: flex; justify-content: flex-start; margin: 20px 0;">
    <div style="border: 1px solid #8d8d8d; border-radius: 5px; padding: 10px; padding-bottom: 2px; display: inline-block; margin-right: 10px; margin-left: 20px;">
        <img src="/public/img/screen-modification-relation.png" alt="Screen interface" style="width: 1200px; height: auto;">
    </div>
</div>

- Interface d'une modification en attente.

<div style="display: flex; justify-content: flex-start; margin: 20px 0;">
    <div style="border: 1px solid #8d8d8d; border-radius: 5px; padding: 10px; padding-bottom: 2px; display: inline-block; margin-right: 10px; margin-left: 20px;">
        <img src="/public/img/screen-modification-attente.png" alt="Screen interface" style="width: 1200px; height: auto;">
    </div>
</div>

- Interface d'une modification acceptée.

<div style="display: flex; justify-content: flex-start; margin: 20px 0;">
    <div style="border: 1px solid #8d8d8d; border-radius: 5px; padding: 10px; padding-bottom: 2px; display: inline-block; margin-right: 10px; margin-left: 20px;">
        <img src="/public/img/screen-modification-accepter.png" alt="Screen interface" style="width: 1200px; height: auto;">
    </div>
</div>

- Interface d'une modification en refusée.

<div style="display: flex; justify-content: flex-start; margin: 20px 0;">
    <div style="border: 1px solid #8d8d8d; border-radius: 5px; padding: 10px; padding-bottom: 2px; display: inline-block; margin-right: 10px; margin-left: 20px;">
        <img src="/public/img/screen-modification-refuser.png" alt="Screen interface" style="width: 1200px; height: auto;">
    </div>
</div>

--------------------------------------------------------------------------------------------------------------------------------

<div id="auteur-contact"></div>
<a href="#top" style="float: right;">Retour en haut 🡅</a>

### Auteurs et contact   

Pour toute information supplémentaire, vous pouvez me contacter.   
**Bubhux:** bubhuxpaindepice@gmail.com   
