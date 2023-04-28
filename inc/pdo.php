<?php
    // Ces six informations sont nécessaires pour vous connecter à une BDD :
    // Type de moteur de BDD : mysql
    $auth_engine = "mysql";
    // Hôte : localhost
    $host = "localhost";
    // Port : 3306 (par défaut pour MySQL, avec MAMP macOS c'est 8889)
    $auth_port = 3306; // port XAMP
    $mamp_auth_port = 8888; // port MAMP
    // Nom de la BDD (facultatif) : sakila
    $auth_bdd = "authentification";
    $ticket_bdd = "billeterie";
    // Nom d'utilisateur : root
    $user = "root";
    // Mot de passe : 
    $password_bdd = "RAYMONDShaynna2001";

    $auth_dsn = "$auth_engine:host=$host:$auth_port;dbname=$auth_bdd";
    $auth_pdo = new PDO($auth_dsn, $user, $password_bdd);

    $ticket_dsn = "$auth_engine:host=$host:$auth_port;dbname=$ticket_bdd";
    $ticket_pdo = new PDO($ticket_dsn, $user, $password_bdd);
