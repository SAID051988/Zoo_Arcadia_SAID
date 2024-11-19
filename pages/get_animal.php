<?php
require_once '../dbconnect.php';

if (isset($_GET['id'])) {
    $animalId = (int) $_GET['id'];
    $query = $pdo->prepare("SELECT * FROM animal WHERE id_animal = :id");
    $query->bindParam(':id', $animalId, PDO::PARAM_INT);
    $query->execute();
    $animal = $query->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($animal);
}
?>
