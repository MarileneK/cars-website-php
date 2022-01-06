<?php
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

// 1. CONNEXION À LA BDD
// 1.1. On va stocker les éléments dans des variables
$dsn = 'mysql:dbname=php-pdo;host=localhost';
$user = 'root';
$password = 'root'; // sur Mac, le mdp sera 'root' 
// $password = ''; // sur PC, le mdp sera ''


// 1.2. Connexion à la BDD "php-pdo"
// $bdd : objet $bdd a une méthode exec()
// On crée un nouvel objet qui se connecte à la BDD
// new PDO() = on crée un objet de la classe PDO et entre parenthèses, on ajoute les éléments du constructor
// avec la fonction try catch, on va lui dire : essaie de te connecter à la BDD
// catch : essayer d'attaper une erreur et la stocker dans la variable $e
// getMessage() => va permettre d'afficher le code

try {
    $bdd = new PDO($dsn, $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage() . "<br>";
}

// $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); => pour gérer les erreurs

// 2. J'utilise la méthode exec() de la class PDO en lui passant ma requête en argument
// $request = "INSERT INTO cars (brand, model, speed, year, color) VALUES ('BMW', 'Z4', 5, 2012, 'black')";
// echo $bdd->exec($request);

// CONSEIL : on va tester notre requête SQL directement dans phpMyAdmin

// 3. J'affiche un message en fonction de l'exécution de la requête
// if ($bdd->exec($request)) {
//     echo "<p>La voiture a bien été ajoutée en base de données.</p>";
// } else {
//     echo "<p>Erreur : la base de données n'a pas été actualisée.</p>";
// }


// 4. On va ajouter une ligne dans notre table "cars"
// $marque = "Mercedes";
// $modele = "Classe A";
// $puissance = 7;
// $annee = 2020;
// $couleur = "blue";

// Pour se prémunir des comportements malveillants, on peut utiliser des méthodes comme "addSlashes", on peut assainer le code etc.
// $couleur = "blue); DROP TABLE cars";
// $couleur = "<script>alert("SPAM")</script>";


// 5. On voit qu'utilisée seule, la méthode exec() N'EST PAS SÉCURISÉE !!!
/* Elle est susceptible d'être attaquée en utilisant des failles sql ou des failles XXS
IMPORTANT : on utilisera exec() UNIQUEMENT pour des requêtes simples qui n'impliquent pas d'input utilisateurs
IMPORTANT : on devra mettre les valeurs entre des single quotes pour qu'elles soient lues correctement */

$request = "INSERT INTO cars (brand, model, speed, year, color) VALUES ('$marque', '$modele', '$puissance', '$annee', '$couleur')";

// if ($bdd->exec($request)) {
//     echo "<p>La voiture a bien été ajoutée en base de données.</p>";
// } else {
//     echo "<p>Erreur : la base de données n'a pas été actualisée.</p>";
// }

// 6. La méthode de la préparation des requêtes pour plus de sécurité

/* Ensuite, il y a 2 façons de lier les paramètres :
    - avec BindParam()
    - en argument de execute()
Puis, on utilise la méthode execute() pour exécuter la requête préparée.
Execute() nous renvoie "true" si tout a bien fonctionné, SINON "false"

Voir le détail de la documentation https://www.php.net/manual/fr/pdo.prepared-statements.php
*/

$marque = "Tesla";
$modele = "X";
$puissance = 10;
$annee = 2020;
$couleur = "black";

// ATTENTION étape primordiale : connexion à la BDD mais comme on l'a déjà fait, on saute cette étape

$prepareRequest = $bdd->prepare("INSERT INTO cars (brand, model, speed, year, color) VALUES (?, ?, ?, ?, ?)");

$result = $prepareRequest->execute([
    $marque,
    $modele,
    $puissance,
    $annee,
    $couleur
]);

// echo $result; // Prints 1

if ($result) {
    echo "<p>La $marque a bien été ajoutée !</p>";
} else {
    echo "<p>Il y a eu un problème avec l'enregistrement de $marque en base de données</p>";
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

    <!-- Exercice 1 : Réaliser un formulaire avec la methode post, et affichez les données
    Marque
    Modele
    Puissance (nombre)
    L'année
    La couleur

    Exercice 2 :  Creez une base de donnée.
    Nom de la bdd : php-pdo
    Nom de la table : Voiture
    Colonnes : Comme dans le formulaire

    Exercice 3 : Realiser un formulaire avec la methode post, et affichez les données

    Nouveau conducteur 

    Nom
    Prenom
    Age
    Permis (liste deroulante)
    Mail
    Ville
    Mot de passe
    -->
        <a href="users.php">Allez vers le formulaire "utilisateur"</a>    

        <form action="#" method="POST">
            <label for="brand">Marque</label>
            <input type="text" name="brand" id="brand">
            
            <label for="model">Modèle</label>
            <input type="text" name="model" id="model">

            <label for="speed">Puissance (en nombre)</label>
            <input type="number" name="speed" id="speed">

            <label for="year">Année</label>
            <input type="number" name="year" id="year">

            <label for="color">Couleur</label>
            <input type="text" name="color" id="color">

            <input type="submit" value="Ajouter">
        </form>

    </body>

</html>
