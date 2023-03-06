<?php
 // supprimer la session
 session_destroy();
 // redirection vers le controleur principal !!!!! pas de HTML avant !!!!!
 header('Location: index.php');
?>
