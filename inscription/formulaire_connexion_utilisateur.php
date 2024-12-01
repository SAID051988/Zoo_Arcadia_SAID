<?php
session_start();
include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");

?>

<section class="intro">
    <div class="mask d-flex align-items-center h-100 gradient-custom">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card  shadow-lg">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="text-center text-primary">Formulaire de connexion</h2>
                            <form class="login-form">
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    <input type="tel" class="form-control rounded-left" id="identifiant_utilisateur"
                                        name="identifiant_utilisateur" placeholder="Username" >
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control rounded-left" id="password_utilisateur"
                                        name="password_utilisateur" placeholder="Password" required>
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <div class="w-100">
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                        <label class="checkbox-wrap checkbox-primary mb-0">Enregistrer le mot de passe
                                        </label>
                                    </div>
                                    <div class="w-100 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary rounded submit">Se
                                            Connecter</button>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <div class="w-100 text-center">
                                        <p class="mb-1">Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
                                        <p><a href="mot_de_passe_oublie.php">Mot de passe oublié</a></p>
                                    </div>
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
        $(".login-form").on("submit", function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Récupérer les données du formulaire
            var formData = $(this).serialize();

            // Envoyer les données via AJAX
            $.ajax({
                type: "POST",
                url: "login_process.php", // URL du fichier de traitement PHP
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Redirection en cas de succès
                        window.location.href = "dashboard.php";
                    } else {
                        $('.invalid-feedback').remove();
                        $("input").removeClass("is-invalid");

                        // Afficher les messages d'erreur pour chaque champ
                        if (response.errors) {
                            $.each(response.errors, function (field, message) {
                                var inputField = $("#" + field);
                                inputField.addClass("is-invalid");
                                inputField.after('<div class="invalid-feedback">' + message + '</div>');
                            });

                            // Afficher un message général s'il existe
                            if (response.errors.general) {
                                alert(response.errors.general);
                            }
                        } else {
                            alert("Erreur inconnue. Veuillez réessayer.");
                        }
                    }
                }
            });
        });
    });
</script>


<?php
include("../pagesParametres/footer.php");
?>