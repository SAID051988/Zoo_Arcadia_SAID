<?php
require_once '../dbconnect.php';
require_once '../config.php';

$query = $pdo->prepare("SELECT * FROM animal");
$query->execute();
$animaux = $query->fetchAll(PDO::FETCH_ASSOC);

// Retourner les résultats au format JSON
echo json_encode($animaux);
?>