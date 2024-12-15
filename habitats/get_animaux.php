<?php
require_once '../dbconnect.php';

// Vérifiez si l'ID de l'habitat est passé dans la requête
if (isset($_GET['id_habitat'])) {
    $idHabitat = $_GET['id_habitat'];

    // Préparer la requête pour récupérer les animaux associés à cet habitat
    $query = $pdo->prepare("
        SELECT a.nom_animal 
        FROM animal a 
        WHERE a.id_habitat = :id_habitat
    ");
    $query->bindParam(':id_habitat', $idHabitat, PDO::PARAM_INT);
    $query->execute();
    $animaux = $query->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer l'image et la description de l'habitat
    $habitatQuery = $pdo->prepare("SELECT description_habitat, image_path FROM habitats WHERE id_habitat = :id_habitat");
    $habitatQuery->bindParam(':id_habitat', $idHabitat, PDO::PARAM_INT);
    $habitatQuery->execute();
    $habitat = $habitatQuery->fetch(PDO::FETCH_ASSOC);

    // Vérifiez que nous avons bien des résultats
    if ($habitat) {
        $response = [
            'description' => $habitat['description_habitat'],
            'image' => $habitat['image_path'],
            'animaux' => array_map(function($animal) {
                return htmlspecialchars($animal['nom_animal']);
            }, $animaux)
        ];
    } else {
        $response = [
            'description' => 'Aucune description disponible',
            'image' => '',
            'animaux' => []
        ];
    }

    // Retourner la réponse au format JSON
    echo json_encode($response);
}