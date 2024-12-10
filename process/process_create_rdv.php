
<?php

require_once '../utils/connect_db.php';


// INSERER ICI validation du formulaire





$sql = "INSERT INTO appointments (dateHour, idPatients)
 VALUES (:dateHour, :idPatients)";
$dateHour = $_POST['date']." ". $_POST['heure'] ;
try {
    $stmt = $pdo->prepare($sql);
    $users = $stmt->execute([
        ':dateHour' => $dateHour,
        ':idPatients' => $_POST["idPatient"]
       
    ] 
); // ou fetch si vous savez que vous n'allez avoir qu'un seul résultat

echo "RDV pris";


} catch (PDOException $error) {
    echo "Erreur lors de la requete : " . $error->getMessage();
}


header("Location: ../liste-rdv.php");
// exit;