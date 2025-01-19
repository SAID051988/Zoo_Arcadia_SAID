<?php
// Démarrer la session si elle n'est pas démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

// Inclure les fichiers de configuration et de connexion
require_once '../dbconnect.php';
require_once '../config.php';

// Vérifier si les paramètres POST sont définis
if (isset($_POST['id']) && isset($_POST['value'])) {
    $id = (int) $_POST['id'];
    $value = (int) $_POST['value'];

    try {
        // Préparer la requête pour mettre à jour la base de données
        $stmt = $pdo->prepare("UPDATE avis SET valider_avis = :value WHERE id_avis = :id_avis");
        $stmt->execute([
            ':value' => $value,
            ':id_avis' => $id
        ]);

        // Répondre avec un message de succès
        echo json_encode(['status' => 'success', 'message' => 'Mise à jour réussie!']);
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour.', 'details' => $e->getMessage()]);
    }
} else {
    // Retourner une erreur si les paramètres sont manquants
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Paramètres manquants.']);
}
