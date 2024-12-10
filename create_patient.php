
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="./process/process_create_user.php" method="post">

        <label for="lastname">Nom : </label>
        <input type="text" name="lastname" id="lastname">

        <label for="firstname">Prenom : </label>
        <input type="text" name="firstname" id="firstname">

        <label for="birthdate">Date de naissance : </label>
        <input type="date" name="birthdate" id="birthdate">

        <label for="phone">Numéro de téléphone : </label>
        <input type="text"  maxlength="10" name="phone" id="phone" >

        <label for="mail">email : </label>
        <input type="text" name="mail" id="mail">



        <input type="submit" value="Creer patient">
    </form>
</body>

</html>