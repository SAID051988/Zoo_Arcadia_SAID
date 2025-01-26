<?php
session_start();


?>

<section class="intro">
    <div class="mask d-flex align-items-center h-100 gradient-custom">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card  shadow-lg">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="text-center text-primary">Formulaire d'inscription</h2>
                            <form method="post">
                                <!-- Ligne pour les boutons radio -->
                                
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <!-- Prénom -->
                                        <label for="prenom_utilisateur" class="form-label">Prénom</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            <input type="text" class="form-control" id="prenom_utilisateur"
                                                name="prenom_utilisateur" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <!-- Nom -->
                                        <label for="nom_utilisateur" class="form-label">Nom</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            <!-- Vous pouvez changer l'icône ici si nécessaire -->
                                            <input type="text" class="form-control" id="nom_utilisateur"
                                                name="nom_utilisateur" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="email_utilisateur" class="form-label">Identifiant (Email)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email_utilisateur"
                                                name="email_utilisateur" required>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="repeter_email_utilisateur" class="form-label">Confirmer votre identifiant (Email)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="repeter_email_utilisateur"
                                                name="repeter_email_utilisateur" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Téléphone -->
                                    <div class="col-md-6 mb-2">
                                        <label for="tel_utilisateur" class="form-label">Téléphone</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            <input type="tel" class="form-control" id="tel_utilisateur"
                                                name="tel_utilisateur" required>
                                        </div>

                                    </div>

                                    <!-- Rôle -->
                                    <div class="col-md-6 mb-2">
                                        <div class="form-outline">
                                            <label for="role" class="form-label">Rôle</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                <select class="form-control" id="role" name="role" required>
                                                    <option value="" disabled selected>Sélectionnez un rôle</option>
                                                    <option value="veterinaire">Vétérinaire</option>
                                                    <option value="employe">Employé</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <!-- Mot de passe -->
                                    <div class="col-md-6 mb-2">
                                        <label for="mot_passe_utilisateur" class="form-label">Mot de passe</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            <input type="password" class="form-control" id="mot_passe_utilisateur"
                                                name="mot_passe_utilisateur" required>
                                        </div>

                                    </div>

                                    <!-- Répéter Mot de passe -->
                                    <div class="col-md-6 mb-2">
                                        <label for="repeter_mot_passe_utilisateur" class="form-label">Répéter Mot de
                                            passe</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            <input type="password" class="form-control"
                                                id="repeter_mot_passe_utilisateur" name="repeter_mot_passe_utilisateur"
                                                required>
                                        </div>

                                    </div>
                                </div>
                                <!-- Bouton de soumission et lien vers la connexion -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <!-- Bouton de soumission -->
                                    <button type="submit" class="btn btn-primary">Inscrire cet agent</button>


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
        $("form").on("submit", function (e) {
            e.preventDefault(); // Empêche le rechargement de la page
            // Récupérer les données du formulaire
            var formData = $(this).serialize();

            // Envoyer les données via AJAX
            $.ajax({
                type: "POST",
                url: "formulaire_inscription_utilisateur.php", // URL de traitement (formulaire_inscription_utilisateur.php)
                data: formData,
                dataType: "json", // Format attendu pour la réponse
                success: function (response) {
                    if (response.success) {
                        // Afficher un message de succès
                        alert("Inscription réussie !");
                        $("form")[0].reset(); // Réinitialiser le formulaire
                    } else {
                        // Afficher les erreurs sous les champs correspondants
                        $('.invalid-feedback').remove(); // Supprimer les messages d'erreur existants
                        $("input").removeClass("is-invalid"); // Supprimer la classe is-invalid de tous les champs

                        // Parcourir les erreurs reçues
                        $.each(response.errors, function (field, message) {
                            var inputField = $("#" + field);
                            inputField.addClass("is-invalid");
                            inputField.after('<div class="invalid-feedback">' + message + '</div>');
                        });
                    }
                },
                error: function (xhr, status, err) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            alert("Une erreur est survenue : " + response.errors.general);
                        } else {
                            alert("Erreur inconnue : " + err);
                        }
                    } catch (e) {
                        alert("Une erreur est survenue, impossible d'analyser la réponse JSON : " + e.message);
                    }
                }

            });
        });
    });

</script>
