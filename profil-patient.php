<?php
require_once './utils/connect_db.php';

// Vérifier si le formulaire de mise à jour a été soumis pour pas que ça lance le script dès que la page est mise 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Récupérer les données du formulaire
    $idPatient = $_POST['idPatient'];
    $lastname = $_POST['lastname'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $mail = $_POST['mail'] ?? '';

    // Requête UPDATE pour modifier les informations
    $updateSql = "UPDATE `patients` 
                  SET `lastname` = :lastname, 
                      `firstname` = :firstname, 
                      `birthdate` = :birthdate, 
                      `phone` = :phone, 
                      `mail` = :mail 
                  WHERE `id` = :id";
    $updateStmt = $pdo->prepare($updateSql);

    try {
        $updateStmt->execute([
            ':lastname' => $lastname,
            ':firstname' => $firstname,
            ':birthdate' => $birthdate,
            ':phone' => $phone,
            ':mail' => $mail,
            ':id' => $idPatient,
        ]);
        echo "Profil mis à jour avec succès ! <a href=./liste-patients.php>Revenir à la liste </a>";
    } catch (PDOException $error) {
        echo "Erreur lors de la mise à jour : " . $error->getMessage() . "<a href=./liste-patients.php>Revenir à la liste </a>";
    }
}

// Étape 2 : Récupérer les données actuelles pour affichage
$id = $_POST['idPatient'] ?? $_GET['idPatient'] ?? null; // Support POST et GET pour la première visite

if ($id) {
    $sql = "SELECT * FROM `patients` WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([':id' => $id]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo "Erreur lors de la récupération : " . $error->getMessage();
    }
} else {
    die("ID du patient non fourni !");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Modifier le Profil</h1>
    <?php if (!empty($users)) : ?>
        <?php foreach ($users as $user) : ?>
            <form action="./profil-patient.php" method="post">
                <input type="hidden" name="idPatient" value="<?= htmlspecialchars($user['id']) ?>">
                <input type="hidden" name="update" value="1"> <!-- Indicateur de mise à jour -->

                <div>
                    <label for="lastname">Nom :</label>
                    <input type="text" name="lastname" id="lastname" value="<?= htmlspecialchars($user['lastname']) ?>">
                </div>

                <div>
                    <label for="firstname">Prénom :</label>
                    <input type="text" name="firstname" id="firstname" value="<?= htmlspecialchars($user['firstname']) ?>">
                </div>

                <div>
                    <label for="birthdate">Date de naissance :</label>
                    <input type="date" name="birthdate" id="birthdate" value="<?= htmlspecialchars($user['birthdate']) ?>">
                </div>

                <div>
                    <label for="phone">Numéro de téléphone :</label>
                    <input type="text" name="phone" id="phone" maxlength="10" value="<?= htmlspecialchars($user['phone']) ?>" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                </div>

                <div>
                    <label for="mail">Email :</label>
                    <input type="text" name="mail" id="mail" value="<?= htmlspecialchars($user['mail']) ?>">
                </div>

                <div>
                    <button type="submit">Modifier</button>
                </div>
            </form>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucun patient trouvé.</p>
    <?php endif; ?>
</body>

</html>