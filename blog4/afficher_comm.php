<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'blog';

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

$sql = "SELECT pseudo, texte, date FROM commentaire ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
$nb = ($result) ? mysqli_num_rows($result) : 0;
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
    <h1>
        <?php
        echo $nb . ' commentaire';
        if ($nb > 1) {
            echo 's';
        }
        ?>
    </h1>

    <p><a href="commentaire.php">Ajouter un commentaire</a></p>

    <?php
    if ($nb > 0) {
        echo '<table>';
        while ($row = mysqli_fetch_assoc($result)) {
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

    if ($result) {
        mysqli_free_result($result);
    }
    mysqli_close($conn);
    ?>
</body>
</html>
