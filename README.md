**Instructions pour lancer l'application**
**Prérequis**
PHP >= 8.1
Composer
Symfony CLI (facultatif)
Serveur de base de données (MySQL, PostgreSQL, ou SQLite)

**Installation**
**Clonez le dépôt :**

git clone https://github.com/Kaiizer26/Symfony-districall-test.git

**Installez les dépendances :**

composer install

**Configurez l'environnement :**


**Modifiez les paramètres de connexion à la base de données dans .env.local:**
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

**Configurez la base de données :**

**Créez l'entité Tache si elle n'existe pas encore :**

symfony console make:entity Tache

**Suivez les instructions pour ajouter les champs nécessaires, ici :**
title : string
description : text
status : string
createdAt : datetime
updatedAt : datetime

**Générez la migration après avoir créé ou modifié l'entité :**

symfony console make:migration

**Exécutez la migration pour créer la table dans la base de données :**

symfony console doctrine:migrations:migrate

**Lancez le serveur local :**

symfony serve

**Accédez à l'application dans votre navigateur :**

http://127.0.0.1:8000

**Explication rapide des choix techniques :**

Symfony :
J'ai choisi Symfony parce que c'est un framework très connu et complet pour créer des applications web. Il m'aide à structurer mon code et offre plein d'outils qui font gagner du temps.

Doctrine (le gestionnaire de base de données) :
J'ai utilisé Doctrine pour gérer les données. Ça me permet de ne pas écrire directement du SQL, mais de manipuler les données avec du PHP.

Recherche et tri :
Pour que l'utilisateur puisse rechercher et filtrer les tâches, j'ai ajouté des champs dans le formulaire, et le contrôleur gère les filtres avec des requêtes. Par exemple, on peut chercher une tâche par son titre ou voir uniquement celles "en cours".
