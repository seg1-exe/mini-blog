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
    $pseudo = $_POST['pseudo'] ?? '';
    $email = $_POST['email'] ?? '';
    $texte = $_POST['texte'] ?? '';

    $pseudo = mysqli_real_escape_string($conn, $pseudo);
    $email = mysqli_real_escape_string($conn, $email);
    $texte = mysqli_real_escape_string($conn, $texte);

    if ($pseudo !== '' && $email !== '' && $texte !== '') {
        $date = time();
        $sql = "INSERT INTO commentaire (pseudo, email, texte, date) VALUES ('$pseudo', '$email', '$texte', $date)";
        if (mysqli_query($conn, $sql)) {
            $message = 'Commentaire enregistré.';
        } else {
            $message = 'Erreur lors de l\'insertion : ' . mysqli_error($conn);
        }
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un commentaire</title>
</head>
<body>
    <h1>Ajouter un commentaire</h1>

    <?php if ($message !== ''): ?>
        <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form action="commentaire.php" method="post">
        <div>
            <label for="pseudo">Pseudo :</label><br>
            <input type="text" id="pseudo" name="pseudo" maxlength="50" required>
        </div>
        <div>
            <label for="email">Email :</label><br>
            <input type="email" id="email" name="email" maxlength="100" required>
        </div>
        <div>
            <label for="texte">Commentaire :</label><br>
            <textarea id="texte" name="texte" rows="5" cols="60" required></textarea>
        </div>
        <div>
            <button type="submit">Envoyer</button>
        </div>
    </form>

    <p><a href="afficher_comm.php">Voir les commentaires</a></p>
</body>
</html>
<?php
mysqli_close($conn);
?>
