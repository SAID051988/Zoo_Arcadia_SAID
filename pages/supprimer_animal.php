<?php
require_once '../dbconnect.php';
require_once '../config.php';

if (isset($_GET['id'])) {
    $idAnimal = intval($_GET['id']);
    $stmt = $pdo->prepare('DELETE FROM animal WHERE id_animal = ?');
    if ($stmt->execute([$idAnimal])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
