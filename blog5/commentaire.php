<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'blog';

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

$id_article = 0;

if (isset($_GET['id_article'])) {
    $id_article = (int) $_GET['id_article'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_article'])) {
        $id_article = (int) $_POST['id_article'];
    }

    $pseudo = $_POST['pseudo'] ?? '';
    $email = $_POST['email'] ?? '';
    $texte = $_POST['texte'] ?? '';

    $pseudo = mysqli_real_escape_string($conn, $pseudo);
    $email = mysqli_real_escape_string($conn, $email);
    $texte = mysqli_real_escape_string($conn, $texte);

    if ($id_article > 0 && $pseudo !== '' && $email !== '' && $texte !== '') {
        $date = time();
        $sql_insert = "INSERT INTO commentaire (pseudo, email, texte, date, id_article)
                       VALUES ('$pseudo', '$email', '$texte', $date, $id_article)";
        mysqli_query($conn, $sql_insert);
    }
}

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
    <style>
        table {
            border-collapse: collapse;
            width: 500px;
        }
        td {
            border: 1px solid #000;
            vertical-align: top;
            padding: 4px;
        }
        .col-nom {
            width: 120px;
        }
    </style>
</head>
<body>
    <h1>Commentaires</h1>

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
                <input type="text" id="pseudo" name="pseudo" maxlength="50" required>
            </div>
            <div>
                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" maxlength="150" required>
            </div>
            <div>
                <label for="texte">Commentaire :</label><br>
                <textarea id="texte" name="texte" rows="5" cols="60" required></textarea>
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
