# Mini blog - Projet de base de données
## Arthur Gillier

### Etape 1 : Création de l'environnement

Afin de réaliser ce projet de mini blog il faut commencer avec une base de données contenant pour le moment une seule table `article`, composée de deux colonnes : `titre` et `texte`. C'est ce que j'ai pu créer via phpMyAdmin, le fichier de création existe sous le nom de `etape1.sql`. 

J'ai pu ensuite créer le `form.html` me permettant d'avoir une interface pour rentrer les données. 

Données que je récupère grâce à `inserer.php` qui se connecte à la base de donnée, et réalise l'insertion dans cette dernière.

Enfin pour finir cette étape j'ai créé le script `afficher.php` qui comme son comparse se connecte à la base de données pour récupérer les données de la table article.

### Etape 2 : Enrichissement de la structure et de l’affichage

Pour cette seconde étape, j’ai créé un nouveau répertoire `blog2` afin de faire évoluer le projet sans modifier directement la première version.

Du côté de la base de données, j’ai fait évoluer la table `article` en y ajoutant un identifiant unique `id` (entier auto-incrémenté), une colonne `auteur` pour stocker le nom de l’auteur de l’article, ainsi qu’une colonne `date` (entier) permettant d’enregistrer la date de création de l’article sous forme de timestamp.

J’ai ensuite fusionné le formulaire et le script d’insertion en un seul fichier `article.php`. Ce script affiche le formulaire de saisie (auteur, titre, texte) et, lorsqu’il est soumis, se connecte à la base de données pour insérer le nouvel article dans la table article avec la date courante.

Enfin, j’ai créé le script `lister.php` qui se charge d’afficher la liste des articles enregistrés. Il se connecte à la base de données, récupère les articles par ordre chronologique (du plus récent au plus ancien) et n’en affiche qu’un aperçu, limité à 200 caractères pour le texte de chaque article, afin d’avoir une vue synthétique du contenu.