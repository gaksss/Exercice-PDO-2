
<?php

require_once '../utils/connect_db.php';


// INSERER ICI validation du formulaire





$sql = "INSERT INTO patients (lastname, firstname, birthdate, phone, mail)
 VALUES (:lastname, :firstname, :birthdate, :phone, :mail)";

try {
    $stmt = $pdo->prepare($sql);
    $users = $stmt->execute([
        ':lastname' => $_POST["lastname"],
        ':firstname' => $_POST["firstname"],
        ':birthdate' => $_POST["birthdate"],
        ':phone' => $_POST["phone"],
        ':mail' => $_POST["mail"]
    ]); // ou fetch si vous savez que vous n'allez avoir qu'un seul résultat




} catch (PDOException $error) {
    echo "Erreur lors de la requete : " . $error->getMessage();
}


header("Location: ../liste-patients.php");
// exit;