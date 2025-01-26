<?php
require_once '../dbconnect.php';
header('Content-Type: application/json'); // Réponse au format JSON
session_start();
// Vérification de la méthode HTTP
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formData = [
        'prenom_utilisateur' => $_POST['prenom_utilisateur'] ?? '',
        'nom_utilisateur' => $_POST['nom_utilisateur'] ?? '',
        'email_utilisateur' => $_POST['email_utilisateur'] ?? '',
        'repeter_email_utilisateur' => $_POST['repeter_email_utilisateur'] ?? '',
        'tel_utilisateur' => $_POST['tel_utilisateur'] ?? '',
        'role' => $_POST['role'] ?? '',
        'mot_passe_utilisateur' => $_POST['mot_passe_utilisateur'] ?? '',
        'repeter_mot_passe_utilisateur' => $_POST['repeter_mot_passe_utilisateur'] ?? ''
    ];

    // Validation des champs
    $errors = [];
    if (empty($formData['prenom_utilisateur'])) {
        $errors['prenom_utilisateur'] = "Le prénom est requis.";
    }
    if (empty($formData['nom_utilisateur'])) {
        $errors['nom_utilisateur'] = "Le nom est requis.";
    }
    if (!filter_var($formData['email_utilisateur'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_utilisateur'] = "L'email est invalide.";
    }
    if ($formData['email_utilisateur'] !== $formData['repeter_email_utilisateur']) {
        $errors['repeter_email_utilisateur'] = "Les emails ne correspondent pas.";
    }
    if (empty($formData['tel_utilisateur'])) {
        $errors['tel_utilisateur'] = "Le téléphone est requis.";
    }
    if (empty($formData['role'])) {
        $errors['role'] = "Le rôle est requis.";
    }
    if (empty($formData['mot_passe_utilisateur']) || empty($formData['repeter_mot_passe_utilisateur'])) {
        $errors['mot_passe_utilisateur'] = "Les mots de passe sont requis.";
    } elseif ($formData['mot_passe_utilisateur'] !== $formData['repeter_mot_passe_utilisateur']) {
        $errors['repeter_mot_passe_utilisateur'] = "Les mots de passe ne correspondent pas.";
    }

    // Si des erreurs existent, renvoyer une réponse avec les erreurs
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }

    // Enregistrement dans la base de données si pas d'erreurs
    $mot_passe_hash = password_hash($formData['mot_passe_utilisateur'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO utilisateur (prenom_utilisateur, nom_utilisateur, email_utilisateur, tel_utilisateur, role_utilisateur, mot_passe_utilisateur, cree_le) 
           VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $formData['prenom_utilisateur'],
            $formData['nom_utilisateur'],
            $formData['email_utilisateur'],
            $formData['tel_utilisateur'],
            $formData['role'],
            $mot_passe_hash
        ]);
        // Envoi de l'e-mail après l'inscription réussie
        $to = $formData['email_utilisateur'];
        $subject = "Bienvenue sur notre plateforme";
        $message = "Bonjour " . $formData['prenom_utilisateur'] . " " . $formData['nom_utilisateur'] . ",\n\n";
        $message .= "Vous avez été inscrit avec succès sur notre plateforme.\n";
        $message .= "Voici vos informations de connexion :\n";
        $message .= "Email : " . $formData['email_utilisateur'] . "\n";
        $message .= "Mot de passe : Contacter l'Administrateur pour récupérer votre mot de passe" ."\n\n";
        $message .= "Cordialement,\nL'équipe de gestion.";

        $headers = "From: hajjriadh@gmail.com\r\n";
        $headers .= "Reply-To: hajjriadh@gmail.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Envoyer l'e-mail avec Sendmail
        if (mail($to, $subject, $message, $headers)) {
            echo json_encode(['success' => true, 'message' => "Inscription réussie et e-mail envoyé !"]);
        } else {
            echo json_encode(['success' => false, 'errors' => ['general' => "Inscription réussie, mais l'e-mail n'a pas pu être envoyé."]]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'errors' => ['general' => "Erreur : " . $e->getMessage()]]);
    }
}
?>