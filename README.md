# knowledge-learning

Présentation

Knowledge Learning est une plateforme d’apprentissage en ligne réalisée avec Symfony 8.1.

Un utilisateur peut s’inscrire, confirmer son e-mail, acheter des cours, des leçons en ligne via Stripe, consulter sa progression et recevoir automatiquement une certification lorsqu’un cours est terminé.

Une interface administrateur créée avec EasyAdmin permet de gérer les utilisateurs, thèmes, cours, leçons et achats.

Fonctionnalités

Inscription et connexion des utilisateurs

Validation du compte via e-mail

Explorer les thèmes, les cursus et les leçons

Achat sécurisé via Stripe (Sandbox)

Accès au contenu acheté

Validation des leçons

Suivi de la progression

Attribution automatique de la certification

Interface d’administration avec EasyAdmin

Tests fonctionnels avec PHPUnit

Technologies utilisées

PHP 8.4+

Symfony 8.1

Doctrine ORM

MySQL

Twig

EasyAdmin

SDK Stripe pour PHP

PHPUnit

Pré-requis

Avant de lancer le projet, vous devez avoir :

PHP 8.4 ou supérieur

Composer

Symfony CLI

MySQL

Git

Installation

Cloner le dépôt :

git clone https://github.com/VOTRE-UTILISATEUR/knowledge-learning.git

Aller dans le dossier du projet :

cd knowledge-learning

Installer les dépendances :

composer install

Configuration

Créer un fichier . env. database : local et configurer la connexion avec votre base de données.

DATABASE_URL="mysql://utilisateur:motdepasse@127. 0.0.1:3306/knowledge_learning"

Ajoutez également vos clés Stripe de test :

STRIPE_PUBLIC_KEY=pk_test_xxxxxxxxxxxxxxxxx

STRIPE_SECRET_KEY=sk_test_xxxxxxxxxxxxxxxxx

Base de données

Créer la base de données :

php bin/console doctrine:database:create

Lancer les migrations :

php bin/console doctrine:migrations:migrate

Lancer l’application

symfony server:start

Le site sera disponible sur :

http://127.0.0.1:8000

Tests

Vous pouvez lancer les tests avec la commande :

php bin/phpunit

Au moment de finaliser ce projet :

9 tests

29 assertions

Tous les tests sont validés

Auteur

Ce projet a été réalisé par Jean-Pierre Noza
