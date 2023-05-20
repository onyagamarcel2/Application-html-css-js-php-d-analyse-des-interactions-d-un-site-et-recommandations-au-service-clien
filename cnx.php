<?php
// Configuration de la base de données
$config = parse_ini_file('config.ini');
$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Connexion à la base de données
    $pdo = new PDO($dsn, $config['user'], $config['password'], $options);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}

// Fonction pour échapper les caractères spéciaux dans une chaîne de caractères pour utilisation dans une requête SQL
function echapperCaracteres($pdo, $chaine)
{
    return $pdo->quote($chaine);
}
