<?php
$host     = 'localhost';
$user     = 'root';
$password = '';
$dbname   = 'blog';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $texte = $_POST['texte'] ?? '';

    $titre = mysqli_real_escape_string($conn, $titre);
    $texte = mysqli_real_escape_string($conn, $texte);

    if (!empty($titre) && !empty($texte)) {
        $sql = "INSERT INTO article (titre, texte) VALUES ('$titre', '$texte')";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Article enregistré avec succès.</p>";
            echo '<p><a href="afficher.php">Voir les articles</a></p>';
            echo '<p><a href="form.html">Ajouter un autre article</a></p>';
        } else {
            echo "Erreur lors de l'insertion : " . mysqli_error($conn);
        }
    } else {
        echo "<p>Veuillez remplir tous les champs.</p>";
        echo '<p><a href="form.html">Retour au formulaire</a></p>';
    }
} else {
    echo "<p>Accès direct interdit. Veuillez passer par le formulaire.</p>";
    echo '<p><a href="form.html">Aller au formulaire</a></p>';
}

mysqli_close($conn);
?>
