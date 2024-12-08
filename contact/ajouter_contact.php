<?php
require_once '../connexion/connexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $prenomNom = $_POST['txtPrenomNom'];
    $email = $_POST['txtEemail'];
    $sujet = $_POST['txtSujet'];
    $message = $_POST['message'];

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO contacts (prenom_nom, email, sujet, message) VALUES (:prenomNom, :email, :sujet, :message)";

    // Utiliser une requête préparée pour éviter les injections SQL
    $statement = $pdo->prepare($sql);

    // Binder les valeurs
    $statement->bindParam(':prenomNom', $prenomNom);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':sujet', $sujet);
    $statement->bindParam(':message', $message);

    // Exécuter la requête
    $statement->execute();

    // Envoyer une réponse au client (peut être n'importe quoi, une chaîne, un code, etc.)
    echo "Message envoyé avec succès!";
}
