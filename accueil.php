<?php
session_start();
require_once('cnx.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Formulaire de sélection de période</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Inclusion du CDN Bootstrap pour la mise en forme -->

    <!-- Inclusion du CDN de Chart.js pour le graphique -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"></script>
</head>

<body>

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
                    <li class="active"><a href="accueil.php">enregistrement</a></li>
                    <li><a href="rdv.php">Rendez-vous</a></li>
                    <li><a href="#">Feuille 3</a></li>
                    <li><a href="#">Feuille 4</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- formulaire de saisie des dates -->
    <div class="container mt-5">
        <h2>Sélection de période</h2>
        <form action="traitement.php" method="post" id="formDate">
            <div class="form-group">
                <label for="dateDebut">Date de début :</label>
                <input type="date" class="form-control" id="dateDebut" name="dateDebut" required value="<?php echo isset($_SESSION['dateDebut']) ? $_SESSION['dateDebut'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="dateFin">Date de fin :</label>
                <input type="date" class="form-control" id="dateFin" name="dateFin" required value="<?php echo isset($_SESSION['dateFin']) ? $_SESSION['dateFin'] : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>

        </form>
    </div>

    <!-- Affichage du tableau -->
    <?php

    if (isset($_SESSION['données']) && !empty($_SESSION['données']) && isset($_SESSION['données_graph']) && !empty($_SESSION['données_graph'])) {
        // Récupérer le résultat de la requête depuis la variable de session
        $resultat = $_SESSION['données'];
        $resultat_graph = json_decode($_SESSION['données_graph'], true);
        $donnees_graph_json = json_encode($resultat_graph);

    ?>

        <div class="container">
            <h1 class="text-center">Résultats</h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>libelle</th>
                            <th>ocurrence</th>
                            <th>détails</th>

                        </tr>
                    </thead>
                    <tbody id="tableauDonnees">
                        <?php foreach ($resultat as $row) { ?>
                            <tr>
                                <td><?php echo $row['libelle']; ?></td>
                                <td><?php echo $row['count']; ?></td>
                                <td><a href="details.php?idmenu=<?php echo $row['idmenu']; ?>" class="btn btn-info">Détails</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    } ?>

    <!-- Élément canvas pour le graphique -->
    <canvas id="graphique"></canvas>

    <!-- Inclusion du CDN de jQuery pour les fonctionnalités Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclusion du CDN de Bootstrap pour les fonctionnalités -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Récupération du contexte du canvas
        const ctx = document.getElementById('graphique').getContext('2d');

        // Récupération des données du graphique depuis la variable PHP
        const donnees = <?php echo isset($_SESSION['données_graph']) ? $_SESSION['données_graph'] : '[]'; ?>;


        // Configuration du graphique en bande
        const config = {
            type: 'bar',
            data: {
                labels: donnees.map(d => d.libelle),
                datasets: [{
                    label: 'Occurences',
                    data: donnees.map(d => d.count),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Création du graphique en bande
        const graphique = new Chart(ctx, config);
    </script>


</body>

</html>