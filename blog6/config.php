<?php
// Configuration de la connexion à la base de données
// Modifier ces paramètres si nécessaire (hôte, utilisateur, mot de passe, base)
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'blog';

// Ouverture d'une connexion MySQLi
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    // En cas d'erreur, on arrête le script et on affiche le message
    die('Erreur de connexion : ' . mysqli_connect_error());
}

// S'assurer que la communication utilise l'encodage UTF-8
mysqli_set_charset($conn, 'utf8mb4');
?>
