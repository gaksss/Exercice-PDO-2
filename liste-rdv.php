<?php
require_once './utils/connect_db.php';

$sql = "SELECT appointments.*, patients.firstname, patients.lastname 
        FROM appointments 
        JOIN patients ON appointments.idPatients = patients.id";

try {
    $stmt = $pdo->query($sql);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Erreur lors de la requête : " . $error->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des RDV</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <ol>
        <h1>Liste des RDV :</h1>

        <?php
        foreach ($appointments as $appointment) {
        ?>
            <li>
                RDV le <?= $appointment['dateHour'] ?> | Patient : <?= $appointment['firstname'] . ' ' . $appointment['lastname'] ?>
                <form action="./rdv.php" method="post">
                    <input type="hidden" name="idRdv" value="<?= $appointment['id'] ?>">
                    <input type="submit" value="Voir plus">
                </form>
            </li>
        <?php
        }
        ?>

    </ol>

    <a href="./create_patient.php">Créer un patient</a>
    <a href="./index.php">Accueil</a>
    <a href="./ajout-rdv.php">Créer un RDV</a>
</body>

</html>