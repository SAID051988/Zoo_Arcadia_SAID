<?php
require_once '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $statement = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    if ($statement->execute([$id])) {
        echo "Contact supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du contact.";
    }
}
?>
