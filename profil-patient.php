<?php
require_once './utils/connect_db.php';


;
$id = $_POST['idPatient'];
$sql = "SELECT * FROM `patients` WHERE id = $id" ;

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
</head>
<body>
<?php
        foreach ($users as $user) {
        ?>
            <li>Nom : <?= $user['lastname']  ?> | Prénom : <?= $user['firstname']  ?> Date de naissance : <?= $user['birthdate']  ?> Numéro de téléphone : <?= $user['phone']  ?> Adresse mail : <?= $user['mail']  ?></li>

        <?php
        }

        ?>
</body>
</html>