<?php
require_once './utils/connect_db.php';
date_default_timezone_set('UTC');
$today = date("Y-m-d");




$sql = "SELECT * FROM `patients` ";


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
    <form action="./process/process_create_rdv.php" method="post">

        <label for="date"></label>
        <input type="date" min="<?= $today ?>" name="date" id="date">
        <label for="heure"></label>
        <input type="time" name="heure" id="heure" min="09:00" max="18:00">
        <label for="patients"></label>
        <select name="idPatient" id="idPatient">
            <?php
            foreach ($users as $user) {
                echo '<option value="' . $user['id'] .  '">' . $user['lastname'] . " " . $user['firstname'] . '</option>';
            }
            ?>
        </select>
        <div>
            <button type="submit">Prendre RDV</button>

        </div>

    </form>
    <div class="listeRDV">
        <form action="./liste-rdv.php">
            <button type="submit" class="listeRDV">Liste RDV</button>
        </form>
    </div>
</body>

</html>