<?php
require_once("cnx.php");
// Vérifiez si l'ID a été transmis
if (!isset($_GET['id'])) {
    // Redirigez l'utilisateur vers rdv.php si aucun ID n'a été transmis
    header('Location: rdv.php');
    exit;
}

// Récupérez l'ID transmis
$id = $_GET['id'];

// Effectuez les vérifications de sécurité ici

// Exécutez la requête pour récupérer les données du message
$query = 'SELECT pushname AS NOMWhatsapp, mobile, message FROM rdv WHERE id = ?';
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$row = $stmt->fetch();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Message</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        /* taille par défaut pour la zone de texte */
        #message {
            height: 200px;
        }

        /* Masquez le formulaire de réponse par défaut */
        #reply-form {
            display: none;
        }
    </style>
    <script>
        // Fonction pour afficher le formulaire de réponse lorsque le bouton "Répondre" est cliqué
        function showReplyForm() {
            document.getElementById('reply-form').style.display = 'block';
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Message</h1>
        <!-- Affichez le nom, le numéro de téléphone et le message dans une zone de texte bootstrap bien stylisée non modifiable -->
        <div class="form-group">
            <label for="message">Message :</label>
            <textarea class="form-control" id="message" name="message" readonly><?php
                                                                                echo "Nom : " . echapperCaracteres($pdo, $row['NOMWhatsapp']) . "\n";
                                                                                echo "Numéro de téléphone : " . echapperCaracteres($pdo, $row['mobile']) . "\n";
                                                                                echo "Message : " . echapperCaracteres($pdo, $row['message']);
                                                                                ?></textarea>
        </div>
        <!-- Ajoutez un bouton pour retourner sur la page rdv.php -->
        <a href="rdv.php" class="btn btn-primary">Retourner au tableau</a>
        <!-- Ajoutez un bouton pour afficher le formulaire de réponse -->
        <button onclick="showReplyForm()" class="btn btn-success">Répondre</button>

        <!-- Ajoutez un formulaire pour répondre au message -->
        <div id="reply-form">
            <h2>Répondre</h2>
            <form action="send_message.php" method="post">
                <div class="form-group">
                    <label for="phone">Numéro de téléphone :</label><br>
                    <input type="text" id="phone" name="phone" value="<?php echo echapperCaracteres($pdo, $row['mobile']); ?>" readonly><br>
                </div>
                <div class="form-group">
                    <label for="message">Message :</label><br>
                    <textarea class="form-control" id="message" name="message"></textarea><br><br>
                </div>
                <input type="submit" value="Envoyer" class="btn btn-primary">
                <input type="reset" value="Effacer" class="btn btn-danger">
            </form>
        </div>
    </div>
</body>

</html>