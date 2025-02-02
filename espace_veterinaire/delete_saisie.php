<?php
// Connexion à la base de données
require 'db_connection.php';

// Vérifier si l'ID de la saisie est reçu
if (isset($_POST['id_saisie'])) {
    $id_saisie = $_POST['id_saisie'];

    // Préparer la requête SQL pour supprimer la saisie
    $stmt = $pdo->prepare('DELETE FROM saisies WHERE id_saisie = :id_saisie');
    $stmt->bindParam(':id_saisie', $id_saisie, PDO::PARAM_INT);

    // Exécuter la requête et vérifier le résultat
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}