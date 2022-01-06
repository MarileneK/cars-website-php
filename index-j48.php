<?php
/* Exercice : Faites en sorte que le formulaire "ajouter une nouvelle voiture" ajoute la nouvelle voiture dans la BDD.
Affichez alors un message de succes */

echo "<pre>";
print_r($_POST);
echo "</pre>";

// 4.2. J'assigne des empty strings à la variable $message
$message = "";

// 1. Récupération des infos saisis dans input
// 1.1. Si je récupère des infos dans chaque input et si les champs ne sont pas vides...
if (isset($_POST["brand"]) && !empty($_POST["brand"])
&& isset($_POST["model"]) && !empty($_POST["model"])
&& isset($_POST["speed"]) && !empty($_POST["speed"])
&& isset($_POST["year"]) && !empty($_POST["year"])
&& isset($_POST["color"]) && !empty($_POST["color"])
) {

    // 1.2. ... alors, je vais stocker les infos dans des variables
    $marque = ucfirst(trim($_POST["brand"])); // Je vais formater la saisie en mettant une majuscule à la 1ère lettre et en retirant les espaces au début et à la fin de la saisie
    $modele = $_POST["model"];
    $puissance = $_POST["speed"];
    $annee = $_POST["year"];
    $couleur = $_POST["color"];


    // 2. Connexion à la BDD
    $dsn = 'mysql:dbname=php-pdo;host=localhost';
    $user = 'root';
    $password = 'root';

    try {
        $bdd = new PDO($dsn, $user, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Échec lors de la connexion : ' . $e->getMessage();
    }

    // 3. Je prépare la requête
    $prepareRequest = $bdd->prepare("INSERT INTO cars (brand, model, speed, year, color) VALUES (?, ?, ?, ?, ?)");

    $result = $prepareRequest->execute([
        $marque,
        $modele,
        $puissance,
        $annee,
        $couleur
    ]);

    if ($result) {
        $message = "<p>Bravo, votre $marque s'est bien ajoutée à la base de données !</p>";
    } else {
        $message = "<p>Oops, quelque chose ne s'est pas déroulé correctement...</p>";
    }
} 


?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="Web tutorials"><!--description de la page-->
        <meta name="keywords" content="HTML,CSS,JavaScript"> <!--Mot clef de la page-->
        <meta name="author" content="Marilène Khieu"><!--Auteur du site-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Base d'une page</title>
        <link rel="icon" href="images/smiley-tire-la-langue.jpg" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/style.css" /> 
    </head>

    <body>

        <a href="users-j48.php">Allez vers le formulaire "utilisateur"</a>
        
        <h1>Ajouter une nouvelle voiture</h1>
        
        <form action="#" method="POST">
        <div id="container">
            <div>
                <label for="brand">Marque</label>
                <input type="text" name="brand" id="brand">
            </div>
            
            <div>
                <label for="model">Modèle</label>
                <input type="text" name="model" id="model">
            </div>

            <div>
                <label for="speed">Puissance (en chevaux)</label>
                <input type="number" name="speed" id="speed">
            </div>

            <div>
                <label for="year">Année</label>
                <input type="number" name="year" id="year">
            </div>

            <div>
                <label for="color">Couleur</label>
                <input type="text" name="color" id="color">
            </div>

            <input type="submit" value="Ajouter">
        </div>
        </form>

        <div id="message">
            <!-- 4.1. J'ajoute ma variable au-dessus du formulaire -->
            <?= $message ?>
        </div>

    </body>

</html>
