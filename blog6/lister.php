<?php
// Page de liste: recherche, tri et pagination des articles
require_once 'config.php';

// Paramètres de recherche et tri venant de l'URL
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';
if ($sort !== 'date_asc' && $sort !== 'date_desc') {
    $sort = 'date_desc';
}

// Déterminer l'ordre SQL selon le tri choisi
$order_sql = $sort === 'date_asc' ? 'a.`date` ASC' : 'a.`date` DESC';

// Construire la clause WHERE si une recherche est fournie
$where = '';
if ($q !== '') {
    $q_esc = mysqli_real_escape_string($conn, $q);
    $where = "WHERE (a.titre LIKE '%$q_esc%' OR a.texte LIKE '%$q_esc%' OR a.auteur LIKE '%$q_esc%')";
}

// Pagination: articles par page et numéro de page
$par_page = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

// Compter le nombre total d'articles pour la pagination
$sql_total = "SELECT COUNT(*) AS total FROM article a $where";
$result_total = mysqli_query($conn, $sql_total);
$total_articles = 0;
if ($result_total && ($row_total = mysqli_fetch_assoc($result_total))) {
    $total_articles = (int) $row_total['total'];
}
if ($result_total) {
    mysqli_free_result($result_total);
}

$total_pages = $total_articles > 0 ? (int) ceil($total_articles / $par_page) : 1;
if ($page > $total_pages) {
    $page = $total_pages;
}
$offset = ($page - 1) * $par_page;

// Requête principale pour récupérer les articles de la page courante
$sql = "SELECT a.id, a.auteur, a.titre, a.texte, a.`date`, COUNT(c.id) AS nb_commentaires
        FROM article a
        LEFT JOIN commentaire c ON c.id_article = a.id
        $where
        GROUP BY a.id, a.auteur, a.titre, a.texte, a.`date`
        ORDER BY $order_sql
        LIMIT $par_page OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Préparer les liens de pagination (prenant en compte q et sort si présents)
$link_prev = '';
$link_next = '';
$base_params = [];
if ($q !== '') {
    $base_params['q'] = $q;
}
if ($sort !== 'date_desc') {
    $base_params['sort'] = $sort;
}

if ($total_articles > 0 && $total_pages > 1) {
    if ($page > 1) {
        $params_prev = $base_params;
        $params_prev['page'] = $page - 1;
        $link_prev = 'lister.php?' . http_build_query($params_prev);
    }
    if ($page < $total_pages) {
        $params_next = $base_params;
        $params_next['page'] = $page + 1;
        $link_next = 'lister.php?' . http_build_query($params_next);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des articles</title>
    <link rel="stylesheet" href="styles.css">
    <script src="main.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <h1>Tous les articles</h1>

    <form method="get" action="lister.php">
        <input
            type="text"
            name="q"
            value="<?php echo htmlspecialchars($q, ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="Rechercher un article..." />
        <select name="sort">
            <option value="date_desc"<?php if ($sort === 'date_desc') echo ' selected'; ?>>
                Plus récents d'abord
            </option>
            <option value="date_asc"<?php if ($sort === 'date_asc') echo ' selected'; ?>>
                Plus anciens d'abord
            </option>
        </select>
        <button type="submit">Rechercher</button>
    </form>

    <?php
    if ($q !== '') {
        echo '<p>Résultats pour : <strong>' . htmlspecialchars($q, ENT_QUOTES, 'UTF-8') . '</strong></p>';
    }

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
            echo '<p>';
            echo '<a href="afficher.php?id=' . $id . '">Lire l\'article</a> | ';
            echo '<a href="commentaire.php?id_article=' . $id . '">Voir les commentaires</a>';
            echo '</p>';
            echo '<hr>';
            echo '</article>';
        }
    } else {
        if ($q !== '') {
            echo '<p>Aucun article ne correspond à votre recherche.</p>';
        } else {
            echo '<p>Aucun article pour le moment.</p>';
        }
    }

    if ($result) {
        mysqli_free_result($result);
    }

    if ($total_articles > 0 && $total_pages > 1) {
        echo '<div class="pagination">';
        echo '<span>Page ' . $page . ' / ' . $total_pages . '</span>';
        echo '<div class="pagination-links">';
        if ($link_prev !== '') {
            echo '<a href="' . htmlspecialchars($link_prev, ENT_QUOTES, 'UTF-8') . '">Page précédente</a>';
        }
        if ($link_next !== '') {
            if ($link_prev !== '') {
                echo ' | ';
            }
            echo '<a href="' . htmlspecialchars($link_next, ENT_QUOTES, 'UTF-8') . '">Page suivante</a>';
        }
        echo '</div>';
        echo '</div>';
    }

    mysqli_close($conn);
    ?>
</body>
</html>
