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

### Etape 3 : Consultation détaillée des articles

Pour cette troisième étape, j’ai créé un nouveau répertoire `blog3` afin de continuer à faire évoluer le mini blog tout en conservant les versions précédentes. La base de données reste la même (`blog`), et la table `article` possède déjà une colonne `id` auto-incrémentée depuis l’étape 2, ce qui ne nécessite donc pas de modification supplémentaire de la structure.

J’ai ensuite adapté le script de liste des articles dans un nouveau fichier `lister.php`. Ce script se connecte à la base de données, récupère les articles dans l’ordre antichronologique, puis affiche leurs titres sous forme de liens. Chaque lien pointe vers une page de détail en passant l’identifiant de l’article dans l’URL, via un paramètre `id` (par exemple `afficher.php?id=3`).

Enfin, j’ai développé un nouveau script `afficher.php` qui se charge d’afficher un article précis à partir du paramètre `id`. Ce script récupère l’article correspondant dans la table article et en affiche le contenu complet : `titre`, `auteur`, `date` de publication ainsi que le texte intégral. Il gère également les cas où aucun identifiant n’est fourni ou lorsque l’article demandé n’existe pas, en affichant un message approprié.