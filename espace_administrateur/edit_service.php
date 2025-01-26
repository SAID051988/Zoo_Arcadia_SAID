<?php
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_service = intval($_POST['id_service']);
    $nom_service = htmlspecialchars($_POST['nom_service']);
    $description_service = htmlspecialchars($_POST['description_service']);

    if (!empty($id_service) && !empty($nom_service) && !empty($description_service)) {
        $query = $pdo->prepare("UPDATE services SET nom_service = :nom_service, description_service = :description_service WHERE id_service = :id_service");
        $query->bindParam(':nom_service', $nom_service, PDO::PARAM_STR);
        $query->bindParam(':description_service', $description_service, PDO::PARAM_STR);
        $query->bindParam(':id_service', $id_service, PDO::PARAM_INT);

        if ($query->execute()) {
            header("Location: services.php?success=Service mis à jour avec succès");
        } else {
            header("Location: services.php?error=Erreur lors de la mise à jour du service");
        }
    } else {
        header("Location: services.php?error=Veuillez remplir tous les champs");
    }
    exit;
}
?>
