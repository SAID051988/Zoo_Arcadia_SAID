<?php
require_once '../dbconnect.php';

header('Content-Type: application/json');

try {
    $id_animal = $_GET['id'];
    $query = $pdo->prepare("SELECT a.nom_animal, a.status_animal, h.nom_habitat AS habitat, r.nom_race AS race 
        FROM animal a
        LEFT JOIN habitats h ON a.id_habitat = h.id_habitat
        LEFT JOIN races r ON a.id_race = r.id_race
        WHERE a.id_animal = :id_animal");
    $query->bindParam(':id_animal', $id_animal);
    $query->execute();
    $animal = $query->fetch(PDO::FETCH_ASSOC);

    if ($animal) {
        echo json_encode([
            'success' => true,
            'animal' => $animal
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Animal introuvable.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur : ' . $e->getMessage()
    ]);
}
