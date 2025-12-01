<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'blog';

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$article = null;

if ($id > 0) {
    $sql = "SELECT id, auteur, titre, texte, `date` FROM article WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) === 1) {
        $article = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Article</title>
</head>
<body>
    <h1>Article</h1>
    <p><a href="lister.php">Retour à la liste</a></p>

    <?php if ($id <= 0): ?>
        <p>Aucun article spécifié.</p>
    <?php elseif (!$article): ?>
        <p>Article introuvable.</p>
    <?php else: ?>
        <?php
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
    <?php endif; ?>

</body>
</html>
<?php
if (isset($result) && $result) {
    mysqli_free_result($result);
}
mysqli_close($conn);
?>
