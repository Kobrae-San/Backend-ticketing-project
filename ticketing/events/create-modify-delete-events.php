<?php  
require '../../inc/functions.php';
require '../../inc/pdo.php';
session_start();
if (isset($_GET["your_token"])){
    $hashed = $_GET["your_token"];
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
        <nav>
            <ul>
                <a href="create-event.php?your_token=<?= $hashed ?>&username=<?= $_GET['username'] ?>"><li>Créer un évènement</li></a>
                <a href="modify-event.php?your_token=<?= $hashed ?>&username=<?= $_GET['username'] ?>"><li>Modifier évènement</li></a>
                <a href="delete-event.php?your_token=<?= $hashed ?>&username=<?= $_GET['username'] ?>"><li>Supprimer un évènement</li></a>
                <a href=".././dashboard.php?your_token=<?= $hashed ?>&username=<?= $_GET['username'] ?>">Retour au menu principal</a>
            </ul>
        </nav>
    </header>
</body>
</html>
