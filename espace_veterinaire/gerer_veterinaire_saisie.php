<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'veterinaire') {
    require_once '../dbconnect.php';
    require_once '../config.php';
} else if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrateur') {
    include("../espace_administrateur/espace_administrateur.php");
} else {
    header('Location: ../inscription/formulaire_connexion_utilisateur.php');
    exit();
}
// include("../pagesParametres/beforeHeader.php");
// include("../pagesParametres/navbar.php");
// include("../pagesParametres/header-page.php");



// Pagination
$limit = 6;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Récupération des données
$sql = "SELECT DISTINCT 
    vs.id_saisie, 
    a.nom_animal, 
    n.nom as nom_nourriture, 
    vs.etat_animal,
    vs.etat_habitat,
    vs.action_nourriture, 
    vs.date_passage, 
    vs.detail_etat_animal,
    vs.detail_etat_habitat,vs.id_animal ,vs.id_nourriture
FROM veterinaire_saisie vs, animal a, animal_nourriture an, nourriture n
where vs.id_animal = a.id_animal
and vs.id_nourriture = an.id_nourriture
and n.id_nourriture = an.id_nourriture order by  vs.date_passage
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$saisies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compte total des enregistrements
$totalStmt = $pdo->query("SELECT COUNT(*) FROM veterinaire_saisie");
$totalRows = $totalStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);
?>
<!-- CSS DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<style>
    .text-primary {
        --bs-text-opacity: 1;
        color: #2EB872 !important;
    }
</style>

<section class="intro">
    <div class="mask d-flex align-items-center h-100 gradient-custom">
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-12 col-xl-9">
                    <div class="card  shadow-lg">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                <h1 class="mb-5">Gestion des comptes rendus</h1>
                            </div>


                            <!-- Bouton pour ajouter une saisie -->
                            <div class="d-flex justify-content-between mb-3">
                                <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Ajouter un compte
                                    rendu</button>

                            </div>








                            <table class="table table-bordered rounded" id="saisieTable" class="cell-border"
                                cellspacing="0" style="border-collapse: collapse">
                                <thead class="table-light">
                                    <tr style="background-color: #555555; color: white;">
                                        <th>ID</th>
                                        <th>Animal</th>
                                        <th>Nourriture</th>
                                        <th>État animal</th>
                                        <th>État habitat</th>
                                        <th>à faire</th>
                                        <th>Date</th>
                                        <th>Détails état animal</th>
                                        <th>Détails état habitat</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($saisies as $saisie): ?>
                                        <tr data-id="<?= $saisie['id_saisie'] ?>">

                                            <td><?= $saisie['id_saisie'] ?></td>
                                            <td><?= $saisie['nom_animal'] ?></td>
                                            <td><?= $saisie['nom_nourriture'] ?></td>
                                            <td><?= $saisie['etat_animal'] ?></td>
                                            <td><?= $saisie['etat_habitat'] ?></td>
                                            <td style='width: 40px;'><?= $saisie['action_nourriture'] ?></td>
                                            <td style='white-space: nowrap;'><?= $saisie['date_passage'] ?></td>
                                            <td><?= $saisie['detail_etat_animal'] ?></td>
                                            <td><?= $saisie['detail_etat_habitat'] ?></td>
                                           
                                            <!-- Bouton pour modifier un habitat -->
                                            <td  style='white-space: nowrap;'>
                                                <!-- Exemple de bouton dans le tableau -->
                                                <button type="button" class="btn btn-outline-primary edit-btn"
                                                    data-id="<?= $saisie['id_saisie'] ?>"
                                                    data-date-passage="<?= $saisie['date_passage'] ?>"
                                                    data-id-animal="<?= $saisie['id_animal'] ?>"
                                                    data-id-nourriture="<?= $saisie['id_nourriture'] ?>"
                                                    data-etat-animal="<?= $saisie['etat_animal'] ?>"
                                                    data-detail-etat-animal="<?= $saisie['detail_etat_animal'] ?>"
                                                    data-action-nourriture="<?= $saisie['action_nourriture'] ?>"
                                                    data-etat-habitat="<?= $saisie['etat_habitat'] ?>"
                                                    data-detail-etat-habitat="<?= $saisie['detail_etat_habitat'] ?>">
                                                    <i class="bi bi-pencil"></i> <!-- Icône de crayon Bootstrap -->
                                                </button>
                                                <!-- Bouton pour suppression -->
                                                <a href="javascript:void(0);" class="btn btn-outline-danger btn-delete"
                                                    data-id="<?= $saisie['id_saisie'] ?>">
                                                    <i class="fas fa-trash-alt"></i> <!-- Icône de suppression -->
                                                </a>
                                            </td>



                                        </tr>



                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                           
                        </div>

                        <!-- Modal Ajouter -->
                        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <form id="addSaisieForm" method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Ajouter un compte rendu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Première colonne -->

                                                <?php
                                                require_once '../dbconnect.php';

                                                // Requête pour récupérer tous les animaux
                                                $query = $pdo->prepare("SELECT id_animal, nom_animal FROM animal");
                                                $query->execute();
                                                $animals = $query->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <!-- Date de passage -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="date_passage" class="form-label">Date de passage</label>
                                                    <input type="date" class="form-control" name="date_passage"
                                                        required>
                                                </div>
                                                <!-- Liste déroulante des animaux -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="id_animal" class="form-label">Animal</label>
                                                    <select id="id_animal" class="form-select" name="id_animal"
                                                        required>
                                                        <option value="" disabled selected>Choisissez un animal</option>
                                                        <?php foreach ($animals as $animal): ?>
                                                            <option value="<?= $animal['id_animal'] ?>">
                                                                <?= $animal['nom_animal'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <!-- Liste déroulante des nourritures -->
                                                <div class="col-md-3  mb-3">
                                                    <label for="id_nourriture" class="form-label">Nourriture</label>
                                                    <select id="id_nourriture" class="form-select" name="id_nourriture"
                                                        required>
                                                        <option value="" disabled selected>Choisissez une nourriture
                                                        </option>
                                                    </select>
                                                </div>
                                                <?php
                                                // Connexion à la base de données
                                                require_once '../dbconnect.php';

                                                // Requête pour récupérer les états d'animaux distincts
                                                $query = $pdo->prepare("SELECT DISTINCT(etat_animal) AS etat_animal FROM veterinaire_saisie");
                                                $query->execute();
                                                $etatAnimaux = $query->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <div class="col-md-3 mb-3">
                                                    <label for="etat_animal" class="form-label">État de l'animal</label>
                                                    <!-- Champ de saisie avec liste de suggestions -->
                                                    <input type="text" class="form-control" name="etat_animal"
                                                        id="etat_animal" list="etatAnimalList" required>
                                                    <!-- Liste des suggestions -->
                                                    <datalist id="etatAnimalList">
                                                        <?php foreach ($etatAnimaux as $etat): ?>
                                                            <option value="<?= ($etat['etat_animal']) ?>"></option>
                                                        <?php endforeach; ?>
                                                    </datalist>
                                                </div>

                                            </div>
                                            <div class="row">

                                                <!-- Détails sur l'état de l'animal -->
                                                <div class="col-md-8  mb-3">
                                                    <label for="detail_etat_animal" class="form-label">Détails sur
                                                        l'état de
                                                        l'animal</label>
                                                    <textarea class="form-control" name="detail_etat_animal"></textarea>
                                                </div>

                                                <?php
                                                // Connexion à la base de données
                                                require_once '../dbconnect.php';

                                                // Requête pour récupérer les actions liées à la nourriture distinctes
                                                $query = $pdo->prepare("SELECT DISTINCT(action_nourriture) AS action_nourriture FROM veterinaire_saisie");
                                                $query->execute();
                                                $actionsNourriture = $query->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <div class="col-md-4 mb-3">
                                                    <label for="action_nourriture" class="form-label">Action liée à la
                                                        nourriture</label>
                                                    <!-- Champ de saisie avec liste de suggestions -->
                                                    <input type="text" class="form-control" name="action_nourriture"
                                                        id="action_nourriture" list="actionNourritureList" required>
                                                    <!-- Liste des suggestions -->
                                                    <datalist id="actionNourritureList">
                                                        <?php foreach ($actionsNourriture as $action): ?>
                                                            <option value="<?= ($action['action_nourriture']) ?>"></option>
                                                        <?php endforeach; ?>
                                                    </datalist>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <?php
                                                // Connexion à la base de données
                                                require_once '../dbconnect.php';

                                                // Requête pour récupérer les états d'habitat distincts
                                                $query = $pdo->prepare("SELECT DISTINCT(etat_habitat) AS etat_habitat FROM veterinaire_saisie");
                                                $query->execute();
                                                $etatsHabitat = $query->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <div class="col-md-4 mb-3">
                                                    <label for="etat_habitat" class="form-label">État de
                                                        l'habitat</label>
                                                    <!-- Champ de saisie avec liste de suggestions -->
                                                    <input type="text" class="form-control" name="etat_habitat"
                                                        id="etat_habitat" list="etatHabitatList">
                                                    <!-- Liste des suggestions -->
                                                    <datalist id="etatHabitatList">
                                                        <?php foreach ($etatsHabitat as $etat): ?>
                                                            <option value="<?= ($etat['etat_habitat']) ?>"></option>
                                                        <?php endforeach; ?>
                                                    </datalist>
                                                </div>

                                                <!-- Détails sur l'état de l'habitat -->
                                                <div class="col-md-8 mb-3">
                                                    <label for="detail_etat_habitat" class="form-label">Détails sur
                                                        l'état de
                                                        l'habitat</label>
                                                    <textarea class="form-control"
                                                        name="detail_etat_habitat"></textarea>
                                                </div>




                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Ajouter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Modal Modifier (unique) -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form method="POST" action="edit_saisie.php">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Modifier la saisie : <span
                                                    id="modalSaisieId"></span></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_saisie" id="id_saisie">
                                            <div class="row">
                                            <?php
                        require_once '../dbconnect.php';

                        // Requête pour récupérer tous les animaux
                        $query = $pdo->prepare("SELECT id_animal, nom_animal FROM animal");
                        $query->execute();
                        $lesAnimaux = $query->fetchAll(PDO::FETCH_ASSOC);

                        ?>
                                                <!-- Date de passage -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="date_passage" class="form-label">Date de passage</label>
                                                    <input type="date" class="form-control" name="date_passage"
                                                        id="date_passage" required>
                                                </div>
                                                <!-- Liste déroulante des animaux -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="id_animal_mod" class="form-label">Animal</label>
                                                    <select id="id_animal_mod" class="form-select" name="id_animal_mod" required>
    <option value="" disabled selected>Choisissez un animal</option>
    <?php foreach ($lesAnimaux as $animal): ?>
        <option value="<?= $animal['id_animal'] ?>" <?= isset($saisie['id_animal']) && $animal['id_animal'] == $saisie['id_animal'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($animal['nom_animal']) ?>
        </option>
    <?php endforeach; ?>
</select>

                                                </div>
                                                <!-- Liste déroulante des nourritures -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="id_nourriture_mod" class="form-label">Nourriture</label>
                                                    <select id="id_nourriture_mod" class="form-select" name="id_nourriture_mod" required>
    <option value="" disabled selected>Choisissez une nourriture</option>
</select>
                                                </div>
                                                <!-- État de l'animal -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="etat_animal" class="form-label">État de l'animal</label>
                                                    <input type="text" class="form-control" name="etat_animal"
                                                        id="etat_animal" list="etatAnimalList" required>
                                                    <datalist id="etatAnimalList">
                                                        <?php foreach ($etatAnimaux as $etat): ?>
                                                            <option value="<?= $etat['etat_animal'] ?>"></option>
                                                        <?php endforeach; ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- Détails sur l'état de l'animal -->
                                                <div class="col-md-8 mb-3">
                                                    <label for="detail_etat_animal" class="form-label">Détails sur
                                                        l'état de l'animal</label>
                                                    <textarea class="form-control" name="detail_etat_animal"
                                                        id="detail_etat_animal"></textarea>
                                                </div>
                                                <!-- Action liée à la nourriture -->
                                                <div class="col-md-4 mb-3">
                                                    <label for="action_nourriture_mod" class="form-label">Action liée à
                                                        la nourriture</label>
                                                    <input type="text" class="form-control" name="action_nourriture_mod"
                                                        id="action_nourriture_mod" list="actionNourritureList" required>
                                                    <datalist id="actionNourritureList">
                                                        <?php foreach ($actionsNourriture as $action): ?>
                                                            <option value="<?= $action['action_nourriture'] ?>"></option>
                                                        <?php endforeach; ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- État de l'habitat -->
                                                <div class="col-md-4 mb-3">
                                                    <label for="etat_habitat" class="form-label">État de
                                                        l'habitat</label>
                                                    <input type="text" class="form-control" name="etat_habitat"
                                                        id="etat_habitat" list="etatHabitatList">
                                                    <datalist id="etatHabitatList">
                                                        <?php foreach ($etatsHabitat as $etat): ?>
                                                            <option value="<?= $etat['etat_habitat'] ?>"></option>
                                                        <?php endforeach; ?>
                                                    </datalist>
                                                </div>
                                                <!-- Détails sur l'état de l'habitat -->
                                                <div class="col-md-8 mb-3">
                                                    <label for="detail_etat_habitat" class="form-label">Détails sur
                                                        l'état de l'habitat</label>
                                                    <textarea class="form-control" name="detail_etat_habitat"
                                                        id="detail_etat_habitat"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

<!-- Modal de confirmation pour la suppression -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger btn-confirm-delete">Supprimer</button>
            </div>
        </div>
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function () {
        $j('#saisieTable').DataTable({
            paging: true,
            searching: true, // Si vous utilisez une barre de recherche personnalisée
            ordering: true,
            pageLength: 4, // Affiche 4 lignes par page
            language: {
                url: "../lib/json/fr-FR.json" // Traduction française
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Récupérer les données de l'attribut data-*
                const idSaisie = this.getAttribute('data-id');
                const datePassage = this.getAttribute('data-date-passage');
                const idAnimal = this.getAttribute('data-id-animal');
                const idNourriture = this.getAttribute('data-id-nourriture');
                const etatAnimal = this.getAttribute('data-etat-animal');
                const detailEtatAnimal = this.getAttribute('data-detail-etat-animal');
                const actionNourriture = this.getAttribute('data-action-nourriture');
                const etatHabitat = this.getAttribute('data-etat-habitat');
                const detailEtatHabitat = this.getAttribute('data-detail-etat-habitat');

                // Mettre à jour le modal avec les données
                document.getElementById('modalSaisieId').textContent = idSaisie;
                document.getElementById('id_saisie').value = idSaisie;
                document.getElementById('date_passage').value = datePassage;
                document.getElementById('id_animal_mod').value = idAnimal;
                document.getElementById('id_nourriture_mod').value = idNourriture;
                document.getElementById('etat_animal').value = etatAnimal;
                document.getElementById('detail_etat_animal').value = detailEtatAnimal;
                document.getElementById('action_nourriture_mod').value = actionNourriture;
                document.getElementById('etat_habitat').value = etatHabitat;
                document.getElementById('detail_etat_habitat').value = detailEtatHabitat;

                // Ouvrir le modal
                editModal.show();
            });
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
            $.ajax({
                url: 'delete_saisie.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    alert('Élément supprimé avec succès.');
                    location.reload();
                },
                error: function () {
                    alert('Erreur lors de la suppression.');
                }
            });
        }
    });
</script>
<script>
    document.getElementById('id_animal_mod').addEventListener('change', function () {
        const animalId = this.value;

        // Vérifiez que l'utilisateur a sélectionné un animal
        if (animalId) {
            fetch(`get_nourritures.php?id_animal=${animalId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la récupération des données');
                    }
                    return response.json();
                })
                .then(data => {
                    const nourritureSelect = document.getElementById('id_nourriture_mod');
                    nourritureSelect.innerHTML = '<option value="" disabled selected>Choisissez une nourriture</option>';

                    // Remplir le deuxième <select> avec les données récupérées
                    data.forEach(nourriture => {
                        const option = document.createElement('option');
                        option.value = nourriture.id_nourriture;
                        option.textContent = nourriture.nom_nourriture;
                        nourritureSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }
    });
</script>
<?php
include("../pagesParametres/footer.php");
?>