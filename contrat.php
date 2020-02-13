<h2>consulter nos contrats en cours</h2>

<?php
session_start();
include "function.php";

if(empty($_SESSION['user'])):
    header('location:index.php');
else: 
    recapContrat();
    ajoutContrat();
endif;
?>

<h2>ajouter un contrat de location</h2>

<form action="" method="get">

<p>

<select name="locataire" id="locataire">
<?php selectLocataire(); ?>
</select>

veut louer l'appartement numero 

<select name="logement" id="logement">
<?php selectLogement(); ?>
</select>

<input type="submit" name="addContrat" value="ajouter un contrat">

</p>
</form>
