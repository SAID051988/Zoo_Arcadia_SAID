<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'employe') {
    header('Location: ../inscription/formulaire_connexion_utilisateur.php');
    exit();
}

// include("../pagesParametres/beforeHeader.php");
// include("../pagesParametres/navbar.php");
// include("../pagesParametres/header.php");
require_once '../dbconnect.php';
require_once '../config.php';
?>
<style>
        /* code CSS */
        .tde {height: 40px;width: 40px;cursor: pointer;}
        #value {height: 40px; width: 20px; background: #D81324;}
        #glob {display: flex;}
.form-check-input[type=checkbox] {
    border-radius: 0.50em;
}
    
</style>
    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">               
                <h1 class="mb-5">Gestion des avis</h1>
            </div>
            <div class="row g-4">
          
                <?php
                if (isset($_SESSION['user_role']) || $_SESSION['user_role'] == 'employe') {
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
                <table class="table table-bordered">
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
        <input
            class="form-check-input"
            type="checkbox"
            role="switch"
            id="valider_avis_<?php echo $avis['id_avis']; ?>"
            <?php echo ($avis['valider_avis'] == 1 ? 'checked' : ''); ?>
            onchange="updateAvis(<?php echo $avis['id_avis']; ?>)">
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











                    </div>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    