<?php
session_start();
//Si une session est deja ouverte
if(!empty($_SESSION['user'])):
    header('location:espace.php');
else:

    //on se connecte a la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=agence_immo','root','root');

    //lorsqu'on clique sur submit
    if(   isset(   $_POST['connexion'])   ){

        //On recupère dans une variable l'identifiant et le mdp, et on securise (eviter l'injection SQL + chiffrage du mdp)
        $user = htmlspecialchars($_POST['user']);
        $password    = sha1($_POST['password']);

        //On verifie que les champs soient rempli
        if(  !empty($_POST['user'])   &&   !empty($_POST['password'])  ){

            // On compare l'identifiant et le mdp saisi avec ceux de la base de données
            $reqidentification = $bdd->query("SELECT * FROM membres WHERE identifiant = '$user' AND mdp = '$password'");
            $tableau = $reqidentification->fetch(PDO::FETCH_ASSOC);

            if(is_array($tableau)){
                $_SESSION['user']=$tableau['identifiant'];
                echo "redirection vers votre espace membre";
                header('location:espace.php');
            }

            else{
                $erreur = "identifiant incorrect";
            }

        }

        else{
            //si les champs ne sont pas tous rempli
            $erreur = "tous les champs doivent être rempli";
        }
    }
endif;
?>




<h1>bienvenue sur l'interface de gestion locative</h1>

<h2>Connectez vous pour acceder a l'espace</h2>

<form method="post">

    <label for="user">Identifiant</label>
    <input type="text" name="user" placeholder="votre identifiant"><br><br>

    <label for="password">Mot de passe</label>
    <input type="password" name="password" placeholder="votre mot de passe"><br><br>

    <input type="submit" value="Je me connecte" name="connexion">
    <?php if(!empty($erreur)){echo"<p class='erreur'>".$erreur."</p>";}?>

</form>

<p>vous n'avez pas de compte ? <a href="inscription.php">inscrivez-vous</a> </p>


<style>
*{text-align:center;}
.erreur{font-size:2rem;color:red;}
</style>