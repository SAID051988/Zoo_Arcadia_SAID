<?php
require_once '../dbconnect.php';
require_once '../config.php';

header('Content-Type: application/json'); // Définir l'en-tête pour JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Activer les messages d'erreur PHP pour débogage
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Récupérer les données du formulaire
    $nomAnimal = $_POST['nomAnimal'] ?? null;
    $habitatId = $_POST['habitat'] ?? null;
    $raceId = $_POST['race'] ?? null;
    $statusAnimal = $_POST['status'] ?? null;

    // Vérifier les valeurs des champs obligatoires
    if (!$nomAnimal || !$habitatId || !$raceId || !$statusAnimal) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
        exit;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES["image"]["name"]);
        $imagePath = "img/animaux/" . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $imagePath)) {
            $query = $pdo->prepare("INSERT INTO animal (nom_animal, status_animal, id_habitat, id_race, image_path) 
                                    VALUES (:nom, :status, :habitat, :race, :imagePath)");
            $query->bindParam(':nom', $nomAnimal, PDO::PARAM_STR);
            $query->bindParam(':status', $statusAnimal, PDO::PARAM_STR);
            $query->bindParam(':habitat', $habitatId, PDO::PARAM_INT);
            $query->bindParam(':race', $raceId, PDO::PARAM_INT);
            $query->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);

            try {
                if ($query->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Animal ajouté avec succès']);
                } else {
                    $errorInfo = $query->errorInfo();
                    echo json_encode(['success' => false, 'message' => 'Erreur dans l\'ajout de l\'animal', 'error' => $errorInfo[2]]);
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
