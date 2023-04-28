<?php
require '../../inc/pdo.php';
require '../../inc/functions.php';
session_start();

    $requete = $ticket_pdo->prepare("
    SELECT * FROM events 
    ");
    $requete->execute();
    $events = $requete->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD

 
    

  
 
?>

<!DOCTYPE html>

=======
?>
<!DOCTYPE html>
>>>>>>> c8ce8b6e31d2fca7963f19c4cd436744b576699c
<html>
<head>
    <meta charset="utf-8">
    <title>Visualiser les événements et leurs inscrits</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="liste_event">
    
        <?php 
        foreach($events as $event){
            echo "
            <a id='event_id'>ID:  <span>{$event['id']}</span></a><div class='event' data-tooltype=Description:{$event['event_description']}>
           
            <a id='event_name'>Nom:  <span>{$event['event_name']}</span></a>
            <a>lieu:  <span>{$event['event_place']}</span></a>
            </div>";
        }
        ?>

       <script>
       
       
        

     //afficher les visiteurs 
        const event = document.querySelectorAll('.event');

    </script>

</body>
</html>


