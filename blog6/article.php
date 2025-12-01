<?php
require_once 'config.php';

// Formulaire d'ajout d'article: traitement si POST
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs et suppression des espaces en début/fin
    $auteur = trim($_POST['auteur'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $texte = trim($_POST['texte'] ?? '');

    // Échapper les valeurs avant insertion pour éviter les erreurs SQL basiques
    $auteur = mysqli_real_escape_string($conn, $auteur);
    $titre = mysqli_real_escape_string($conn, $titre);
    $texte = mysqli_real_escape_string($conn, $texte);

    // Vérifier les champs obligatoires
    if ($titre !== '' && $texte !== '') {
        $date = time();
        // Insérer l'article dans la table 'article'
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
    <link rel="stylesheet" href="styles.css">
    <script src="main.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
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
</body>
</html>
<?php
mysqli_close($conn);
?>
