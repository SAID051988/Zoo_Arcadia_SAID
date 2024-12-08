<?php

include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");
require_once '../dbconnect.php';
require_once '../config.php';
?>
   


    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">// CONTACTEZ-NOUS //</h6>
                <h1 class="mb-5">Contact pour toute question</h1>
            </div>
            <div class="row g-4">
            <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <div class="bg-primary text-white d-flex flex-column justify-content-center p-4">
                                <h5 class="text-uppercase text-white">// NOUS CONTACTER ! //</h5>
                                <p class="m-0"><i class="fa fa-phone text-primary me-2"></i>
                                Mobile: 06 12 78 55 **<br>
                                Assistance: 03 74 52 86 **</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-primary text-white d-flex flex-column justify-content-center p-4">
                                <h5 class="text-uppercase text-white">// Votre avis compte pour nous //</h5>
                                <p class="m-0"><i class="fa fa-envelope-open text-primary me-2"></i>avis@example.com</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-primary text-white d-flex flex-column justify-content-center p-4">
                                <h5 class="text-uppercase text-white">// Technical //</h5>
                                <p class="m-0"><i class="fa fa-envelope-open text-primary me-2"></i>tech@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <p class="mb-4">N'hésitez pas à nous contacter pour toute question ou demande d'informations supplémentaires. Merci de nous faire confiance pour tous vos besoins automobiles.</p>
                        <form id="ajouterContact" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="txtPrenomNom" placeholder="Vos prénom et nom">
                                        <label for="name">Vos prénom et nom</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="txtEemail" placeholder="Votre Email">
                                        <label for="email">Votre Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="txtSujet" placeholder="Sujet">
                                        <label for="subject">Sujet</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Saisir votre message Ici" name="message" style="height: 100px"></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit" name="btnEnvoyerMessage">Envoyer Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    <!-- Contact End -->
<!-- Ajoutez ceci à votre page HTML -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Event listener pour la soumission du formulaire
        $("#ajouterContact").submit(function(event) {
            // Empêcher la soumission par défaut du formulaire
            event.preventDefault();

            // Récupérer les données du formulaire
            var formData = $("#ajouterContact").serialize();

            // Faire une requête Ajax
            $.ajax({
                type: "POST",
                url: "ajouter_contact.php", // Créez ce fichier pour traiter l'insertion côté serveur
                data: formData,
                success: function(response) {
                    // Traiter la réponse du serveur (par exemple, afficher un message de succès)
                    console.log(response);
                    alert("Message envoyé avec succès!");
                },
                error: function(error) {
                    // Gérer les erreurs (par exemple, afficher un message d'erreur)
                    console.error(error);
                    alert("Erreur lors de l'envoi du message.");
                }
            });
        });
    });
</script>
 
<?php
    require_once '../pagesParametres/footer.php';
?>


    