<?php
//Démarrer la session si elle n'est pas démarrée
if(session_status()===PHP_SESSION_NONE){
    session_start(); 
 }
 require_once '../dbconnect.php';
 require_once '../config.php';
if (isset($_POST['id']) && isset($_POST['value'])) {
    $id = $_POST['id'];
    $value = $_POST['value'];

    // Effectuez la mise à jour dans la base de données en fonction de $id et $value
    $stmt = $pdo->prepare("UPDATE avis SET valider_avis = :value WHERE id_avis = :id_avis");
    $stmt->execute([':value' => $value, ':id_avis' => $id]);

    // Réponse de succès
    echo "Mise à jour réussie!";
} else {
    // Réponse d'erreur si les paramètres ne sont pas définis
    http_response_code(400);
    echo "Paramètres manquants.";
}


