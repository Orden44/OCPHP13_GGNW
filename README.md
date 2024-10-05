# OCPHP13_GGNW

## Mettez en place un site e-commerce avec Symfony

Ce projet est le 13ème projet du parcours développeur PHP/Symfony d'OpenClassrooms. L'objectif est de mettre en place un site e-commerce en utilisant le framework Symfony.

## Installation

Avant de commencer, assurez-vous d'avoir les prérequis suivants installés sur votre machine :

- PHP version 7.4 ou supérieure
- Composer
- Symfony CLI

Pour installer l'application localement, suivez les étapes ci-dessous :

1. Clonez ce dépôt sur votre machine : `git clone https://github.com/Orden44/OCPHP13_GGNW.git`
2. Accédez au répertoire du projet : `cd OCPHP13_GGNW`
3. Installez les dépendances du projet : `composer install`
4. Configurez votre base de données dans le fichier `.env`
5. Créez la base de données : `php bin/console doctrine:database:create`
6. Exécutez les migrations : `php bin/console doctrine:migrations:migrate`

## Configuration

Pour configurer l'application, vous devez modifier le fichier `.env`. Remplacez les variables suivantes selon votre environnement :


DATABASE_URL=mysql://user:password@localhost:port/database_name


N'oubliez pas de remplacer `user`, `password`, `localhost`, `port` et `database_name` par les valeurs correspondantes.

## Utilisation

Pour démarrer l'application, exécutez la commande suivante :


symfony serve

Cela lancera le serveur Symfony et vous pourrez accéder à l'application en ouvrant votre navigateur Web à l'adresse `http://localhost:8000`.

Pour créer la base de données avec des données de démonstration, vous pouvez exécuter les fixtures en utilisant la commande suivante :


php bin/console doctrine:fixtures:load


Cela chargera les données prédéfinies dans la base de données et vous permettra de tester l'application avec des exemples concrets.

N'oubliez pas de vérifier les informations de connexion à la base de données dans le fichier `.env` avant d'exécuter cette commande.

## Documentation supplémentaire

Pour plus d'informations sur l'utilisation de Symfony, vous pouvez consulter la documentation officielle de Symfony :[Symfony Documentation](https://symfony.com/doc).

Merci d'utiliser OCPHP13_GGNW !
