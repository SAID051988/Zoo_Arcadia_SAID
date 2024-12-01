<?php
include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");

// Connexion à la base de données
require_once '../dbconnect.php';

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email_utilisateur'] ?? '';

    // Vérifier que l'email n'est pas vide
    if (empty($email)) {
        // Réponse JSON pour l'erreur
        echo json_encode(['success' => false, 'error' => 'L\'email est obligatoire.']);
        exit();
    } else {
        // Rechercher l'utilisateur avec cet email
        $sql = "SELECT * FROM utilisateur WHERE email_utilisateur = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Générer un token unique pour la réinitialisation
            $token = bin2hex(random_bytes(16));
            $expiration = date("Y-m-d H:i:s", strtotime("+1 hour")); // Le token expire dans une heure

            // Enregistrer le token et l'expiration dans la base de données
            $sql = "UPDATE utilisateur SET reset_token = :token, token_expiration = :expiration WHERE email_utilisateur = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['token' => $token, 'expiration' => $expiration, 'email' => $email]);

            // Envoi de l'email avec un lien de réinitialisation
            $reset_link = "http://votre-domaine.com/reinitialisation_mot_de_passe.php?token=" . $token;
            mail($email, "Réinitialisation de votre mot de passe", "Cliquez sur ce lien pour réinitialiser votre mot de passe : " . $reset_link);

            // Réponse JSON pour le succès
            echo json_encode(['success' => true, 'message' => 'Un lien de réinitialisation a été envoyé à votre email.']);
        } else {
            // Réponse JSON pour l'email non trouvé
            echo json_encode(['success' => false, 'error' => 'Aucun utilisateur trouvé avec cet email.']);
        }
    }
    exit();
}
?>

<section class="intro">
    <div class="mask d-flex align-items-center h-100 gradient-custom">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card  shadow-lg">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="text-center text-primary">Formulaire de réinitialisation du mot de passe</h2>
                            <!-- Alerte pour afficher les messages d'erreur ou de succès -->
                            <div id="responseMessage" class="alert d-none" role="alert">
                                <!-- Les messages d'erreur ou de succès seront insérés ici -->
                            </div>
                            <form id="reset-password-form" method="POST">

                            <label for="email_utilisateur" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email_utilisateur"
                                                name="email_utilisateur" required>
                                        </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                <button type="submit" class="btn btn-primary">Envoyer le lien de
                                    réinitialisation</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Soumettre le formulaire via AJAX
        $("#reset-password-form").on("submit", function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Sérialiser les données du formulaire
            var formData = $(this).serialize();

            // Envoyer via AJAX
            $.ajax({
                type: "POST",
                url: "mot_de_passe_oublie.php", // URL de la même page
                data: formData,
                dataType: "json", // Format attendu de la réponse
                success: function (response) {
                    // Cacher l'alerte si elle est déjà affichée
                    $('#responseMessage').removeClass('d-none alert-danger alert-success');

                    // Afficher le message en fonction de la réponse
                    if (response.success) {
                        $('#responseMessage').addClass('alert-success');
                        $('#responseMessage').html('<p>' + response.message + '</p>');
                    } else {
                        $('#responseMessage').addClass('alert-danger');
                        $('#responseMessage').html('<p>' + response.error + '</p>');
                    }
                    // Afficher l'alerte
                    $('#responseMessage').removeClass('d-none');
                },
                error: function () {
                    $('#responseMessage').removeClass('d-none alert-danger alert-success');
                    $('#responseMessage').addClass('alert-danger');
                    $('#responseMessage').html('<p>Une erreur est survenue, veuillez réessayer.</p>');
                }
            });
        });
    });
</script>



<?php if (isset($error)) {
    echo "<p>$error</p>";
} ?>
<?php
include("../pagesParametres/footer.php");
?>