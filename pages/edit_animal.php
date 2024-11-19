<?php
require_once '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_animal'];
    $nom = $_POST['nomAnimal'];
    $status = $_POST['status'];
    $habitat = $_POST['habitat'];
    $race = $_POST['race'];
    
    $imagePath = $_POST['currentImagePath']; // Utilisez l'image actuelle si aucune nouvelle image n'est téléchargée

    if (!empty($_FILES['image']['name'])) {
        $imageName = str_replace(' ', '_', $_FILES['image']['name']);
        $imagePath = "img/animaux/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $query = $pdo->prepare("UPDATE animal SET nom_animal = ?, status_animal = ?, id_habitat = ?, id_race = ?, image_path = ? WHERE id_animal = ?");
    $query->execute([$nom, $status, $habitat, $race, $imagePath, $id]);

    echo json_encode(['success' => true, 'message' => 'Animal modifié avec succès.']);
}
?>
