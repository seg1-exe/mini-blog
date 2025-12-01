<?php
// Page d'accueil: affiche les derniers articles
require_once 'config.php';

// Requête pour récupérer les 5 derniers articles avec le nombre de commentaires
$sql = "SELECT a.id, a.auteur, a.titre, a.texte, a.`date`, COUNT(c.id) AS nb_commentaires
    FROM article a
    LEFT JOIN commentaire c ON c.id_article = a.id
    GROUP BY a.id, a.auteur, a.titre, a.texte, a.`date`
    ORDER BY a.`date` DESC
    LIMIT 5";
$result = mysqli_query($conn, $sql);
// $result contient le jeu de résultats ou false en cas d'erreur
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil du blog</title>
    <link rel="stylesheet" href="styles.css">
    <script src="main.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <h1>Derniers articles</h1>

    <form method="get" action="lister.php">
        <input type="text" name="q" placeholder="Rechercher un article..." />
        <button type="submit">Rechercher</button>
    </form>

    <?php
    // Si la requête a renvoyé des articles, on les affiche
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = (int) $row['id'];
            $titre = htmlspecialchars($row['titre'], ENT_QUOTES, 'UTF-8');
            $auteur = htmlspecialchars($row['auteur'], ENT_QUOTES, 'UTF-8');
            $timestamp = (int) $row['date'];
            $date_affichee = $timestamp > 0 ? date('d/m/Y H:i', $timestamp) : '';
            $texte = $row['texte'];
            $nb_commentaires = (int) $row['nb_commentaires'];

            if (function_exists('mb_substr')) {
                $apercu = mb_substr($texte, 0, 200, 'UTF-8');
                $longueur = mb_strlen($texte, 'UTF-8');
            } else {
                $apercu = substr($texte, 0, 200);
                $longueur = strlen($texte);
            }

            if ($longueur > 200) {
                $apercu .= '...';
            }

            // Préparer un aperçu safe du texte (echappement + sauts de ligne)
            $apercu = nl2br(htmlspecialchars($apercu, ENT_QUOTES, 'UTF-8'));

            echo '<article>';
            echo '<h2>' . $titre . '</h2>';
            echo '<p>';
            if ($auteur !== '') {
                echo 'Par ' . $auteur . ' ';
            }
            if ($date_affichee !== '') {
                echo '(' . $date_affichee . ')';
            }
            echo '</p>';
            echo '<p>' . $apercu . '</p>';
            echo '<p>';
            echo $nb_commentaires . ' commentaire';
            if ($nb_commentaires > 1) {
                echo 's';
            }
            echo '</p>';
            // Liens vers la page de l'article et la page de commentaires
            echo '<p>';
            echo '<a href="afficher.php?id=' . $id . '">Lire l\'article</a> | ';
            echo '<a href="commentaire.php?id_article=' . $id . '">Voir les commentaires</a>';
            echo '</p>';
            echo '<hr>';
            echo '</article>';
        }
    } else {
        echo '<p>Aucun article pour le moment.</p>';
    }

    if ($result) {
        mysqli_free_result($result);
    }
    mysqli_close($conn);
    ?>

    <p><a href="lister.php">Voir plus d'articles</a></p>
</body>
</html>
