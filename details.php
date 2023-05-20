<?php
session_start();
require_once('cnx.php');

if (isset($_GET['idmenu'])) {
    // Récupère l'id depuis le paramètre GET et le nettoie
    $id = htmlspecialchars($_GET['idmenu']);
    $query = $pdo->prepare('SELECT id, pushname AS NOMWhatsapp, mobile, dateconsult, heureconsult FROM chatbotrecord WHERE idmenu = ? ORDER BY dateconsult DESC');
    $query->execute([$id]);

    //Récupère les résultats de la requête sous forme de tableau associatif
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Détails</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <h1>Détails de la consultation</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nom</th>
                        <th>Numéro de téléphone</th>
                        <th>Date de la consultation</th>
                        <th>Heure de la consultation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Boucle à travers les résultats et les affiche dans le tableau
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['NOMWhatsapp'] . "</td>";
                        echo "<td>" . $row['mobile'] . "</td>";
                        echo "<td>" . $row['dateconsult'] . "</td>";
                        echo "<td>" . $row['heureconsult'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>

    </html>
<?php

} else {
    // Redirige vers la page d'accueil si l'id n'est pas passé en paramètre GET
    header('Location: accueil.php');
    exit();
}
?>