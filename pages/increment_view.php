<?php
require_once '../dbconnect.php'; // Chemin vers votre fichier de connexion PDO

header('Content-Type: application/json'); // Définir l'en-tête pour JSON

// Récupérer l'ID de l'animal
$idAnimal = isset($_GET['id_animal']) ? (int) $_GET['id_animal'] : 0;

if ($idAnimal > 0) {
    try {
        // Incrémenter le compteur
        $stmt = $pdo->prepare("UPDATE animal SET view_animal = view_animal + 1 WHERE id_animal = :id");
        $stmt->execute(['id' => $idAnimal]);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID animal invalide.']);
}
?>