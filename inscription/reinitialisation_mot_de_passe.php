<?php
include("../pagesParametres/dbconnect.php");

$token = $_GET['token'] ?? '';

// Vérifier si le token est valide
if ($token) {
    // Rechercher l'utilisateur avec ce token
    $sql = "SELECT * FROM utilisateur WHERE reset_token = :token AND token_expiration > NOW() LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Formulaire pour saisir un nouveau mot de passe
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'] ?? '';

            // Hacher le nouveau mot de passe
            $mot_passe_hash = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            $sql = "UPDATE utilisateur SET mot_passe_utilisateur = :mot_passe, reset_token = NULL, token_expiration = NULL WHERE id_utilisateur = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['mot_passe' => $mot_passe_hash, 'id' => $user['id_utilisateur']]);

            echo "Votre mot de passe a été réinitialisé avec succès.";
        }
    } else {
        echo "Token invalide ou expiré.";
    }
}
?>

<form method="POST" action="reinitialisation_mot_de_passe.php?token=<?php echo $token; ?>">
    <label for="nouveau_mot_de_passe">Nouveau mot de passe</label>
    <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required>
    <button type="submit">Réinitialiser le mot de passe</button>
</form>
