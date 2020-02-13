<?php
session_start();
include 'function.php';

//Si une session est deja ouverte
if(!empty($_SESSION['user'])):
    header('location:espace.php');
else:   
inscription();
endif;
?>


<h1>bienvenue sur l'interface de gestion locative</h1>

<h2>Inscrivez vous gratuitement, et gèrez vos location en toute simplicité</h2>

<form method="post">

    <label for="user">Nom</label>
    <input type="text" name="name" placeholder="votre nom"><br><br>

    <label for="firstName">Prenom</label>
    <input type="text" name="firstName" placeholder="votre prenom"><br><br>

    <label for="phone">numero telephone</label>
    <input type="tel" name="phone" placeholder="numero de tel"><br><br>

    <label for="email">Votre mail</label>
    <input type="mail" name="mail" placeholder="votre adresse mail"><br><br>

    <label for="email2">confirmez votre mail</label>
    <input type="mail" name="mail2" placeholder="confirmez mail"><br><br>

    <label for="agence">Nom de votre agence</label>
    <input type="mail" name="agence" placeholder="nom de l'agence"><br><br>

    <label for="user">Identifiant</label>
    <input type="text" name="user" placeholder="votre identifiant"><br><br>

    <label for="password">Mot de passe</label>
    <input type="password" name="password" placeholder="votre mot de passe"><br><br>

    <label for="password2">Confirmez MDP</label>
    <input type="password" name="password2" placeholder="confirmez votre MDP"><br><br>

    <input type="submit" name="inscription" value="Je m'inscris">

</form>

<p>vous avez déjà un compte ? <a href="index.php">connectez-vous</a></p>

<?php if(!empty($erreur)){echo"<p class='erreur'>".$erreur."</p>";}?>

<style>
*{text-align:center;}
.erreur{font-size:2rem;color:red;}
</style>