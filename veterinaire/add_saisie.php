<?php
require_once '../dbconnect.php'; // Connexion à la base de données
require_once '../config.php';

header('Content-Type: application/json'); // Définir l'en-tête pour JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Activer les messages d'erreur PHP pour débogage
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Récupérer les données du formulaire
    $idAnimal = $_POST['id_animal'] ?? null;
    $idNourriture = $_POST['id_nourriture'] ?? null;
    $etatAnimal = $_POST['etat_animal'] ?? null;
    $etatHabitat = $_POST['etat_habitat'] ?? null;
    $actionNourriture = $_POST['action_nourriture'] ?? null;
    $datePassage = $_POST['date_passage'] ?? null;
    $detailEtatAnimal = $_POST['detail_etat_animal'] ?? null;
    $detailEtatHabitat = $_POST['detail_etat_habitat'] ?? null;

    // Vérification des champs obligatoires
    if (!$idAnimal || !$idNourriture || !$etatAnimal || !$actionNourriture || !$datePassage) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis.']);
        exit;
    }

    // Préparation de la requête
    $query = $pdo->prepare("
        INSERT INTO veterinaire_saisie (
            id_animal, id_nourriture, etat_animal, etat_habitat, action_nourriture, date_passage, detail_etat_animal, detail_etat_habitat
        ) VALUES (
            :id_animal, :id_nourriture, :etat_animal, :etat_habitat, :action_nourriture, :date_passage, :detail_etat_animal, :detail_etat_habitat
        )
    ");

    // Liaison des paramètres
    $query->bindParam(':id_animal', $idAnimal, PDO::PARAM_INT);
    $query->bindParam(':id_nourriture', $idNourriture, PDO::PARAM_INT);
    $query->bindParam(':etat_animal', $etatAnimal, PDO::PARAM_STR);
    $query->bindParam(':etat_habitat', $etatHabitat, PDO::PARAM_STR);
    $query->bindParam(':action_nourriture', $actionNourriture, PDO::PARAM_STR);
    $query->bindParam(':date_passage', $datePassage, PDO::PARAM_STR);
    $query->bindParam(':detail_etat_animal', $detailEtatAnimal, PDO::PARAM_STR);
    $query->bindParam(':detail_etat_habitat', $detailEtatHabitat, PDO::PARAM_STR);

    try {
        if ($query->execute()) {
            echo json_encode(['success' => true, 'message' => 'Saisie ajoutée avec succès.']);
        } else {
            $errorInfo = $query->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout.', 'error' => $errorInfo[2]]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur dans la base de données.', 'error' => $e->getMessage()]);
    }
}
?>
