<?php
require_once 'config.php';

// Récupère l'ID de l'article depuis la query string (ou depuis le formulaire POST)
$id_article = 0;
if (isset($_GET['id_article'])) {
    $id_article = (int) $_GET['id_article'];
}

// Valeurs pour le formulaire et messages d'erreur
$message = '';
$pseudo_val = '';
$email_val = '';
$texte_val = '';

// Traitement du formulaire d'ajout de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_article'])) {
        $id_article = (int) $_POST['id_article'];
    }

    // Récupération et nettoyage des champs
    $pseudo_val = trim($_POST['pseudo'] ?? '');
    $email_val = trim($_POST['email'] ?? '');
    $texte_val = trim($_POST['texte'] ?? '');

    // Validation simple: présence des champs et format email
    if ($id_article <= 0) {
        $message = 'Article invalide.';
    } elseif ($pseudo_val === '' || $email_val === '' || $texte_val === '') {
        $message = 'Veuillez remplir tous les champs.';
    } elseif (!filter_var($email_val, FILTER_VALIDATE_EMAIL)) {
        $message = 'Adresse email invalide.';
    } else {
        // Limiter la taille du commentaire
        if (function_exists('mb_strlen')) {
            $len = mb_strlen($texte_val, 'UTF-8');
        } else {
            $len = strlen($texte_val);
        }

        if ($len > 2000) {
            $message = 'Le commentaire est trop long (2000 caractères max).';
        } else {
            // Échapper avant insertion
            $pseudo_db = mysqli_real_escape_string($conn, $pseudo_val);
            $email_db = mysqli_real_escape_string($conn, $email_val);
            $texte_db = mysqli_real_escape_string($conn, $texte_val);
            $date = time();
            // Insérer le commentaire dans la table 'commentaire'
            $sql_insert = "INSERT INTO commentaire (pseudo, email, texte, date, id_article)
                           VALUES ('$pseudo_db', '$email_db', '$texte_db', $date, $id_article)";
            if (mysqli_query($conn, $sql_insert)) {
                $message = 'Commentaire enregistré.';
                // Vider les valeurs du formulaire
                $pseudo_val = '';
                $email_val = '';
                $texte_val = '';
            } else {
                $message = 'Erreur lors de l\'enregistrement du commentaire.';
            }
        }
    }
}

// Récupérer la liste des commentaires pour cet article (affichage)
$commentaires = null;
$nb = 0;

if ($id_article > 0) {
    $sql_select = "SELECT pseudo, texte, date FROM commentaire
                   WHERE id_article = $id_article
                   ORDER BY date DESC";
    $commentaires = mysqli_query($conn, $sql_select);
    if ($commentaires) {
        $nb = mysqli_num_rows($commentaires);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commentaires</title>
    <link rel="stylesheet" href="styles.css">
    <script src="main.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Commentaires</h1>

    <?php if ($message !== ''): ?>
        <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <?php if ($id_article <= 0): ?>
        <p>Aucun article spécifié.</p>
    <?php else: ?>

        <h2>
            <?php
            echo $nb . ' commentaire';
            if ($nb > 1) {
                echo 's';
            }
            ?>
        </h2>

        <?php
        if ($nb > 0) {
            echo '<table>';
            while ($row = mysqli_fetch_assoc($commentaires)) {
                $pseudo = htmlspecialchars($row['pseudo'], ENT_QUOTES, 'UTF-8');
                $texte = nl2br(htmlspecialchars($row['texte'], ENT_QUOTES, 'UTF-8'));
                $timestamp = (int) $row['date'];
                $date_affichee = $timestamp > 0 ? date('d/m/Y H:i', $timestamp) : '';
                echo '<tr>';
                echo '<td class="col-nom">';
                echo $pseudo . '<br>' . $date_affichee;
                echo '</td>';
                echo '<td>';
                echo $texte;
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Aucun commentaire pour le moment.</p>';
        }

        if ($commentaires) {
            mysqli_free_result($commentaires);
        }
        ?>

        <h2>Ajouter un commentaire</h2>
        <form action="commentaire.php?id_article=<?php echo $id_article; ?>" method="post">
            <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
            <div>
                <label for="pseudo">Pseudo :</label><br>
                <input type="text" id="pseudo" name="pseudo" maxlength="50"
                       value="<?php echo htmlspecialchars($pseudo_val, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div>
                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" maxlength="150"
                       value="<?php echo htmlspecialchars($email_val, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div>
                <label for="texte">Commentaire :</label><br>
                <textarea id="texte" name="texte" rows="5" cols="60" required><?php
                    echo htmlspecialchars($texte_val, ENT_QUOTES, 'UTF-8');
                ?></textarea>
            </div>
            <div>
                <button type="submit">Envoyer</button>
            </div>
        </form>

    <?php endif; ?>

</body>
</html>
<?php
mysqli_close($conn);
?>
