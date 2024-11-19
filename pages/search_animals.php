<?php
require_once '../dbconnect.php';
require_once '../config.php';

if (isset($_GET['query'])) {
    $searchTerm = "%" . $_GET['query'] . "%"; // Préparez le terme de recherche

    // Préparez la requête pour rechercher dans la base de données
    $query = $pdo->prepare("SELECT * FROM animal WHERE nom_animal LIKE :searchTerm");
    $query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    
    if ($query->execute()) { // Exécutez uniquement si cela réussit
        // Récupérer tous les résultats
        $animaux = $query->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les résultats au format JSON
        echo json_encode($animaux);
    } else {
        echo json_encode([]); // Retourne un tableau vide en cas d'erreur
    }
} else {
    echo json_encode([]); // Retourne un tableau vide si aucune requête n'est fournie
}
?>