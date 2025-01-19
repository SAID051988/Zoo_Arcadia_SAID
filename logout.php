<?php
session_start(); // Démarrer la session
session_unset(); // Libérer toutes les variables de session
session_destroy(); // Détruire la session

// Rediriger vers la page d'accueil
header('Location: index.php');
exit();
?>
