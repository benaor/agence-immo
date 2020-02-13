<h2>Liste des locataires</h2>

<?php
session_start();

if(!empty($_SESSION['user'])):
    include 'function.php';
    recapLocataire();
    addLocataire();

else:
    header('location:index.php');
endif;
?>

<h2>ajouter un locataire</h2>

<form action="" method="post">

    <label for="nom">nom</label>
    <input type="text" name="nom">
    <br><br>

    <label for="">prenom</label>
    <input type="text" name="prenom">
    <br><br>

    <label for="">date naissance</label>
    <input type="date" name="naissance">
    <br><br>

    <label for="">telephone</label>
    <input type="tel" name="tel">
    <br><br>

    <input type="submit" value="Ajouter un locataire" name="addLocataire">

</form>
<?php if(!empty($erreur)){echo"<p class='erreur'>".$erreur."</p>";}?>


<style>
*{text-align:center;}
.erreur{font-size:2rem;color:red;}
</style>