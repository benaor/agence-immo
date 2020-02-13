<h2>Modifier les valeurs d'un logement</h2>

<?php
session_start();
include 'function.php';

if(empty($_SESSION['user'])):
    header('location:index.php');

else:
modificationLogement();
endif;

?>


<?php if(!empty($erreur)){echo"<p class='erreur'>".$erreur."</p>";}?>


<style>
*{text-align:center;}
.erreur{font-size:2rem;color:red;}
</style>