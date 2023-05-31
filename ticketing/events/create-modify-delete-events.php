<?php  
require '../../inc/functions.php';
require '../../inc/pdo.php';
session_start();

$title = "Gestion des évènements";
$website_part = "Billetterie";
$my_token = $_GET['your_token'];
$check = token_check($my_token, $auth_pdo);
if(!$check){
    header("Location: ../dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= $website_part ?></title>
    <link rel="stylesheet" href="../styles/ticketing.css">
</head>
<body>
    <header>
    <h1><?= $title ?></h1>
    <br>
        <nav>
            <ul>
                <a class="boutton" href="./create-event.php?your_token=<?= $my_token ?>&username=<?= $_GET['username'] ?>"><li>Créer un évènement</li></a>
                <a class="boutton" href="./modify-event.php?your_token=<?= $my_token ?>&username=<?= $_GET['username'] ?>"><li>Modifier évènement</li></a>
                <a class="boutton" href="./delete-event.php?your_token=<?= $my_token ?>&username=<?= $_GET['username'] ?>"><li>Supprimer un évènement</li></a>
                <a class="boutton" href="../dashboard.php?your_token=<?= $my_token ?>&username=<?= $_GET['username'] ?>"><li>Retour</li></a>
            </ul>
        </nav>
    </header>
</body>
</html>