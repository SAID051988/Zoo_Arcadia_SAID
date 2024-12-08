<?php

include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");
require_once '../dbconnect.php';
require_once '../config.php';
?>
<style>
        /* code CSS */
        .tde {height: 40px;width: 40px;cursor: pointer;}
        #value {height: 40px; width: 20px; background: #D81324;}
        #glob {display: flex;}
</style>
    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">// EVALUEZ-NOUS //</h6>
                <h1 class="mb-5">Gestion des commentaires</h1>
            </div>
            <div class="row g-4">
            <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <div class="bg-primary  text-white d-flex flex-column justify-content-center p-4">
                                <h5 class="text-uppercase   text-white">// NOUS EVALUER ! //</h5>
                                <p class="m-0"><i class="fa fa-phone text-primary me-2"></i>
                                Mobile: 06 12 78 55 **<br>
                                Assistance: 03 74 52 86 **</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-primary text-white d-flex flex-column justify-content-center p-4">
                                <h5 class="text-uppercase  text-white ">// Votre avis compte pour nous //</h5>
                                <p class="m-0"><i class="fa fa-envelope-open text-primary me-2"></i>avis@example.com</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-primary  text-white d-flex flex-column justify-content-center p-4">
                                <h5 class="text-uppercase   text-white">// Technical //</h5>
                                <p class="m-0"><i class="fa fa-envelope-open text-primary me-2"></i>tech@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if(isset($_SESSION['roleUtilisateur']) && $_SESSION['roleUtilisateur']=='Employe'){
                    //Appeler la page connexion.php
                    require_once '../dbconnect.php';
                    // Traitement des avis des clients
                    $statement_avis=$pdo->prepare("select * from avis where valider_avis=0");
                    $statement_avis->execute();
                    // Récupération des résultats de la requête
                    $row_avis = $statement_avis->fetchAll(PDO::FETCH_ASSOC);
                    // Déclarer une variable $row_count pour récupérer le nombre des avis non encore validés
                    $row_count=count($row_avis);
                ?>
                <table class="table table-primary table-bordered">
                    <thead>
                        <tr><th>Nom</th><th>Email</th><th>Profession</th><th>Commentaire</th><th>Note</th><th>Date</th><th>Valide</th></tr>
                    </thead>
                    <?php                


                foreach ($row_avis as $avis) {
                    echo "<tr>";
                        echo  '<td>'.$avis['nom_avis'].'</td>';
                        echo  '<td>'.$avis['email_avis'].'</td>';
                        echo  '<td>'.$avis['profession_avis'].'</td>';
                        echo  '<td>'.$avis['message_avis'].'</td>';
                        echo  '<td>'.$avis['note_avis'].'</td>';
                        echo  '<td>'.$avis['date_avis'].'</td>';
                        ?>
                        <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input bg-primary" type="checkbox" id="valider_avis_<?php echo $avis['id_avis']; ?>" <?php echo ($avis['valider_avis'] == 1 ? 'checked' : ''); ?> onchange="updateValiderAvis(<?php echo $avis['id_avis']; ?>)">
                        </div>
                    </td>
                    <?php
                    echo "<tr>";
                }
                    ?>
                </table>
                <?php

                // On affiche ce message si tous les avis des clients ont été validés par l'employé
                if($row_count<=0){
                    echo '<div  class="alert alert-danger" role="alert"> Tous les avis ont été validés</div>';
                }

            }else{
                ?>
                <div class="col-md-12">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <?php
                // Afficher les messages s'ils existent
                if (isset($_SESSION['success_message_avis']) && !empty($_SESSION['success_message_avis'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message_avis'] . '</div>';
                    // Supprimer le message pour qu'il ne s'affiche pas à nouveau
                    unset($_SESSION['success_message_avis']);  
                }

                if (isset($_SESSION['error_message_avis']) && !empty($_SESSION['error_message_avis'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error_message_avis'] . '</div>';
                    // Supprimer le message pour qu'il ne s'affiche pas à nouveau
                    unset($_SESSION['error_message_avis']);  
                }
                ?>










                        <p class="mb-4">Vos commentaires sont soigneusement vérifiés par nos modérateurs afin de garantir leur authenticité et le respect de nos règles.
                             Vos commentaires seront visibles publiquement sur la page de notre établissement durant 36 mois.</p>
                        <form enctype="multipart/form-data" action="ajouter_avis.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="txtNom" placeholder="Votre nom" required>
                                        <label for="name">Votre nom</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="txtEmail" placeholder="Votre Email" required>
                                        <label for="email">Votre Email</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="txtPrefession" placeholder="Votre Profession" required>
                                        <label for="email">Votre Profession</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Saisir votre commentaire Ici" 
                                        name="txtMessage" style="height: 100px" required></textarea>
                                        <label for="message">Commentaire</label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-floating">
                                       <!-- Image du client -->                                       
                                           
                                            <input type="file" class="form-control" id="imageCommentaire" name="imageCommentaire" accept="image/*" required>                                        
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating" style="float:right; margin-right: 180px;">
                                      <!-- div en arrière-plan qui s'allongera en fonction de la valeur de $value1 -->
                                            <div id="value" >

                                        <!-- div qui contient les étoiles -->
                                        <!-- On utilise data-value pour récupérer la valeur de chaque image -->
                                        <div id="glob">
                                            <img id="tde_1" src="../img/star.png" class="tde" data-value="1"/>
                                            <img id="tde_2" src="../img/star.png" class="tde" data-value="2"/>
                                            <img id="tde_3" src="../img/star.png" class="tde" data-value="3"/>
                                            <img id="tde_4" src="../img/star.png" class="tde" data-value="4"/>
                                            <img id="tde_5" src="../img/star.png" class="tde" data-value="5"/>
                                        </div>

                                        </div>                                        
                                    </div>
                                </div>
                                <!-- C'est un type caché pour récupérer la note choisie par l'utilisateur -->
                                <!-- Au coté serveur le co,tenu sera récupérée avec Post -->
                                <input type="hidden" name="note_avis" id="note_avis" value="0" />

                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit" name="btnEnvoyerMessage">Envoyer Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Fonction pour récupérer la valeur des étoiles dans le stockage local
    function getStoredRating() {
        return localStorage.getItem('userRating') || 0;
    }

    // Fonction pour définir la valeur des étoiles dans le stockage local
    function setStoredRating(value) {
        localStorage.setItem('userRating', value);
    }

    // Initialiser la valeur des étoiles avec celle stockée localement
    var initialRating = getStoredRating();
    $(".tde").slice(0, initialRating).css("backgroundColor", "#D81324");

    // on détecte la présence de la souris sur une étoile
    $(".tde").mouseover(function() {
        var nbr = $(this).prop('id').substring(4);
        $(this).css("backgroundColor", "#D81324");
        $(".tde").slice(0, nbr).css("backgroundColor", "#D81324");
        $(".tde").slice(nbr).css("backgroundColor", "");
    });

    // et quand la souris s'en va, on annule le fond jaune sous les étoiles pour garder uniquement celui de #value
    $("#value").mouseout(function() {
        // Ne rien faire ici pour que les étoiles restent colorées après que la souris les a quittées
    });

    // on détecte le clic sur une étoile
    $(".tde").click(function() {
        var selectedValue = $(this).attr('data-value');
        //console.log("Étoile sélectionnée : " + selectedValue);

        // Enregistrez la valeur des étoiles dans le stockage local
        setStoredRating(selectedValue);

        // Mettez à jour la valeur du champ hidden dans le formulaire
        $("#note_avis").val(selectedValue);
    });
</script>

<script>
     function updateValiderAvis(id) {
        // Récupérez l'état de la checkbox
        var isChecked = $("#valider_avis_" + id).prop("checked");

        // Utilisez AJAX pour envoyer la mise à jour à votre script PHP
        $.ajax({
            url: 'update_valider_avis.php', // Remplacez cela par le chemin de votre script PHP de mise à jour
            method: 'POST',
            data: {
                id: id,
                value: isChecked ? 1 : 0
            },
            success: function(response) {
                // Affichez un message de succès ou mettez à jour l'interface utilisateur si nécessaire
                console.log(response);
            },
            error: function(error) {
                // Gérez les erreurs ici
                console.error(error);
            }
        });
    }
</script>




<?php
include("../pagesParametres/footer.php");
?>