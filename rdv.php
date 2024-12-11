<?php
require_once './utils/connect_db.php';
date_default_timezone_set('UTC'); // Définir le fuseau horaire
$today = date("Y-m-d");

// 1. Récupérer l'ID du rendez-vous
$idRdv = $_POST['idRdv'] ?? null;

if (!$idRdv) {
    die("ID du rendez-vous non fourni.");
}

// 2. Récupérer les informations du rendez-vous
$sql = "SELECT appointments.*, patients.firstname, patients.lastname 
        FROM appointments 
        JOIN patients ON appointments.idPatients = patients.id
        WHERE appointments.id = :idRdv";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([':idRdv' => $idRdv]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$appointment) {
        die("Rendez-vous introuvable.");
    }
} catch (PDOException $error) {
    die("Erreur lors de la récupération du rendez-vous : " . $error->getMessage());
}

// 3. Traitement de la mise à jour si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $idPatient = $_POST['idPatient'];
    $dateHour = $_POST['date'] . " " . $_POST['heure'];

    $updateSql = "UPDATE `appointments` 
                  SET `idPatients` = :idPatient, 
                      `dateHour` = :dateHour 
                  WHERE `id` = :idRdv";
    $updateStmt = $pdo->prepare($updateSql);

    try {
        $updateStmt->execute([
            ':idPatient' => $idPatient,
            ':dateHour' => $dateHour,
            ':idRdv' => $idRdv,
        ]);
        echo "<p>Rendez-vous mis à jour avec succès ! <a href='./liste-rdv.php'>Retour à la liste des rendez-vous</a></p>";
    } catch (PDOException $error) {
        echo "<p>Erreur lors de la mise à jour : " . $error->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Rendez-vous</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Modifier le Rendez-vous</h1>
    <form action="./rdv.php" method="post">
        <input type="hidden" name="idRdv" value="<?= htmlspecialchars($appointment['id']) ?>">

        <label for="date">Date :</label>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars(substr($appointment['dateHour'], 0, 10)) ?>" min="<?= $today ?>">

        <label for="heure">Heure :</label>
        <input type="time" name="heure" id="heure" value="<?= htmlspecialchars(substr($appointment['dateHour'], 11, 5)) ?>" min="09:00" max="18:00">

        <label for="idPatient">Patient :</label>
        <select name="idPatient" id="idPatient">
            <?php
            // Récupérer tous les patients pour les afficher dans le menu déroulant
            $sqlPatients = "SELECT * FROM `patients`";
            $stmtPatients = $pdo->query($sqlPatients);
            $patients = $stmtPatients->fetchAll(PDO::FETCH_ASSOC);

            foreach ($patients as $patient) {
                $selected = $patient['id'] == $appointment['idPatients'] ? 'selected' : '';
                echo "<option value='{$patient['id']}' $selected>{$patient['lastname']} {$patient['firstname']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="update">Modifier</button>
    </form>

    <p><a href="./liste-rdv.php">Retour à la liste des rendez-vous</a></p>
</body>

</html>
