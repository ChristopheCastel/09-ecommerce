<?php 
    require_once('../inc/init.inc.php');

    // Contrôle PHP formulaire
    echo '<pre style="margin-left: 250px">'; print_r($_POST); echo '</pre>';
    echo '<pre style="margin-left: 250px">'; print_r($_FILES); echo '</pre>';

    if(isset($_POST['reference'],$_POST['categorie'],$_POST['titre'],$_POST['description'],$_POST['couleur'],$_POST['taille'],$_POST['public'],$_POST['prix'],$_POST['stock']))
    {
        // TRAITEMENT / ENREGISTREMENT DE LA PHOTO PRODUIT
        if(!empty($_FILES['photo']['name']))
        {
            // On renomme l'image avant de l'enregistrer, on concatène la référence saisie dans le formulaire avec le nom de l'image récupéré dans $_FILES
            $nomPhoto = $_POST['reference'] . '-' . $_FILES['photo']['name'];
            echo "<p style='margin-left: 250px'>$nomPhoto</p><hr>"; // 1589-tee-shirt1.jpg

            // URL DE L IMAGE (enregistré en bdd)
            // ex: http://localhost/php/PHP/09-ecommerce/assets/uploads/1589-tee-shirt1.jpg
            $photoBdd = URL . "assets/uploads/$nomPhoto";
            echo "<p style='margin-left: 250px'>$photoBdd</p><hr>";
            
            // CHEMIN PHYSIQUE DE L'IMAGE SUR LE SERVEUR
            // CHEMIN PHYSIQUE DE L'IMAGE SUR LE SERVEUR
            // ex: C:/xampp/htdocs/PHP-wf3-1098/09-commerce/asset/uploads/15A89-tee-shirt1.jpg
            $photoDossier = RACINE_SITE . "/assets/uploads/$nomPhoto";
            echo "<p style='margin-left: 250px'>$photoDossier</p><hr>";
            // Cette constante RACINE_SITE retourne le chemin physique du dossier 09-ecommerce sur le serveur... VOIR DANS LE FICHIER init.inc.php 
            // contexte : lors de l'enregistrement d'image produit sur le serveur, nous aurons besoin de définir le chemin complet dans lequel doit être enregistrée la photo sur le serveur

            // COPIE DE L'IMAGE DANS LE DOSSIER UPLOADS
            // copy() : fonction prédéfinie permettant de copier un fichier uploadé dans un dossier sur le serveur
            // arguments : 
            // 1. Le fichier temporaire de l'image disponible dans $_FILES
            // 2. Le chemin physique de l'image où elle doit être enregistrée sur le serveur



            copy($_FILES['photo']['tmp_name'], $photoDossier);

            /*Array
            (
                [photo] => Array
                    (
                        [name] => tee-shirt1.jpg
                        [type] => image/jpeg
                        [tmp_name] => C:\xampp\tmp\php3ACB.tmp
                        [error] => 0
                        [size] => 31929
                    )

            )*/
        }

        // ENREGISTREMENT PRODUIT
        // Exo : réaliser le traitement PHP + SQL permettant d'insérer un produit à la validation du formulaire (prepare + bindValue + execute)

        $ajoutProduit = $bdd->prepare("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)");

        $ajoutProduit->bindValue(':reference', $_POST['reference'], PDO::PARAM_STR );
        $ajoutProduit->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR );$ajoutProduit->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR );
        $ajoutProduit->bindValue(':description', $_POST['description'], PDO::PARAM_STR );$ajoutProduit->bindValue(':couleur', $_POST['couleur'], PDO::PARAM_STR );$ajoutProduit->bindValue(':taille', $_POST['taille'], PDO::PARAM_STR );
        $ajoutProduit->bindValue(':public', $_POST['public'], PDO::PARAM_STR );
        $ajoutProduit->bindValue(':photo', $photoBdd, PDO::PARAM_STR );
        $ajoutProduit->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT );
        $ajoutProduit->bindValue(':stock', $_POST['stock'], PDO::PARAM_INT );
       
        $ajoutProduit->execute();

        $validInsert = "<p class='col-7 bg-success text-white text-center mx-auto p-3 my-3'>Le produit référence <strong>$_POST[reference]</strong> a été enregistré avec succès.</p>"; 

    
    }


    require_once('../inc/inc_back/header.inc.php');
    require_once('../inc/inc_back/nav.inc.php');
?>

<!-- 
Exo : afficher sous forme de tableau de HTML l'ensemble des produits stockés en BDD
1. requete de selection (query)
2. Afficher le nombre de produit selectionnés en BDD (rowCount())
3. Récupérer les informations sous forme de tableau (fetchAll)
4. Déclarer le tableau HTML (<table>)
5. Afficher les entêtes du tableau (<th>) en passant par le résultat du fetchAll()
6. Afficher tout les produits de la BDD à l'aide de boucle (foreach) dans des lignes (<tr>) et cellules (<td>) du tableau 
7. Prévoir un lien de modification / suppression pour chaque produit dans le tableau HTML
-->

    <?php
        $produit = $bdd->query("SELECT * FROM produit");

        echo "Nombre de produits : <span class='badge bg-success'>" . $produit->rowCount() . "</span><hr>";

        
        

        $allProduct = $produit->fetchall(PDO::FETCH_ASSOC);
           
                echo '<pre>'; print_r($allProduct); echo '</pre>';

                foreach ($allProduct as $key => $value) 
                {
                    echo "$key : $value<br>";
                }
               
                // On transmet à la boucle FOREACH chaque Array retourné par fetch() afin de parcourir chaque données de chaque employé
                // La boucle crée une div pour chaque tour de boucle contenant les données d'1 employé

                echo '</div>';


                $pdoStatement = $pdo->query("SHOW DATABASES");

                $tab_Multi = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

                echo '<pre>'; print_r($tab_Multi); echo '</pre>';

                echo'<ul class="list-group">';
                    foreach($tab_Multi as $tab)
                    {
                        foreach($tab as $value)
                        {
                            echo"<li class='list-group-item'>$value</li>";
                        }
                }
                echo '</ul>';


            

            }



    ?>

<h1 class="text-center my-5">Ajout produit</h1>

<?php if(isset($validInsert)) echo $validInsert; ?>

<!-- enctype="multipart/form-data" : permet de récupérer les données d'un fichier uploadé (nom, extension, taille etc...) accessible en PHP via la superglobale $_FILES -->

<form method="post" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
        <label for="reference" class="form-label">Référence</label>
        <input type="text" class="form-control" id="reference" name="reference">
    </div>
    <div class="col-md-6">
        <label for="categorie" class="form-label">Catégorie</label>
        <input type="text" class="form-control" id="categorie" name="categorie">
    </div>
    <div class="col-12">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre">
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description">
    </div>
    <div class="col-4">
        <label for="couleur" class="form-label">Couleur</label>
        <input type="color" class="form-control input-couleur" id="couleur" name="couleur">
    </div>
    <div class="col-4">
        <label for="taille" class="form-label">Taille</label>
        <select id="taille" name="taille" class="form-select">
            <option value="s">S</option>
            <option value="m">M</option>
            <option value="l">L</option>
            <option value="XL">XL</option>
        </select>
    </div>
    <div class="col-4">
        <label for="public" class="form-label">Public</label>
        <select id="public" name="public" class="form-select">
            <option value="homme">Homme</option>
            <option value="femme">Femme</option>
            <option value="mixte">Mixte</option>
        </select>       
    </div>
    <div class="col-4">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" id="photo" name="photo">
    </div>
    <div class="col-4">
        <label for="prix" class="form-label">Prix</label>
        <input type="text" class="form-control" id="prix" name="prix">
    </div>
    <div class="col-4">
        <label for="stock" class="form-label">Stock</label>
        <input type="text" class="form-control" id="stock" name="stock">
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-dark mb-5">Ajout produit</button>
    </div>
</form>


    
            
<?php
     require_once('../inc/inc_back/footer.inc.php');
?>