<?php
// Connexion à la base de données
require_once '../dbconnect.php';

// Vérifier si l'ID est passé
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Assurez-vous que l'ID est un entier valide

    // Nouvelle requête pour récupérer la description et les animaux
    $stmt = $pdo->prepare("
        SELECT 
            h.description_habitat,
            GROUP_CONCAT(a.nom_animal SEPARATOR ', ') AS animaux
        FROM 
            habitats h
        LEFT JOIN 
            animal a
        ON 
            h.id_habitat = a.id_habitat
        WHERE 
            h.id_habitat = :id
        GROUP BY 
            h.id_habitat
    ");

    $stmt->execute(['id' => $id]);
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($habitat) {
        // Préparation de la réponse
        $response = [
            'description' => $habitat['description_habitat'],
            'animaux' => $habitat['animaux'] ? explode(', ', $habitat['animaux']) : [] // Convertir en tableau si non nul
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['description' => 'Habitat non trouvé.', 'animaux' => []]);
    }
} else {
    echo json_encode(['error' => 'ID non fourni.']);
}
?>
