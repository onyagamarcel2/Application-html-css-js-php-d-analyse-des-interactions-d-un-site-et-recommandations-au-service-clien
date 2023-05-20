<?php
session_start();
require_once('cnx.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Rendez-vous</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>



</head>

<body>



    <!-- Barre de navigation -->
    <nav class="navbar navbar-inverse"> <!-- Utilisation de la classe "navbar-inverse" pour un schéma de couleurs sombre -->
        <div class="container-fluid">
            <!-- Logo et bouton de navigation (pour les petits écrans) -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">accueil</a>
            </div>
            <!-- Liens de navigation -->
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="accueil.php">enregistrement</a></li>
                    <li class="active"><a href="rdv.php">Rendez-vous</a></li>
                    <li><a href="#">Feuille 3</a></li>
                    <li><a href="#">Feuille 4</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <h1>Liste des rendez-vous</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>Nom</th>
                    <th>Nom Whatsapp</th>
                    <th>Numéro de téléphone</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th>Heure</th>

                </tr>
            </thead>
            <tbody>
                <?php

                // Nombre de lignes par page
                $rows_per_page = 10;
                // Numéro de page actuel
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                // Calculer l'index de départ pour la requête SQL
                $start_index = ($current_page - 1) * $rows_per_page;

                // Prépare la requête SQL
                $query = $pdo->query("SELECT id, nom, pushname AS NomWhatsapp, mobile, libelle_sujet, date_msg, heure_msg, message FROM rdv LIMIT $start_index, $rows_per_page");

                // Récupère les résultats de la requête sous forme de tableau associatif
                $result = $query->fetchAll(PDO::FETCH_ASSOC);

                // Boucle à travers les résultats et les affiche dans le tableau
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['NomWhatsapp'] . "</td>";
                    echo "<td>" . $row['mobile'] . "</td>";
                    echo "<td>" . $row['libelle_sujet'] . "</td>";
                    echo "<td>" . $row['date_msg'] . "</td>";
                    echo "<td>" . $row['heure_msg'] . "</td>";
                    echo "<td><a class='btn btn-success' href='conversation.php?id=" . $row['id'] . "'>Afficher le Message</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        // Calculer le nombre total de pages
        $sql = "SELECT COUNT(*) as total_rows FROM rdv";
        $result = $pdo->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $total_rows = $row['total_rows'];
        $total_pages = ceil($total_rows / $rows_per_page);

        // Afficher les liens de pagination
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                echo "<strong>$i</strong> ";
            } else {
                echo "<a href=\"?page=$i\">$i</a> ";
            }
        }
        ?>
    </div>
</body>

</html>