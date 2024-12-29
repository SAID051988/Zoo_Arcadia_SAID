<?php
require_once '../dbconnect.php'; // Assurez-vous que ce chemin est correct

header('Content-Type: application/json'); // Définir l'en-tête pour JSON

if (isset($_GET['id'])) {
    $habitatId = $_GET['id'];

    $query = $pdo->prepare("SELECT * FROM habitats WHERE id_habitat = :id");
    $query->bindParam(':id', $habitatId, PDO::PARAM_INT);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        $habitat = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'habitat' => $habitat]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun habitat trouvé']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID d\'habitat manquant']);
}
?>
