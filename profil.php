<?php
    require_once('inc/init.inc.php');

    echo '<pre>' ; print_r($_SESSION); echo '</pre>';

    // Si l'indice 'user' n'est défini dans la session (connect()), cela veut dire que l'internaute est authentifié sur le site, il n'a rien à faire sur la page profil, on le redirige (header()) vers la page connexion.php 
    if(!connect())
    {
        header('location: connexion.php');
    }



    require_once('inc/inc_front/header.inc.php');
    require_once('inc/inc_front/nav.inc.php');
?>


    <h1 class="text-center my-5">Vos informations personnelles</h1>

    <!-- Exo: afficher l'ensemble des données de l'utilisateur sur la page web en passant par le fichier session de l'utilisateur ($_SESSION). Ne pas afficher l'id_membre sur la page web -->


    <div class="col-5 mx-auto card mb-5 shadow-sm">
        <div class="card-body">
            <?php 
                foreach ($_SESSION['user'] as $key => $value) : //{

                    if($key != 'id_membre' && $key != 'statut') :
            ?>

                <p class="d-flex justify-content-between">
                    <!-- ucfirst() : fonction prédéfinie permettant de mettre la première de la chaîne de caractères en majuscule -->
                    <strong><?php echo ucfirst ($key); ?></strong>  
                    <span><?= $value; ?></span>
                </p>
            <?php
                endif;
            endforeach; // }
            ?>
        </div>
    </div>       
               









    <!-- MA REPONSE ########################################################## -->

    <!-- <?php
        
        echo "<div class='card mx-auto mb-5' style='width: 18rem;'>";
               echo "<ul class='list-group list-group-flush'>";
                    foreach ($_SESSION['user'] as $key => $value) 
                    {
                        if($key != 'id_membre' && $key != 'statut')
                        {
                            echo "<li class='list-group-item d-flex justify-content-between'>$key : <strong>$value</strong></li>";
                        }
                    } 
                echo "</ul>";
            echo "</div>";   

    ?> -->











<?php
    require_once('inc/inc_front/footer.inc.php');
?>
