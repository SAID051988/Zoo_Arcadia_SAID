<?php
require_once '../dbconnect.php'; // Assurez-vous que ce chemin est correct

header('Content-Type: application/json'); // Définir l'en-tête pour JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Récupérer les données du formulaire
    $habitatId = $_POST['id_habitat'] ?? null;
    $nomHabitat = $_POST['nom_habitat'] ?? null;
    $descriptionHabitat = $_POST['description_habitat'] ?? null;
    $currentImagePath = $_POST['currentImagePath'] ?? null; // Récupérer l'image actuelle depuis le formulaire

    // Vérifier si une nouvelle image a été téléchargée
    $imagePath = $currentImagePath; // Par défaut, conserver l'image actuelle
    if (!empty($_FILES['image']['name'])) {
        $imageName = str_replace(' ', '_', $_FILES['image']['name']); // Remplacer les espaces dans le nom de fichier
        $imagePath = "img/habitats/" . $imageName;

        // Déplacer la nouvelle image
        if (!move_uploaded_file($_FILES['image']['tmp_name'], "../" . $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement de l\'image']);
            exit;
        }
    }

    // Vérifier les champs obligatoires
    if (!$habitatId || !$nomHabitat || !$descriptionHabitat) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
        exit;
    }

    // Préparer la requête de mise à jour
    $query = $pdo->prepare("
        UPDATE habitats 
        SET nom_habitat = :nom, 
            description_habitat = :description, 
            image_path = :image_path, 
            updated_at = NOW() 
        WHERE id_habitat = :id
    ");

    $query->bindParam(':nom', $nomHabitat, PDO::PARAM_STR);
    $query->bindParam(':description', $descriptionHabitat, PDO::PARAM_STR);
    $query->bindParam(':image_path', $imagePath, PDO::PARAM_STR);
    $query->bindParam(':id', $habitatId, PDO::PARAM_INT);

    try {
        if ($query->execute()) {
            echo json_encode(['success' => true, 'message' => 'Habitat modifié avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'habitat']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour dans la base de données', 'error' => $e->getMessage()]);
    }
}
