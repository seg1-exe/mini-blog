USE blog;

START TRANSACTION;

-- ---------------------------
-- Nouveaux articles
-- ---------------------------

INSERT INTO article (auteur, titre, texte, `date`) VALUES
(
  'Lucie',
  'Pourquoi apprendre le PHP en 2025 ?',
  'PHP est encore très présent dans le web, notamment via des frameworks et des outils comme WordPress, Drupal ou Symfony. Pour un premier projet, c’est un langage simple à installer, qui s’exécute presque partout et qui permet de comprendre rapidement le fonctionnement d’un site dynamique.
  
Apprendre le PHP en 2025, ce n’est pas seulement apprendre une “vieille” techno, c’est surtout se donner les bases de la programmation côté serveur : requêtes HTTP, sessions, interactions avec une base de données, sécurité de base, formulaires, etc.
  
Une fois ces concepts compris, il est beaucoup plus facile de passer à d’autres environnements (Node.js, Python, Go…).',
  UNIX_TIMESTAMP('2025-11-25 18:05:00')
),
(
  'Karim',
  'Découvrir MySQL pour ses premiers projets',
  'MySQL est l’un des systèmes de gestion de bases de données les plus populaires pour les projets web débutants. Il est libre, bien documenté et largement supporté par les hébergeurs.
  
Pour un mini blog, MySQL permet de créer des tables simples comme “article” et “commentaire”, de faire des requêtes SELECT pour l’affichage et des INSERT pour l’enregistrement des données du formulaire.
  
Comprendre les clés primaires, les jointures et les index permet ensuite d’aller plus loin : performances, statistiques, filtres avancés, etc.',
  UNIX_TIMESTAMP('2025-11-25 18:20:00')
),
(
  'Emma',
  'Faut-il encore avoir un blog en 2025 ?',
  'Entre les réseaux sociaux, les newsletters et les plateformes de vidéos, on pourrait croire que le blog est dépassé. Pourtant, il reste un espace précieux pour publier des contenus plus longs, mieux structurés et surtout mieux référencés par les moteurs de recherche.
  
Un blog permet aussi de garder le contrôle sur son contenu : pas d’algorithme qui décide qui voit quoi, pas de format imposé, et la possibilité de modifier ou d’archiver ses articles comme on le souhaite.
  
En 2025, avoir un blog, c’est surtout avoir un “home” sur le web, qui centralise ses projets, ses idées et ses expériences.',
  UNIX_TIMESTAMP('2025-11-25 18:40:00')
),
(
  'Nina',
  'Les bases du responsive design en CSS',
  'Le responsive design consiste à faire en sorte qu’une page web s’adapte à la taille de l’écran : ordinateur, tablette, smartphone. En pratique, cela passe par l’utilisation de flexbox, de grilles CSS, de largeurs en pourcentage et de media queries.
  
L’objectif n’est pas que tout soit identique sur tous les écrans, mais que le contenu reste lisible et agréable à parcourir. Souvent, cela signifie réduire les marges, passer certaines sections en colonne et agrandir les boutons sur mobile.
  
Même pour un mini blog, penser responsive dès le début rend le projet beaucoup plus agréable à utiliser.',
  UNIX_TIMESTAMP('2025-11-25 19:00:00')
),
(
  'Arthur',
  'Comment bien commenter son code ?',
  'Les commentaires dans le code ne servent pas à répéter ce que fait chaque ligne, mais à expliquer pourquoi une solution a été choisie, quelles sont les contraintes ou les pièges à connaître.
  
De bons commentaires sont courts, à jour et placés aux bons endroits : au début d’un fichier, d’une fonction ou d’un bloc un peu complexe. Ils complètent un code déjà clair, ils ne le remplacent pas.
  
Dans un petit projet de blog, documenter les parties qui touchent à la sécurité, aux requêtes SQL ou à la validation des formulaires est déjà un très bon réflexe.',
  UNIX_TIMESTAMP('2025-11-25 19:15:00')
);

-- ---------------------------
-- Commentaires sur les articles EXISTANTS
-- (en utilisant le titre pour retrouver l'id)
-- ---------------------------

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'FanDeJul',
  'fan.jul@example.com',
  'Franchement, je suis d''accord, on sous-estime trop souvent son impact sur la culture populaire. Même si tout le monde n''aime pas, il a quand même marqué une génération.',
  UNIX_TIMESTAMP('2025-11-25 19:25:00'),
  id
FROM article
WHERE titre = 'Jul est-il visionnaire ?'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'Sceptique13',
  'sceptique@example.com',
  'Visionnaire je ne sais pas, mais il a au moins compris comment utiliser Internet et les réseaux pour sortir énormément de sons.',
  UNIX_TIMESTAMP('2025-11-25 19:28:00'),
  id
FROM article
WHERE titre = 'Jul est-il visionnaire ?'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'Diam''sForever',
  'diamssss@example.com',
  'Merci, enfin quelqu''un qui le dit ! On oublie trop vite que Diam''s a marqué le rap français bien avant tout ça.',
  UNIX_TIMESTAMP('2025-11-25 19:30:00'),
  id
FROM article
WHERE titre = 'J''aime pas Jul'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'Moyen',
  'moyen@example.com',
  'Perso j''aime bien un peu des deux, ça dépend de l''humeur. Le débat est infini de toute façon 😄',
  UNIX_TIMESTAMP('2025-11-25 19:33:00'),
  id
FROM article
WHERE titre = 'J''aime pas Jul'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'LoremFan',
  'lorem@example.com',
  'Ce texte me donne envie de remplir des maquettes de sites pendant des heures. Vive le lorem ipsum.',
  UNIX_TIMESTAMP('2025-11-25 19:35:00'),
  id
FROM article
WHERE titre = 'Ceci n''est pas le titre'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'Maquettiste',
  'maquettiste@example.com',
  'Parfait pour tester la mise en page de ton blog. Maintenant il ne manque plus qu''un vrai contenu 😉',
  UNIX_TIMESTAMP('2025-11-25 19:38:00'),
  id
FROM article
WHERE titre = 'Ceci n''est pas le titre'
LIMIT 1;

-- ---------------------------
-- Commentaires sur les NOUVEAUX articles
-- ---------------------------

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'EtudiantWeb',
  'etudiant.web@example.com',
  'Je débute en développement et PHP/MySQL me semble encore un bon point de départ. Ton article me rassure un peu sur mes choix.',
  UNIX_TIMESTAMP('2025-11-25 19:45:00'),
  id
FROM article
WHERE titre = 'Pourquoi apprendre le PHP en 2025 ?'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'FullStackEnHerbe',
  'fullstack@example.com',
  'On critique souvent PHP mais au final, pour comprendre la logique serveur + base de données, c''est super clair.',
  UNIX_TIMESTAMP('2025-11-25 19:48:00'),
  id
FROM article
WHERE titre = 'Pourquoi apprendre le PHP en 2025 ?'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'DataCurieux',
  'data.curieux@example.com',
  'La partie sur les clés primaires et les index m''aide bien, je voyais ça comme un truc compliqué alors que c''est assez logique.',
  UNIX_TIMESTAMP('2025-11-25 19:52:00'),
  id
FROM article
WHERE titre = 'Découvrir MySQL pour ses premiers projets'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'SQLNoob',
  'sql.noob@example.com',
  'Merci pour le rappel sur les requêtes de base. Avec un exemple concret comme un blog, ça devient beaucoup plus concret.',
  UNIX_TIMESTAMP('2025-11-25 19:55:00'),
  id
FROM article
WHERE titre = 'Découvrir MySQL pour ses premiers projets'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'Blogger2025',
  'blogger@example.com',
  'Je confirme, mon blog m''a permis d''être trouvé par des recruteurs, alors que mes réseaux sociaux se perdaient dans le flux.',
  UNIX_TIMESTAMP('2025-11-25 20:00:00'),
  id
FROM article
WHERE titre = 'Faut-il encore avoir un blog en 2025 ?'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'TeamNewsletter',
  'newsletter@example.com',
  'J''aime bien combiner blog + newsletter : les articles de fond sur le blog, et un résumé dans la boîte mail des gens.',
  UNIX_TIMESTAMP('2025-11-25 20:03:00'),
  id
FROM article
WHERE titre = 'Faut-il encore avoir un blog en 2025 ?'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'FrontDev',
  'front.dev@example.com',
  'Merci pour la piqûre de rappel sur les media queries, j''oublie toujours les petits écrans quand je code trop vite.',
  UNIX_TIMESTAMP('2025-11-25 20:07:00'),
  id
FROM article
WHERE titre = 'Les bases du responsive design en CSS'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'MobileFirst',
  'mobile.first@example.com',
  'Depuis que je code “mobile first”, j''ai beaucoup moins de surprises dans les maquettes. Ton article va dans ce sens.',
  UNIX_TIMESTAMP('2025-11-25 20:10:00'),
  id
FROM article
WHERE titre = 'Les bases du responsive design en CSS'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'CleanCode',
  'clean.code@example.com',
  'Je suis totalement d''accord : les meilleurs commentaires expliquent le “pourquoi”, pas le “comment”.',
  UNIX_TIMESTAMP('2025-11-25 20:15:00'),
  id
FROM article
WHERE titre = 'Comment bien commenter son code ?'
LIMIT 1;

INSERT INTO commentaire (pseudo, email, texte, date, id_article)
SELECT
  'CodeReviewFan',
  'code.review@example.com',
  'Dans mon équipe on demande toujours un petit bloc de commentaire en haut des fonctions sensibles, ça nous a sauvé plus d''une fois.',
  UNIX_TIMESTAMP('2025-11-25 20:18:00'),
  id
FROM article
WHERE titre = 'Comment bien commenter son code ?'
LIMIT 1;

COMMIT;
