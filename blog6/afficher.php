<?php
require_once 'config.php';

// Récupère l'ID de l'article depuis la query string
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$article = null;
$result_article = null;
$result_commentaires = null;
$nb_commentaires = 0;

// Si un id valide est fourni, on récupère l'article et ses commentaires
if ($id > 0) {
    // Requête pour l'article
    $sql = "SELECT id, auteur, titre, texte, `date` FROM article WHERE id = $id";
    $result_article = mysqli_query($conn, $sql);
    if ($result_article && mysqli_num_rows($result_article) === 1) {
        $article = mysqli_fetch_assoc($result_article);

        // Requête pour les commentaires liés à cet article (les plus récents d'abord)
        $sql_comm = "SELECT pseudo, texte, date FROM commentaire WHERE id_article = $id ORDER BY date DESC";
        $result_commentaires = mysqli_query($conn, $sql_comm);
        if ($result_commentaires) {
            $nb_commentaires = mysqli_num_rows($result_commentaires);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Article</title>
    <link rel="stylesheet" href="styles.css">
    <script src="main.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Article</h1>

    <?php if ($id <= 0): ?>
        <p>Aucun article spécifié.</p>
    <?php elseif (!$article): ?>
        <p>Article introuvable.</p>
    <?php else: ?>
        <?php
        // Préparer les valeurs affichées en appliquant l'échappement HTML
        $titre = htmlspecialchars($article['titre'], ENT_QUOTES, 'UTF-8');
        $auteur = htmlspecialchars($article['auteur'], ENT_QUOTES, 'UTF-8');
        $timestamp = (int) $article['date'];
        $date_affichee = $timestamp > 0 ? date('d/m/Y H:i', $timestamp) : '';
        $texte = nl2br(htmlspecialchars($article['texte'], ENT_QUOTES, 'UTF-8'));
        ?>
        <article>
            <h2><?php echo $titre; ?></h2>
            <p>
                <?php
                if ($auteur !== '') {
                    echo 'Par ' . $auteur . ' ';
                }
                if ($date_affichee !== '') {
                    echo '(' . $date_affichee . ')';
                }
                ?>
            </p>
            <p><?php echo $texte; ?></p>
        </article>

        <h2>Commentaires</h2>
        <?php
        // Affichage des commentaires (s'il y en a)
        if ($nb_commentaires > 0) {
            echo '<p>' . $nb_commentaires . ' commentaire';
            if ($nb_commentaires > 1) {
                echo 's';
            }
            echo '</p>';
            echo '<table>';
            while ($row = mysqli_fetch_assoc($result_commentaires)) {
                // Échapper les valeurs pour éviter l'injection HTML
                $pseudo = htmlspecialchars($row['pseudo'], ENT_QUOTES, 'UTF-8');
                $texte_comm = nl2br(htmlspecialchars($row['texte'], ENT_QUOTES, 'UTF-8'));
                $ts = (int) $row['date'];
                $date_comm = $ts > 0 ? date('d/m/Y H:i', $ts) : '';
                echo '<tr>';
                echo '<td class="col-nom">' . $pseudo . '<br>' . $date_comm . '</td>';
                echo '<td>' . $texte_comm . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Aucun commentaire.</p>';
        }
        ?>
        <p><a href="commentaire.php?id_article=<?php echo $id; ?>">Voir / ajouter des commentaires</a></p>
    <?php endif; ?>

</body>
</html>
<?php
// Libérer les résultats et fermer la connexion
if ($result_article) {
    mysqli_free_result($result_article);
}
if ($result_commentaires) {
    mysqli_free_result($result_commentaires);
}
mysqli_close($conn);
?>
