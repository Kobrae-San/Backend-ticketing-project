<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Créer-Modifier-Annuler un événement</h1>

    <form method="POST">
        <label for="event-name">Nom de l'événement: </label>
        <input type="text" id="event-name" name="event-name">

        <br>

        <label for="event-place">Lieux de l'évènement: </label>
        <input type="text" id="event-place" name="event-place">

        <br>

        <label for="event-date">Date de l'évènement: </label>
        <input type="date" id="event-date" name="event-date">

        <br>

        <label for="event-description">Description de l'évènement: </label>
        <textarea name="event-description" id="event-description" cols="30" rows="5"></textarea>

    </form>
</body>
</html>