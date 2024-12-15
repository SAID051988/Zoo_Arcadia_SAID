<?php
include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");
require_once '../dbconnect.php';
require_once '../config.php';
?>
<style>
    /* Ajoutez des styles CSS si nécessaire */
</style>

<!-- Page Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="text-primary text-uppercase">// CONTACTEZ-NOUS //</h6>
            <h1 class="mb-5">Gestion des contacts</h1>
        </div>
        <div class="row g-4">
            <?php
            //if (isset($_SESSION['roleUtilisateur']) && $_SESSION['roleUtilisateur'] == 'Employe') {
                // Récupération des messages de la table `contacts`
                $statement_contacts = $pdo->prepare("SELECT * FROM contacts ORDER BY date_creation DESC");
                $statement_contacts->execute();
                $row_contacts = $statement_contacts->fetchAll(PDO::FETCH_ASSOC);

                if (count($row_contacts) > 0) {
                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Prénom et Nom</th>
                                <th>Email</th>
                                <th>Sujet</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($row_contacts as $contact) {
                            echo "<tr>";
                            echo "<td>{$contact['prenom_nom']}</td>";
                            echo "<td>{$contact['email']}</td>";
                            echo "<td>{$contact['sujet']}</td>";
                            echo "<td>{$contact['message']}</td>";
                            echo "<td>{$contact['date_creation']}</td>";
                            ?>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-danger btn-sm" onclick="supprimerContact(<?php echo $contact['id']; ?>)">Supprimer</button>
                                </div>
                            </td>
                            <?php
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo '<div class="alert alert-info">Aucun contact trouvé.</div>';
                }
            //} else {
                ?>
                <!-- <div class="col-md-12">
                    <div class="alert alert-warning">Vous n'avez pas les permissions nécessaires pour accéder à cette page.</div>
                </div> -->
                <?php
            //}
            ?>
        </div>
    </div>
</div>
<!-- Page Contact End -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Fonction AJAX pour supprimer un contact
    function supprimerContact(id) {
        if (confirm("Voulez-vous vraiment supprimer ce contact ?")) {
            $.ajax({
                url: 'supprimer_contact.php',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    console.log(response);
                    location.reload(); // Recharger la page après suppression
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    }
</script>

<?php
include("../pagesParametres/footer.php");
?>
