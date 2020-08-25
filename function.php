<?php

function connectBDD(){
    //on se connecte a la base de données
    return new PDO('mysql:host=localhost;dbname=agence_immo','root','root');
}

function modificationLogement(){

    //on se connecte a la base de données
    $bdd = connectBDD();

    //On recupère les données correspondantes au logement à modifier
    $modifLogementBrut = $bdd->query("SELECT * FROM logement WHERE id =".$_GET['logement_id']." ");


    //On crée le form qui contiendra les inputs, qui eux, contiendront les valeurs à modifier
    echo "<form action='' method='post'>";

    while($modifLogement = $modifLogementBrut->fetch() ){

        //On ajoute les inputs qui contiennent les valeurs
        echo "

        <label for=''>type du logement</label>
        <input value='".$modifLogement['type']."' name='type_bien'>
        <br><br>

        <label for=''>loyer du logement</label>
        <input value='".$modifLogement['loyer']."' name='loyer'>
        <br><br>

        <label for=''>superficie du bien</label>
        <input value='".$modifLogement['superficie']."' name='superficie'>
        <br><br>

        <label for=''>quartier où il se situe</label>
        <input value='".$modifLogement['quartier']."' name='quartier'>
        <br><br>
        ";
    }

    echo "<input type='submit' value='modifier' name='modifier'>";
    echo "</form>";

    //lors de l'appui sur le bouton modifier
    if(isset($_POST['modifier'])){

        if(   !empty($_POST['type_bien'])  &&    !empty($_POST['loyer'])  &&    !empty($_POST['superficie'])   &&    !empty($_POST['quartier'])    ){

            //On modifie le nom dans la base de données
            $update = $bdd->query("UPDATE logement  SET type       ='".$_POST['type_bien']."',
                                                        loyer      ='".$_POST['loyer']."', 
                                                        superficie ='".$_POST['superficie']."',
                                                        quartier   ='".addslashes($_POST['quartier'])."'
                                                    WHERE id=".$_GET['logement_id']." ");
            header("location:logement.php");

        }

        else{
            $erreur = "un ou plusieurs champs sont vides !";
        }
    }
}

function suppressionLogement(){

    //on se connecte a la base de données
    $bdd = connectBDD();

    //On supprime la ligne qui correspond a l'id present dans l'URL 
    $delete = $bdd->query("DELETE FROM logement WHERE id=".$_GET['logement_id']." ");

    //on redirige sur logement.php
    header("Location:logement.php");

}

function inscription(){

        //on se connecte a la base de données
        $bdd = connectBDD();

        //si on clique sur le bouton "je m'inscris"
        if(   isset(   $_POST['inscription']   )   ){

            $nom         = htmlspecialchars($_POST['name']);
            $prenom      = htmlspecialchars($_POST['firstName']);
            $tel         = htmlspecialchars($_POST['phone']);
            $mail        = htmlspecialchars($_POST['mail']);
            $mail2       = htmlspecialchars($_POST['mail2']);
            $agence      = htmlspecialchars($_POST['agence']);
            $identifiant = htmlspecialchars($_POST['user']);
            $mdp         = sha1($_POST['password']);
            $mdp2        = sha1($_POST['password2']);


            //On verifie que tous les champs soient rempli 
            if(   !empty($_POST['name'])   &&    !empty($_POST['firstName'])   &&    !empty($_POST['phone'])   &&    !empty($_POST['mail'])   &&    !empty($_POST['mail2']) &&    !empty($_POST['agence']) &&    !empty($_POST['user']) &&    !empty($_POST['password']) &&    !empty($_POST['password2'])  ){

                //On verifie la longueur de l'identifiant 
                if(strlen($identifiant) <= 16){         

                    //on verifie que les mots de passe sont identiques
                    if($_POST['password'] == $_POST['password2'] ){
                
                        //On verifie la longueur du mdp
                        if(strlen($_POST['password']) <= 16){

                            //on verifie que les deux mails sont identiques
                            if($mail == $mail2){
                                
                                //On verifie la validité de l'adresse mail
                                if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

                                    //On verifie que l'identifiant ne soit pas deja utilisé
                                    $reqid = $bdd->prepare("SELECT * FROM membres WHERE identifiant = ?");
                                    $reqid->execute(array($identifiant));
                                    $idexist = $reqid->rowCount();

                                    if($idexist == 0){
                                        
                                        //on insert les données dans la table "user"
                                        $insertmbr = $bdd->prepare("INSERT INTO membres(nom, prenom, tel, email, agence, identifiant, mdp) VALUES(?,?,?,?,?,?,?)");
                                        $insertmbr->execute(array($nom, $prenom, $tel, $mail, $agence, $identifiant, $mdp));
                                    
                                        //On redirige automatiquement vers index.php
                                        $_SESSION['comptecree'] = "<p class='vert'> votre compte a bien été crée ! </p>";
                                        header('location: index.php');
                                        }

                                        else{
                                            //si l'email est deja utilisé 
                                            $erreur = "Cet email est déjà utilisé";
                                        }


                                }
                                else{
                                    //si l'email n'est pas valide
                                    $erreur = "l'adresse email n'est pas valide";
                                }

                            }

                            else{
                                //si les mails ne sont pas identiques
                                $erreur = "les deux mails sont differents";
                            }
                        }

                        else{
                            //Si l'identifiant est trop long
                            $erreur = "Le mdp est trop long";
                        }
                    }
                    else{
                        //si les mdps sont differents
                        $erreur = "les deux mdp ne correspondent pas";
                    }

                }
                else{
                    //Si l'identifiant est trop long
                    $erreur = "L'identifiant est trop long";
                }
            }
            else{
                //si tous les champs ne sont pas rempli
                $erreur = "Tous les champs doivent être rempli";
            }

        }

}

function addLogement(){
        //on se connecte a la base de données
        $bdd = connectBDD();

        if(    isset(   $_POST['add_logement']  )   ){
    
            $type         = htmlspecialchars($_POST['type']);
            $loyer        = htmlspecialchars($_POST['loyer']);
            $superficie   = htmlspecialchars($_POST['superficie']);
            $quartier     = htmlspecialchars($_POST['quartier']);
    
            //on verifie que tous les champs soient remplis
            if( !empty($_POST['type']) &&
                !empty($_POST['loyer']) &&
                !empty($_POST['superficie']) &&
                !empty($_POST['quartier']) ){
    
                    //On ajoute le logement dans la base de données
                    $insertlgt = $bdd->prepare("INSERT INTO logement(type, loyer, superficie, quartier) VALUES (?, ?, ?, ?)");
                    $insertlgt->execute(array($type, $loyer, $superficie, $quartier));
                    header('location:logement.php');
            }
    
            else{
                //Si tous les champs ne sont pas rempli
                $erreur = "Le logement n'as pas pu être ajouté : </br> vérifiez tous les champs doivent être remplis !";
            }
    
    
        }
}

function recapLogement(){
        
    //on se connecte a la base de données
    $bdd = connectBDD();

        //On recupère les données de la table location
        $listeLogementBrut = $bdd->query("SELECT * FROM logement");
        
        //On ouvre la liste a puces
        echo "<ul>";
        
            //On lance la boucle qui affichera tous les logements repertorié sur le site
            while($listeLogement = $listeLogementBrut->fetch()){
        
                //on affiche les données de chaque logement
                echo "<li>un ".$listeLogement['type']." d'une superficie de ".$listeLogement['superficie']."m² loué ".$listeLogement['loyer']."€ Hors Charges, dans le quartier ".$listeLogement['quartier'].
        
                //ajout du lien vers modification et suppression
                "\ \ \ \ \ \ <a href='modification_logement.php?logement_id=".$listeLogement['id']."'>modifier </a>
        
                \ \ \ \ \ \ <a href='suppression_logement.php?logement_id=".$listeLogement['id']."'>Supprimer </a> </li> ";
            }
        
            echo "</ul>";
}

function recapLocataire(){
            
    //on se connecte a la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=agence_immo','root','root');

    //On recupère les données de la table locataire
    $recapLocataireBrut = $bdd->query("SELECT * FROM locataire");

    while($recapLocataire = $recapLocataireBrut->fetch()){

        echo "<li>".$recapLocataire['nom']." ".$recapLocataire['prenom']." née le ".$recapLocataire['naissance'].". Tel : ".$recapLocataire['tel']."
        |||||||||||||||||||<a href='modification_locataire.php?locataire_id=".$recapLocataire['id']."'> modifier </a>
        |||||||||||||||||||<a href='suppression_locataire.php?locataire_id=".$recapLocataire['id']."'> supprimer </a>
        </li><br>";
    }
}

function addLocataire(){
    //on se connecte a la base de données
    $bdd = connectBDD();

    if(    isset(   $_POST['addLocataire']  )   ){

        $nomLoc         = htmlspecialchars($_POST['nom']);
        $prenomLoc      = htmlspecialchars($_POST['prenom']);
        $naissanceLoc   = htmlspecialchars($_POST['naissance']);
        $telLoc         = htmlspecialchars($_POST['tel']);

        //on verifie que tous les champs soient remplis
        if( !empty($_POST['nom']) &&
            !empty($_POST['prenom']) &&
            !empty($_POST['naissance']) &&
            !empty($_POST['tel']) ){

                //On ajoute le logement dans la base de données
                $insertlgt = $bdd->prepare("INSERT INTO locataire(nom, prenom, naissance, tel) VALUES (?, ?, ?, ?)");
                $insertlgt->execute(array($nomLoc, $prenomLoc, $naissanceLoc, $telLoc));
                header('location:locataire.php');
        }

        else{
            //Si tous les champs ne sont pas rempli
            $erreur = "Le logement n'as pas pu être ajouté : </br> vérifiez tous les champs doivent être remplis !";
        }


    }
}

function modificationLocataire(){

    //on se connecte a la base de données
    $bdd = connectBDD();

    //On recupère les données correspondantes au logement à modifier
    $modifLocataireBrut = $bdd->query("SELECT * FROM locataire WHERE id =".$_GET['locataire_id']." ");


    //On crée le form qui contiendra les inputs, qui eux, contiendront les valeurs à modifier
    echo "<form action='' method='post'>";

    while($modifLocataire = $modifLocataireBrut->fetch() ){

        //On ajoute les inputs qui contiennent les valeurs
        echo "

        <label for=''>type du logement</label>
        <input type='text' value='".$modifLocataire['nom']."' name='nomLocataire'>
        <br><br>

        <label for=''>loyer du logement</label>
        <input type='text' value='".$modifLocataire['prenom']."' name='prenomLocataire'>
        <br><br>

        <label for=''>superficie du bien</label>
        <input type='date' value='".$modifLocataire['naissance']."' name='naissanceLocataire'>
        <br><br>

        <label for=''>quartier où il se situe</label>
        <input type='tel' value='".$modifLocataire['tel']."' name='telLocataire'>
        <br><br>
        ";
    }

    echo "<input type='submit' value='modifier' name='modifier'>";
    echo "</form>";

    //lors de l'appui sur le bouton modifier
    if(isset($_POST['modifier'])){

        if(   !empty($_POST['nomLocataire'])  &&    !empty($_POST['prenomLocataire'])  &&    !empty($_POST['naissanceLocataire'])   &&    !empty($_POST['telLocataire'])    ){

            //On modifie le nom dans la base de données
            $update = $bdd->query("UPDATE locataire  SET nom       ='".$_POST['nomLocataire']."',
                                                         prenom    ='".$_POST['prenomLocataire']."', 
                                                         naissance ='".$_POST['naissanceLocataire']."',
                                                         tel       ='".addslashes($_POST['telLocataire'])."'
                                                    WHERE id=".$_GET['locataire_id']." ");
            header("location:locataire.php");

        }

        else{
            $erreur = "un ou plusieurs champs sont vides !";
        }
    }
}

function suppressionLocataire(){

    //on se connecte a la base de données
    $bdd = connectBDD();

    //On supprime la ligne qui correspond a l'id present dans l'URL 
    $delete = $bdd->query("DELETE FROM locataire WHERE id=".$_GET['locataire_id']." ");

    //on redirige sur logement.php
    header("Location:locataire.php");

}

function selectLocataire(){

         //on se connecte a la base de données
         $bdd = connectBDD();

         //On recupère les données de locataire
         $selectLocataireBrut = $bdd->query("SELECT * FROM locataire");
    
         //On crée un select par personne
         while($selectLocataire = $selectLocataireBrut->fetch()){
            
            echo "<option value='".$selectLocataire['id']."'>".$selectLocataire['nom']." ".$selectLocataire['prenom']."</option>";
         }
}

function selectLogement(){

    //on se connecte a la base de données
    $bdd = connectBDD();

    //On recupère les données de locataire
    $selectLogementBrut = $bdd->query("SELECT * FROM logement");

    //On crée un select par personne
    while($selectLogement = $selectLogementBrut->fetch()){
       
       echo "<option value='".$selectLogement['id']."'>".$selectLogement['id']."  qui est situé dans le quartier ".$selectLogement['quartier']."</option>";
    }
}

function ajoutContrat(){

    //on se connecte a la base de données
    $bdd = connectBDD();

    //On recupère les données de contrat
    $donneesContratBrut = $bdd->query("SELECT * FROM logement
                                                INNER JOIN locataire
                                                ON logement.id_locataire = location.id ");

    
        if(!empty($_GET['locataire']) && !empty($_GET['logement'])){
            $sqlAdd = "INSERT INTO contrat (id_locataire, id_logement) VALUES('".$_GET['locataire']."', '".$_GET['logement']."') ";
            $test= $bdd->query($sqlAdd);
            header('location:contrat.php');
        }  

}

function recapContrat(){

    //on se connecte a la base de données
    $bdd = connectBDD();

    //On recupère les données de contrat
    $donneesContratBrut = $bdd->query("SELECT * FROM contrat
                                       INNER JOIN locataire
                                       ON id_locataire = locataire.id
                                       JOIN logement
                                       ON id_logement = logement.id
                                    ");

    //On ouvre la liste a puces
    echo "<ul>";
    
        //On lance la boucle qui affichera tous les logements repertorié sur le site
        while($donneesContrat = $donneesContratBrut->fetch()){
    
            //on affiche les données de chaque logement
            echo "<li>le locataire  ".$donneesContrat['nom']." loue actuellement un ".$donneesContrat['type']." pour ".$donneesContrat['loyer']."€ Hors Charges, dans le quartier ".$donneesContrat['quartier'] ;
    
        }
    
        echo "</ul>";
}

?>
