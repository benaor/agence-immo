<?php
session_start();
include 'function.php';

if(empty($_SESSION['user'])):
    header('location:index.php');

else:
suppressionLocataire();
endif;

?>

redirection en cours ...