<?php  
require '../../inc/functions.php';
require '../../inc/pdo.php';
session_start();
if (isset($_SESSION["token"])){
    $hashed = $_SESSION["token"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer - Modifier - Supprimer un évènement</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
    <h1>Menu évènement</h1>
    <br>
        <nav>
            <ul>
                <a href="create-event.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>"><li>Créer un évènement</li></a>
                <a href="modify-event.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>"><li>Modifier évènement</li></a>
                <a href="delete-event.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>"><li>Supprimer un évènement</li></a>
                <a href=".././dashboard.php?your_token=<?= $_SESSION["token"] ?>&username=<?= $_SESSION['username'] ?>"><li>Retour au menu principal</li></a>
            </ul>
        </nav>
    </header>
</body>
</html>
