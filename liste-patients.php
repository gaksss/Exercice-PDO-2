<?php
require_once './utils/connect_db.php';

$sql = "SELECT * FROM `patients`";

try {
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // ou fetch si vous savez que vous n'allez avoir qu'un seul résultat

} catch (PDOException $error) {
    echo "Erreur lors de la requete : " . $error->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<ol>
        <h1>Liste des patients :</h1>

        <?php
        foreach ($users as $user) {
        ?>  
            <li>Nom : <?= $user['lastname']  ?> | Prénom : <?= $user['firstname']  ?>     
            <form action="./profil-patient.php" method="post">
                <input type="hidden" name="idPatient" value="<?= $user['id'] ?>">
                <input type="submit" value="Voir plus">
            </form>
        </li>

        <?php
        }

        ?>

    </ol>


    <a href="./create_patient.php">Créer un patient</a>
    <a href="./index.php">Accueil</a>
</body>
</html>