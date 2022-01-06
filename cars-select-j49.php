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

// Notre objectif est d'afficher le résultat d'une requête
// 2. J'utilise la méthode query(). IMPORTANT : on va utiliser cette méthode avec une requête SQL de type "SELECT"
$resultQueryCars = $bdd->query("SELECT * FROM cars");

// echo "<pre>";
// print_r($resultQueryCars); 
// echo "</pre>";
// Prints:
// PDOStatement Object
// (
//     [queryString] => SELECT * FROM cars
// )

// On constate que $resultQuery ne contient pas directement tout le résultat de la requête mais qu'il convient un objet.


// 3. Méthode fetch(argument prédéfini)
// La méthode fetch() nous permet de récupérer UNE SEULE LIGNE sous la forme d'un tableau
// ATTENTION, il permet de recupérer uniquement la première ligne


// PDO::FETCH_ASSOC;    Permet d'avoir les noms de colonne comme index
// PDO::FETCH_NUM;      Permet d'avoir une liste numeroté dans l'ordre
// PDO::FETCH_BOTH;     Permet d'avoir les deux

// 4. Méthode fetchAll(argument prédéfini)
// On va utiliser la méthode fetchAll() pour récuperer TOUTES LES LIGNES de notre tableau
$allCars = $resultQueryCars->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($allCars); 
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

    <!-- Structure d'un tableau

        <table>
            <thead>
                <tr>
                    <th colspan="2">The table header</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>The table body</td>
                    <td>with two columns</td>
                </tr>
            </tbody>
        </table>

    -->
        <a href="users.php">Allez vers le formulaire "utilisateur"</a>    

        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Puissance</th>
                    <th>Année</th>
                    <th>Couleur</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    // 5. On va parcourir toutes les lignes
                    foreach($allCars as $index => $oneCar) {
                    ?>
                        <tr>
                            <td><?= $oneCar["id_car"] ?></td>
                            <td><?= $oneCar["brand"] ?></td>
                            <td><?= $oneCar["model"] ?></td>
                            <td><?= $oneCar["speed"] ?></td>
                            <td><?= $oneCar["year"] ?></td>
                            <td><?= $oneCar["color"] ?></td>

                            <!-- 6. On va passer l'ID de la voiture dans la lien grâce à la méthode GET -->
                            <td><a href="car-detail-j48.php?id=<?= $oneCar["id_car"] ?>">Product details</a></td>
                        </tr>
                    <?php
                    }
                ?>
            </tbody>
        </table>

    </body>

</html>
