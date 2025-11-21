<?php
$host     = 'localhost';
$user     = 'root';      
$password = '';
$dbname   = 'blog';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

$sql = "SELECT titre, texte FROM article";
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

    <p><a href="form.html">Ajouter un nouvel article</a></p>

    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $titre = htmlspecialchars($row['titre'], ENT_QUOTES, 'UTF-8');
            $texte = nl2br(htmlspecialchars($row['texte'], ENT_QUOTES, 'UTF-8'));

            echo "<article>";
            echo "<h2>$titre</h2>";
            echo "<p>$texte</p>";
            echo "<hr>";
            echo "</article>";
        }
    } else {
        echo "<p>Aucun article pour le moment.</p>";
    }

    if ($result) {
        mysqli_free_result($result);
    }
    mysqli_close($conn);
    ?>
</body>
</html>
