<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'blog';

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

$sql = "SELECT id, auteur, titre, texte, `date` FROM article ORDER BY `date` DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des articles</title>
</head>
<body>
    <h1>Liste des articles</h1>
    <p><a href="article.php">Ajouter un article</a></p>
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $titre = htmlspecialchars($row['titre'], ENT_QUOTES, 'UTF-8');
            $auteur = htmlspecialchars($row['auteur'], ENT_QUOTES, 'UTF-8');
            $timestamp = (int) $row['date'];
            $date_affichee = $timestamp > 0 ? date('d/m/Y H:i', $timestamp) : '';
            $texte = $row['texte'];

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
</body>
</html>
