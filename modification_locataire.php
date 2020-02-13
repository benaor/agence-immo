<h2>modifier les infos d'un locataire</h2>


<?php
session_start();
include "function.php";

if(empty($_SESSION['user'])):
    header('location:index.php');
else:
modificationLocataire();
endif;
?>


<?php if(!empty($erreur)){echo"<p class='erreur'>".$erreur."</p>";}?>


<style>
*{text-align:center;}
.erreur{font-size:2rem;color:red;}
</style>