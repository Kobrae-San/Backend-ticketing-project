<?php
require '../../inc/pdo.php';
require '../../inc/functions.php';
session_start();

    $requete = $auth_pdo->prepare("
    SELECT * FROM events 
    ");
    $requete->execute();
    $events = $requete->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD

=======

   
    

  
 
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Visualiser les événements et leurs inscrits</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="liste_event">
    
        <?php 
        foreach($events as $event){
            echo "<div class='event' data-tooltype=Description:{$event['event_description']}>
            
            <h2 id='event_name'>Nom:  <span>{$event['event_name']}</span></h2>
            <h2>lieu:  <span>{$event['event_place']}</span></h2>
            </div>";
        }
        ?>

       <script>
        const events = document.querySelectorAll('.event');
        events.forEach(event => {
            event.addEventListener('click', () => {
                event.classList.add('active');
            })
        })
        

       </script>
</body>
</html>


