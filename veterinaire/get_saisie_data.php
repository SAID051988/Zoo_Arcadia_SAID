<?php
require_once '../dbconnect.php'; 

header('Content-Type: application/json'); 

if (isset($_GET['id'])) {
    $idSaisie = (int)$_GET['id'];

    try {
        $sql = "
            SELECT 
                vs.id_saisie, 
                a.id_animal, 
                a.nom_animal, 
                n.id_nourriture, 
                n.nom AS nom_nourriture, 
                vs.etat_animal,
                vs.etat_habitat,
                vs.action_nourriture, 
                vs.date_passage, 
                vs.detail_etat_animal,
                vs.detail_etat_habitat 
            FROM veterinaire_saisie vs
            JOIN animal a ON vs.id_animal = a.id_animal
            JOIN animal_nourriture an ON vs.id_nourriture = an.id_nourriture
            JOIN nourriture n ON n.id_nourriture = an.id_nourriture
            WHERE vs.id_saisie = :id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $idSaisie, PDO::PARAM_INT);
        $stmt->execute();

        $saisie = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($saisie) {
    echo json_encode(['status' => 'success', 'data' => $saisie]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Aucune saisie trouvée']);
}

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Erreur : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID manquant']);
}
?>
