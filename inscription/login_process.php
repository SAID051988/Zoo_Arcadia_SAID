<?php
require_once '../dbconnect.php'; // Connexion à la base de données
header('Content-Type: application/json'); // Format JSON pour la réponse
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données envoyées
    $identifiant = $_POST['identifiant_utilisateur'] ?? '';
    $mot_de_passe = $_POST['password_utilisateur'] ?? '';

    // Stocker les erreurs
    $errors = [];

    // Validation des champs
    if (empty($identifiant)) {
        $errors['identifiant_utilisateur'] = "Le champ identifiant est obligatoire.";
    }
    if (empty($mot_de_passe)) {
        $errors['password_utilisateur'] = "Le champ mot de passe est obligatoire.";
    }

    // Si des erreurs existent, retourner les erreurs
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }

    try {
        // Requête pour récupérer l'utilisateur
        $sql = "SELECT * FROM utilisateur WHERE email_utilisateur = :identifiant LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['identifiant' => $identifiant]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérifier le mot de passe
            if (password_verify($mot_de_passe, $user['mot_passe_utilisateur'])) {
                // Stocker les informations de l'utilisateur en session
                $_SESSION['user_id'] = $user['id_utilisateur'];
                $_SESSION['user_role'] = $user['role_utilisateur'];
                $_SESSION['user_name'] = $user['prenom_utilisateur'] . ' ' . $user['nom_utilisateur'];

                echo json_encode(['success' => true, 'message' => "Connexion réussie.",'role' => $user['role_utilisateur'] ]);
            } else {
                echo json_encode(['success' => false, 'errors' => ['general' => "Mot de passe incorrect."]]);
            }
        } else {
            echo json_encode(['success' => false, 'errors' => ['general' => "Identifiant introuvable."]]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'errors' => ['general' => "Erreur serveur : " . $e->getMessage()]]);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['general' => "Requête invalide."]]);
}
