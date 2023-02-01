# Vignettes

- [Vignettes](#vignettes)
- [Description du Projet](#description-du-projet)
  - [Contexte](#contexte)
  - [Description de l'application](#description-de-lapplication)
  - [Utilisateur connecté ayant le rôle USER](#utilisateur-connecté-ayant-le-rôle-user)
  - [Utilisateur connecté ayant le rôle ADMIN](#utilisateur-connecté-ayant-le-rôle-admin)
- [Installation](#installation)
  - [Première installation](#première-installation)
  - [Lancement](#lancement)
- [Maquette](#maquette)
- [Known issues](#known-issues)


# Description du Projet

## Contexte
Au sein de votre école, il est fréquent de réaliser des projets graphiques ou visuels. 
Souhaitant promouvoir les travaux ainsi réalisés par vos proches, votre formateur vous demande de réaliser un site web. 
L'idée est de réaliser un site avec une rapide ressemblance à Pinterest. C'est à dire, une application où sont affichées de nombreux médias filtrables par catégories. Les noms des élèves ne seront pas affichés, mais uniquement un mystérieux chiffre dont le détenteur est le créateur de l'oeuvre.

L'objectif de l'application sera d'être modulable et responsive, afin qu'il soit possible d'utiliser ce site pour de nombreuses thématiques. L'admin s'occupera d'activer et désactiver des catégories. 

## Description de l'application
Cette application de type SPA contiendra un grand dashboard, dans lequel, les utilisateurs connectés pourront rajouter du contenu. 
 
Les contenus seront représentés sous forme de blocs, affichant une vignette d'un média. Chaque bloc sera modifiable par l'admin en largeur et longueur afin de pouvoir personnaliser la page du dashboard.
  
La pluspart des utilisateurs ne seront pas connectés. Ces derniers n'auront aucun moyen d'uploader des données ni de modifier le dashboard.

Si un utilisateur connecté ou non connecté clique sur un bloc, celui-ci s'agrandit afin de prendre toute la taille de la page et afficher le média. Le titre et la description ainsi que le numéro de créateur seront également affichés. Il sera possible de cliquer sur le numéro du créateur ou de la catégorie pour retourner sur le dashboard avec des données filtrées.

Attention, si un son ou une vidéo est incorporée dans le bloc, le media devra se lancer automatiquement lors de l'ouverture du bloc. Une interface de contrôles du média sera affichée.

## Utilisateur connecté ayant le rôle USER

Une connection utilisateur sera requise pour accéder à l'interface d'admin.
Un utilisateur normal se connectera avec un email et un mot de passe et pourra uploader du contenu. Son numéro unique lui sera affiché.

Au sein d'un bloc, il sera possible de rajouter :

* une image
* et/ou un son
* ou une vidéo
* Un titre (obligatoire)
* Une courte description
* Une catégorie (obligatoire)

## Utilisateur connecté ayant le rôle ADMIN
Un super utilisateur pourra :
- ajouter/modifier/désactiver/supprimer des catégories
- ajouter/modifier/désactiver un compte utilisateur
- modérer le contenu des utilisateurs (Désactiver certains contenus). 

Cette application sera livrée au client avec un compte super utilisateur déjà présent dans la base de données.  Ce dernier sera le seul membre autorisé à créer des utilisateurs.

Un super utilisateur aura également la possibilité de configurer:
 - Au moins 3 thèmes : Fond Noir, Fond Blanc, Fond avec une image de son choix
 - Reglage de l'opacité du fond
 - Format des blocs possibles (en fonction du device)


# Installation

## Première installation
1. copier le fichier .env.example en .env

2. creer une base de données 'vignettes'

```shell
composer install
npm install
```

3. Compilation des assets
```shell
yarn watch
```

4. creer le fichier de migration
```shell
php bin/console doctrine:migrations:generate
```

5. migration de la base de données
```shell
symfony console doctrine:migrations:migrate
```

6. fixtures
```shell
symfony console doctrine:fixtures:load
```

7. Pour l'instant, ajouter une image nommée 'ninja.jpg' dans le dossier public/medias/images
## Lancement
```shell
symfony server:start
```

# Maquette

https://www.figma.com/proto/tsunSghzUlNysFafKwyJ4G/Blossom?node-id=0%3A1


# Known issues

```
In MetadataStorageError.php line 13:
                                                                                                           
  The metadata storage is not up to date, please run the sync-metadata-storage command to fix this issue.  
                                                                                                           

make:migration
```
Solution :
```shell
    php bin/console cache:clear
    php bin/console doctrine:cache:clear-metadata
    php bin/console cache:clear
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
```