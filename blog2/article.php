<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'blog';

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auteur = $_POST['auteur'] ?? '';
    $titre = $_POST['titre'] ?? '';
    $texte = $_POST['texte'] ?? '';

    $auteur = mysqli_real_escape_string($conn, $auteur);
    $titre = mysqli_real_escape_string($conn, $titre);
    $texte = mysqli_real_escape_string($conn, $texte);

    if ($titre !== '' && $texte !== '') {
        $date = time();
        $sql = "INSERT INTO article (auteur, titre, texte, `date`) VALUES ('$auteur', '$titre', '$texte', $date)";
        if (mysqli_query($conn, $sql)) {
            $message = 'Article enregistré avec succès.';
        } else {
            $message = 'Erreur lors de l\'insertion : ' . mysqli_error($conn);
        }
    } else {
        $message = 'Veuillez remplir au minimum le titre et le texte.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvel article</title>
</head>
<body>
    <h1>Ajouter un article</h1>
    <?php if ($message !== ''): ?>
        <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <form action="article.php" method="post">
        <div>
            <label for="auteur">Auteur :</label><br>
            <input type="text" id="auteur" name="auteur" maxlength="50">
        </div>
        <div>
            <label for="titre">Titre :</label><br>
            <input type="text" id="titre" name="titre" maxlength="150" required>
        </div>
        <div>
            <label for="texte">Texte :</label><br>
            <textarea id="texte" name="texte" rows="10" cols="60" required></textarea>
        </div>
        <div>
            <button type="submit">Enregistrer l'article</button>
        </div>
    </form>
    <p><a href="lister.php">Liste des articles</a></p>
</body>
</html>
<?php
mysqli_close($conn);
?>
