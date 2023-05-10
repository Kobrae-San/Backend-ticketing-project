<?php

    $auth_engine = "mysql";

    $host = "localhost";

    $auth_port = 3306;

    $auth_bdd = "authentification";

    $ticket_bdd = "billeterie";

    $user = "root";
    
    $password_bdd = "";

    $auth_dsn = "$auth_engine:host=$host:$auth_port;dbname=$auth_bdd";
    $auth_pdo = new PDO($auth_dsn, $user, $password_bdd);

    $ticket_dsn = "$auth_engine:host=$host:$auth_port;dbname=$ticket_bdd";
    $ticket_pdo = new PDO($ticket_dsn, $user, $password_bdd);
