<?php
session_start();

if(empty($_SESSION['user'])){
    header('location:index.php');
}

?>

<h2>bienvenue sur votre espace membre</h2>

<p>bienvenue <?php echo $_SESSION['user'] ?> </p>

<a href="logement.php">Acceder a la liste des logements</a>

<br><br>

<a href="locataire.php">Acceder a la liste des locataires</a>

<br><br>

<a href="contrat.php">Acceder aux contrats</a>

<br><br>

<a href="deconnexion.php">se deconnecter</a>

<style>
*{text-align:center;}
.erreur{font-size:2rem;color:red;}
</style>