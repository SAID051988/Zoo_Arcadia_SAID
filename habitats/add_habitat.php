<?php
require_once '../dbconnect.php'; // Assurez-vous que ce chemin est correct
require_once '../config.php';

header('Content-Type: application/json'); // Définir l'en-tête pour JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Activer les messages d'erreur PHP pour débogage
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Récupérer les données du formulaire
    $nomHabitat = $_POST['nomHabitat'] ?? null;
    $descriptionHabitat = $_POST['descriptionHabitat'] ?? null;

    // Vérifier les valeurs des champs obligatoires
    if (!$nomHabitat || !$descriptionHabitat) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
        exit;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES["image"]["name"]);
        $imagePath = "img/habitats/" . $imageName; // Chemin pour les images des habitats

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $imagePath)) {
            $query = $pdo->prepare("INSERT INTO habitats (nom_habitat, description_habitat, image_path) 
                                    VALUES (:nom, :description, :imagePath)");
            $query->bindParam(':nom', $nomHabitat, PDO::PARAM_STR);
            $query->bindParam(':description', $descriptionHabitat, PDO::PARAM_STR);
            $query->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);

            try {
                if ($query->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Habitat ajouté avec succès']);
                } else {
                    $errorInfo = $query->errorInfo();
                    echo json_encode(['success' => false, 'message' => 'Erreur dans l\'ajout de l\'habitat', 'error' => $errorInfo[2]]);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout dans la base de données', 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du déplacement de l\'image']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement de l\'image']);
    }
}
?>
