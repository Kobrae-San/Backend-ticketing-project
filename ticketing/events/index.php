<?php
    require '../../inc/pdo.php';
    $requete = $ticket_pdo->prepare("
    SELECT event_place, event_date from events WHERE events.id = :value;
    ");
    $requete->execute([
    ":value" => $value
    ]); 
    $place_value = $requete->fetchAll(PDO::FETCH_ASSOC);

    $place = $place_value["event_place"];
    $date = $place_value["event_date"];
    $json_data= json_encode($place_value);
    echo $json_data;