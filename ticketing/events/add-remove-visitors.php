
<?php 

session_start();
require '../../inc/pdo.php';
require '../../inc/functions.php';
$title = "Ajoutez/Supprimez des visiteurs";
$website_part = "Billeterie";
$show_tickets_path = "../tickets/show-tickets.php";
$submit_path = "../tickets/submit-ticket.php";
$login_path = "../../authentification/login.php";
$logout_path = "../../authentification/logout.php";
$creation_path = "./create-modify-delete-events.php";
$visitor_path = "add-remove-visitors.php";
$show_visitor_path = "../events/show-event&visitors.php";
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
    header('Location: ../dashboard.php');
    exit();
}

$add = $_GET['add'];

$nom = filter_input(INPUT_POST, 'last_name');
$prenom = filter_input(INPUT_POST, 'first_name');
$event_name = filter_input(INPUT_POST,'event_name');
$event_place = filter_input(INPUT_POST,'event_place');
$event_date = filter_input(INPUT_POST,'event_date');

$requete = $ticket_pdo->prepare("SELECT id FROM events WHERE event_name = :name AND event_place = :place AND event_date = :date");
$requete->execute([":name" => $event_name, ":place" => $event_place, ":date" => $event_date]);
$check_event = $requete->fetch(PDO::FETCH_ASSOC);

if (!$check_event && $method == 'POST') {
    echo "L'événement que vous souhaitez rentrer n'existe pas !";
} elseif ($check_event && $method == 'POST') {
    $check_event = $check_event["id"];
    $requete = $ticket_pdo->prepare("SELECT * FROM visitors WHERE event_id = :id AND last_name = :last_name AND first_name = :first_name");
    $requete->execute([":id" => $check_event, ":last_name" => $nom, ":first_name" => $prenom]);
    $check_visitor = $requete->fetch(PDO::FETCH_ASSOC);
    
    if ($method == 'POST' && $add == 'true') {
        if ($check_visitor) {
            echo "L'utilisateur est déjà inscrit à cette évènement";
        } else {
            $requete = $ticket_pdo->prepare("INSERT INTO visitors (last_name,first_name,event_id) VALUES (:last_name,:first_name,:id)");
            $requete->execute([":last_name" => $nom, ":first_name" => $prenom, ":id" => $check_event]);
            echo "Inscription réussite";
        }
    } else {
        if ($check_visitor) {
            $requete = $ticket_pdo->prepare("DELETE FROM visitors WHERE event_id = :id AND last_name = :last_name AND first_name = :first_name");
            $requete->execute([":last_name" => $nom, ":first_name" => $prenom, ":id" => $check_event]);
            echo "Visiteur supprimé";
        } else {
            echo "L'utilisateur n'est pas inscrit à cette évenement";
        }
    }
}




?>
    <?php include '../../inc/tpl/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../style.css">
        <style>
        body{
    --lightgreen: #91C788;
    --darkgreen: #52734D;
    --lightyellow: #FCF8E8;
    --darkyellow: #F2E8CF;
    --verylightgrenn:#DDFFBC;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: flex-start;
    
   
    height: 100vh;
    background: var(--lightyellow);
    font-family: 'Poppins', sans-serif;
    }
    a{
    background: var(--verylightgrenn);
    border: 1px solid black;
    width: 60%;  
    
    display: flex;
    color: black;
    padding: 15px 32px;
    text-align: center;
   justify-content: center;

    text-decoration: none;
 
    font-size: 16px;
    margin: 4px 2px;
    transition: 0.2s;
    cursor: pointer;
}
a:hover{
    background-color: var(--darkgreen);
    color: white;
    transform: scale(0.988);
}
 
    


            input:user-valid{
    border-bottom: solid 1px var(--lightgreen);
   
  }
 input{
    display: flex;
    font-size: 16px;
    text-align: center;
    font-weight: 400;
    font-style: normal;
    color: black;
    flex-direction: column;
    align-items: center;
    letter-spacing: 0.1em;
    justify-content: center;
    border: solid 1px var(--lightgreen);
    height: 30px;
    outline: none;
    border-radius: 0px;
    width: 200px;
    transition: all 0.3s;
    background-color: white;
  }
    input:focus{
        border-bottom: solid 5px var(--lightgreen);
     
    }
  input:user-valid:focus{
    border-bottom: solid 5px var(--lightgreen);
   
  }
 input:user-invalid:focus{
    border-bottom: solid 5px var(--darkgreen);
   
  }
  .envoyer{
  padding: 10px;
  height: auto;
  width: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  background: var(--darkgreen);
  color: aliceblue;
  font-size: 16px;
  border:solid 1px var(--blue);
  transition: all 0.3s;
  border-radius: 10px;
}
form{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 10px;
}

  
        </style>
    </head>
    <body>
       
        <form method = "POST">
          <h2>Système <?php echo ($add == 'true') ? "d'ajout" : "de suppression";?> de visiteurs à un événement</h2>

            <label>Nom: </label>
            <input type="text" placeholder="nom" name="last_name">
            <br>
            <label>Prénom: </label>
            <input type="text" placeholder="prenom" name="first_name">
            <label>Nom évènement: </label>
            <br>
            <input type="text" placeholder="Nom de l'évènement" name="event_name">
            <label>Lieu de l'évènement:</label>
            <br>
            <input type="text" placeholder="Lieu de l'évènement" name="event_place">
            <label>Date de l'évènement</label>
            <br>
            <input type="date" name="event_date">
            <input class="envoyer" type="submit">
            <a class="i"  href="add-remove-visitors.php?your_token=<?= $_GET['your_token']?>&username=<?= $_GET['username']?>&add=<?= ($add == 'true') ? "false" : "true" ?>">Vous souhaitez <?= ($add == 'true') ? "supprimer" : "ajouter";?> un visiteur ?</a>
    </body>
        </form>
       
</html>