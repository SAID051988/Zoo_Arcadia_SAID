<?php
require_once '../dbconnect.php';

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
$query = $pdo->prepare("SELECT * FROM animal WHERE nom_animal LIKE :searchTerm LIMIT :start, :limit");
$query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$query->execute();
$animaux = $query->fetchAll();

foreach ($animaux as $animal) {
    echo "<tr>
        <td>{$animal['id_animal']}</td>
        <td>" . htmlspecialchars($animal['nom_animal']) . "</td>
        <td>" . htmlspecialchars($animal['status_animal']) . "</td>
        <td>" . htmlspecialchars($animal['id_habitat']) . "</td>
        <td>" . htmlspecialchars($animal['id_race']) . "</td>
        <td><img src='" . htmlspecialchars(BASE_IMAGE_PATH . $animal['image_path']) . "' alt='Image' class='table-image'></td>
        <td>
            <a href='#' class='text-warning' onclick='openEditModal({$animal['id_animal']})'><i class='fas fa-edit fa-lg'></i></a>
            <a href='supprimer_animal.php?id={$animal['id_animal']}' class='text-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet animal ?\");'><i class='fas fa-trash-alt fa-lg'></i></a>
            <a href='details_animal.php?id={$animal['id_animal']}' class='text-primary'><i class='fas fa-info-circle fa-lg'></i></a>
        </td>
    </tr>";
}
?>
