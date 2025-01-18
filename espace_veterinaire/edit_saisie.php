<?php
require_once '../dbconnect.php'; // Assurez-vous que le chemin est correct
header('Content-Type: application/json'); // Définir l'en-tête pour JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Récupération des données du formulaire
    $idSaisie = $_POST['id_saisie'] ?? null;
    $idAnimal = $_POST['id_animal_mod'] ?? null;
    $idNourriture = $_POST['id_nourriture_mod'] ?? null;
    $etatAnimal = $_POST['etat_animal'] ?? null;
    $detailEtatAnimal = $_POST['detail_etat_animal'] ?? null;
    $actionNourriture = $_POST['action_nourriture_mod'] ?? null;
    $etatHabitat = $_POST['etat_habitat'] ?? null;
    $detailEtatHabitat = $_POST['detail_etat_habitat'] ?? null;
    $datePassage = $_POST['date_passage'] ?? null;

    // Vérification des champs obligatoires
    if (!$idSaisie || !$idAnimal || !$idNourriture || !$etatAnimal || !$actionNourriture || !$datePassage) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être renseignés.']);
        exit;
    }

    // Préparation de la requête de mise à jour
    $query = $pdo->prepare("
        UPDATE veterinaire_saisie 
        SET 
            id_animal = :id_animal, 
            id_nourriture = :id_nourriture, 
            etat_animal = :etat_animal, 
            detail_etat_animal = :detail_etat_animal, 
            action_nourriture = :action_nourriture, 
            etat_habitat = :etat_habitat, 
            detail_etat_habitat = :detail_etat_habitat, 
            date_passage = :date_passage 
        WHERE id_saisie = :id_saisie
    ");

    // Lier les paramètres
    $query->bindParam(':id_animal', $idAnimal, PDO::PARAM_INT);
    $query->bindParam(':id_nourriture', $idNourriture, PDO::PARAM_INT);
    $query->bindParam(':etat_animal', $etatAnimal, PDO::PARAM_STR);
    $query->bindParam(':detail_etat_animal', $detailEtatAnimal, PDO::PARAM_STR);
    $query->bindParam(':action_nourriture', $actionNourriture, PDO::PARAM_STR);
    $query->bindParam(':etat_habitat', $etatHabitat, PDO::PARAM_STR);
    $query->bindParam(':detail_etat_habitat', $detailEtatHabitat, PDO::PARAM_STR);
    $query->bindParam(':date_passage', $datePassage, PDO::PARAM_STR);
    $query->bindParam(':id_saisie', $idSaisie, PDO::PARAM_INT);

    try {
        // Exécuter la requête
        if ($query->execute()) {
            echo json_encode(['success' => true, 'message' => 'Saisie modifiée avec succès.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de la saisie.']);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur dans la base de données.',
            'error' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode de requête invalide.']);
}
?>
