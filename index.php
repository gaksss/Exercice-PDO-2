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
    <a href="./create_patient.php">Créer un patient</a>
    <a href="./liste-patients.php">Liste des patients</a>
    <a href="./ajout-rdv.php">Créer un RDV</a>
    <a href="./liste-rdv.php">Liste des RDV</a>
</body>

</html>