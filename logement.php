<h2>Tous nos logements référencés</h2>

<?php
session_start();

if(!empty($_SESSION['user'])):
    include 'function.php';

    addLogement();
    recapLogement();
else:
header('location:index.php');
endif;
?>

<h2>Ajouter un logement</h2>

<form action="" method="post">

<label for="type">type de logement :</label>
<input type="text" name="type"> <br><br>

<label for="loyer">prix du loyer H.C</label>
<input type="number" name="loyer"><br><br>

<label for="superficie">Superficie loi Carrez</label>
<input type="number" name="superficie"><br><br>

<label for="quartier">Quartier où il se situe</label>
<input type="text" name="quartier"><br><br>

<input type="submit" value="ajouter un nouveau logement" name="add_logement">

</form>

<?php if(!empty($erreur)){echo"<p class='erreur'>".$erreur."</p>";}?>

<style>
*{text-align:center;}
.erreur{font-size:2rem;color:red;}
</style>