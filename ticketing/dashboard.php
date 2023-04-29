<?php
require '../inc/functions.php';
require '../inc/pdo.php';
session_start();

$title = "Acceuil";
$website_part = "Billetterie";

$style_ticketing_path = "./styles/ticketing.css";
$show_ticket_path = "./tickets/show-ticket.php";
$submit_ticket_path = "./tickets/submit-ticket.php";
$login_path = "./connection/login.php";
$logout_path = "./connection/logout.php";
$event_management_path = "./events/create-modify-delete-events.php";
$visitor_management_path = "./events/add-remove-visitors.php";
$events_path = "./events/show-event-visitors.php"; 

if (isset($_GET["your_token"])){
    $hashed = $_GET["your_token"];
}
?>

<?php include '../inc/tpl/header_ticketing.php'; ?>

  </body>
</html>