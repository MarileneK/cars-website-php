<?php
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

// 1. CONNEXION À LA BDD
// 1.1. On va stocker les éléments dans des variables
$dsn = 'mysql:dbname=php-pdo;host=localhost';
$user = 'root';
$password = 'root'; // sur Mac, le mdp sera 'root' 
// $password = ''; // sur PC, le mdp sera ''


// 1.2. Connexion à la BDD "php-pdo"

try {
    $bdd = new PDO($dsn, $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage() . "<br>";
}

// $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); => pour gérer les erreurs

// Notre objectif est 
// 2. J'utilise la méthode query()
$queryUsers = $bdd->query("SELECT * FROM users");

$allUsers = $queryUsers->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($allUsers);
// echo "</pre>";

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


        <!-- Instructions exercice :

        2_Execution de la requete avec la methode query
        3_Recuperer toutes les donnéeds dans une listes grace à la mathode fetchAll
        4_ Commencer votre tableau HTML
        5_ Ajoutez au tableau la boucle foreach, qui vous permet d'afficher toutes les données au bon endroit -->

        <h1>Tableau de tous les utilisateurs</h1>

        <a href="users.php">Allez vers le formulaire "utilisateur"</a>    

        <table>
            <thead>
                <tr>
                    <!-- <th colspan="7">Info de tous les utilisateurs</th> -->
                    <th>Numéro</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Permis de conduire</th>
                    <th>Adresse e-mail</th>
                    <th>Ville</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach($allUsers as $index => $user){
                    ?>
                    <tr>
                        <td><?= $user["id_users"] ?></td>
                        <td><?= $user["name"] ?></td>
                        <td><?= $user["firstName"] ?></td>
                        <td><?= $user["age"] ?></td>
                        <td><?= $user["drivingLicence"] ?></td>
                        <td><?= $user["email"] ?></td>
                        <td><?= $user["city"] ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    
            </tbody>
        </table>

    </body>

</html>
