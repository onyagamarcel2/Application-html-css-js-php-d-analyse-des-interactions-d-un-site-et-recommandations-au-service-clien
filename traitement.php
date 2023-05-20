<?php
session_start();
require_once('cnx.php');


// Fonction pour récupérer les données des menus sur la période spécifiée
function recupererMenusSurPeriode($dateDebut, $dateFin, $pdo)
{
    // Reformatage des variables $dateDebut et $dateFin au format 'd-m-Y'
    $dateDebut = date("d-m-Y", strtotime($dateDebut));
    $dateFin = date("d-m-Y", strtotime($dateFin));
    // Requête SQL pour récupérer les données des menus sur la période spécifiée
    $table = "chatbotrecord";
    $query = "SELECT libelle, idmenu, COUNT(*) AS count, dateconsult FROM $table WHERE dateconsult BETWEEN '$dateDebut' AND '$dateFin' GROUP BY idmenu ORDER BY count DESC";
    $resultat = $pdo->query($query);

    // Vérification du résultat de la requête
    if (!$resultat) {
        die("Erreur lors de la récupération des données dans la table $table : " . $pdo->error);
    }

    // Conversion des données en un tableau associatif
    $donnees = array();
    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $donnees[] = $row;
    }

    // Fermeture de la connexion à la base de données
    $pdo = null;

    // Retourne les données récupérées
    return $donnees;
}

// Vérification des paramètres de dateDebut et dateFin transmis
if (isset($_POST['dateDebut']) && isset($_POST['dateFin'])) {
    // Récupération des valeurs de dateDebut et dateFin depuis le formulaire
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];

    $_SESSION['dateDebut'] = $_POST['dateDebut'];
    $_SESSION['dateFin'] = $_POST['dateFin'];

    // Appel à la fonction pour récupérer les données des menus sur la période spécifiée
    $donneesMenus = recupererMenusSurPeriode($dateDebut, $dateFin, $pdo);

    //renvoie des informations traitées
    $_SESSION['données'] = $donneesMenus;
    $_SESSION['données_graph'] = json_encode($donneesMenus);
    header('Location: accueil.php ');
    // Retourne les données récupérées
    // return $donneesMenus;

} else {
    echo "Erreur : dateDebut et dateFin doivent être spécifiées.";
}
