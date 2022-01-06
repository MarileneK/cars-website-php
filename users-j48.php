<?php
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    // 1_Formulaire avec les champs
    // 2_ Créer la table sql "conducteur" avec les champs (sans oublier le champs id
    // 3_ Dans le formulaire, recuperer les informations dans le POST
    // 4_ Enregistrer les infos dans des variables
    // 5_ Connexion a la BDD
    // 6_ Preparer la requete
    // 7_ Executer la requete avec la bonne liste au parametre
    // 8_ Recuperer dans une variable l'information de si la requete est un succes ou non.
    // Si c'est un succes, afficher le message que l'enregistrement est reussi
    

    // 5.2.
    $message = "";

    // 1.1
    if (isset($_POST["name"]) && !empty($_POST["name"])
    && isset($_POST["firstName"]) && !empty($_POST["firstName"])
    && isset($_POST["age"]) && !empty($_POST["age"])
    && isset($_POST["drivingLicence"]) && !empty($_POST["drivingLicence"])
    && isset($_POST["email"]) && !empty($_POST["email"])
    && isset($_POST["city"]) && !empty($_POST["city"])
    && isset($_POST["password"]) && !empty($_POST["password"])
    ) {

        // 1.2.
        $nom = ucfirst(trim($_POST["name"]));
        $prenom = ucfirst(trim($_POST["firstName"]));
        $age = trim($_POST["age"]);
        $permis = $_POST["drivingLicence"];
        $email = trim($_POST["email"]);
        $city = ucfirst(trim($_POST["city"]));
        $mdpHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        // On va hasher le mdp avec la méthode password_hash()


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

        // 3. Préparation de la requête
        $prepareRequest = $bdd->prepare("INSERT INTO users (name, firstName, age, drivingLicence, email, city, password) VALUES (?, ?, ?, ?, ?, ?, ?)");

        // 4. Exécution de la requête
        $result = $prepareRequest->execute([
            $nom,
            $prenom,
            $age,
            $permis,
            $city,
            $email,
            $mdpHash
        ]);

        if ($result) {
            $message = "<p>Bienvenue $prenom $nom ! Nous sommes ravis de vous compter parmi nous !</p>";
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
        <title>Formulaire voiture</title>
        <link rel="icon" href="images/smiley-tire-la-langue.jpg" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/style.css" /> 
    </head>

    <body>

    <!-- Exercice 3 : Realiser un formulaire avec la methode post, et affichez les données

    Nouveau conducteur 

    Nom
    Prenom
    Age
    Permis (liste deroulante)
    Mail
    Ville
    Mot de passe
    -->

        <h1>Ajouter un nouvel utilisateur</h1>

        <a href="index.php">Aller vers le formulaire "voiture"</a>

        <!-- 5.1. Affichage du message après le submit -->
        <?= $message ?>
        
        <form action="#" method="POST">
            <label for="name">Nom de famille</label>
            <input type="text" name="name" id="name">

            <label for="firstName">Prénom</label>
            <input type="text" name="firstName" id="firstName">

            <label for="age">Âge</label>
            <input type="number" name="age" id="age">

            <label for="drivingLicence">Préciser le type de permis de conduire</label>
            <select name="drivingLicence" id="drivingLicence">
                <option value="" selected disabled>-- Choisir --</option>
                <option value="catB">Permis auto - catégorie B</option>
                <option value="catA">Permis moto - catégorie A</option>
                <option value="catC&D">Permis professionnels - catégories C et D</option>
                <option value="catE">Permis remorque - catégorie E</option>
                <option value="noDrivingL">Pas de permis</option>
            </select>


            <label for="email">E-mail</label>
            <input type="text" name="email" id="email">

            <label for="city">Ville</label>
            <input type="text" name="city" id="city">

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">

            <input type="submit" value="Valider">
        </form>

    </body>

</html>
