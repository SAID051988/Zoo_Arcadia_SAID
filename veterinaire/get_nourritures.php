<?php
require_once '../dbconnect.php';

if (isset($_GET['id_animal'])) {
    $idAnimal = (int)$_GET['id_animal'];

    $query = $pdo->prepare("
        SELECT n.id_nourriture, n.nom AS nom_nourriture
        FROM animal_nourriture an
        INNER JOIN nourriture n ON an.id_nourriture = n.id_nourriture
        WHERE an.id_animal = :id_animal
    ");
    $query->bindParam(':id_animal', $idAnimal, PDO::PARAM_INT);
    $query->execute();

    $nourritures = $query->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les données en JSON
    echo json_encode($nourritures);
}
?>
