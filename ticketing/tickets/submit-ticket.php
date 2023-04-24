<?php
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if(!isset($_SESSION["loggedin"]) && $method != "POST"): ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider un billet - Billetterie</title>
</head>
<body>
    <h1>Billetterie</h1>
    <div>
        <h2>Valider un billet</h2>
        <form method="POST">
            <label for="lastname">Nom : </label>
            <input type="text" id="lastname" name="lastname" placeholder="Indiquez votre nom de famille" required>
            
            <label for="lastname">Prénom : </label>
            <input type="text" id="firstname" name="firstname" placeholder="Indiquez votre prénom" required>

            <label for="public-ticket-code">Code public du Billet :</label>
            <input type="text" id="public-ticket-code" name="public-ticket" placeholder="Renseignez le code public"
             required>

            <input type="submit" value="Générer le lien du Billet">
        </form>
    </div>
</body>
</html>
<?php  
elseif ($method == "POST"):
    $last_name = filter_input(INPUT_POST, "lastname");
    $first_name = filter_input(INPUT_POST, "firstname");
    $ticket_code = filter_input(INPUT_POST, "public-ticket-code")
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générer le lien du Billet</title>
</head>
<body>
    <div>
        <p><?= $last_name ?></p>
        <p><?= $first_name ?></p>
            
    </div>
</body>
</html>
<?php endif;
