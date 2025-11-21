# Mini blog - Projet de base de données
## Arthur Gillier

### Etape 1 : Création de l'environnement

Afin de réaliser ce projet de mini blog il faut commencer avec une base de données contenant pour le moment une seule table `blog`, composée de deux colonnes : `titre` et `texte`. C'est ce que j'ai pu créer via phpMyAdmin, le fichier de création existe sous le nom de `etape1.sql`. 

J'ai pu ensuite créer le `form.html` me permettant d'avoir une interface pour rentrer les données. 

Données que je récupère grâce à `inserer.php` qui se connecte à la base de donnée, et réalise l'insertion dans cette dernière.

Enfin pour finir cette étape j'ai créé le script `afficher.php` qui comme son comparse se connecte à la base de données pour récupérer les données de la table article.

### Etape 2 : 