<?php

    // CONNEXION BDD
        $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]);

    // SESSION
        session_start();

    // CHEMIN / CONSTANTE
        define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . '/php/PHP/09-ecommerce');

            // $_SERVER['DOCUMENT_ROOT'] --> C://xampp/htdocs
            // RACINE_SITE --> C:/xampp/htdocs/PHP/09-ecommerce
            // echo RACINE_SITE . '<hr>';

            // Cette constante RACINE_SITE retourne le chemin physique du dossier 09-ecommerce sur le serveur
            // contexte : lors de l'enregistrement d'image produit sur le serveur, nous aurons besoin de définir le chemin complet dans lequel doit être enregistrée la photo sur le serveur

        define("URL", "http://localhost/php/PHP/09-ecommerce/");

            // Cette constante URL définie l'adresse http de notre site ecommerce sur le serveur
            // Cette constante servira, entre autre, à enregister et à définir l'URL d'une image produit qui sera stockée en BDD
            // ex : http://localhost/PHP/09-ecommerce/asset/img/tee-shirt1.jpg

    // FAILLES XSS
        // On passe en revue les données d'un formulaire et on exécute la fonction htmlentities() sur chaque valeur saisie dans le formulaire
        foreach ($_POST as $key => $value) 
        {
            $_POST[$key] = htmlentities($value);
        }    
            
        // On passe en revue les données transmises dans l'URL et on exécute la fonction htmlentities() sur chaque données dans l'URL
        foreach ($_GET as $key => $value) 
        {
            $_GET[$key] = htmlentities($value);
        }    

    // INCLUSIONS
    // On inclut le fichier fonctions.inc.php dans init, comme ça à chaque inclusion de init.inc.phpsur chaque page, nous faisons dans le même temps appel aux fonctions déclarées
    require_once('fonctions.inc.php');