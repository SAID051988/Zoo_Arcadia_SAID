<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'veterinaire') {
    header('Location: ../inscription/formulaire_connexion_utilisateur.php');
    exit();
}
include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header-page.php");
require_once '../dbconnect.php';
require_once '../config.php';

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
    vs.detail_etat_habitat 
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

<style>.text-primary {
    --bs-text-opacity: 1;
    color: #2EB872 !important;</style>
    <div class="container mt-5">
        <h1 class="mb-4">Gestion des saisies vétérinaires</h1>

        <!-- Bouton pour ajouter une saisie -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter une
            saisie</button>

        <!-- Tableau des saisies -->
        <style>
            .table th,
            .table td {
                font-size: 0.8rem;
                /* Réduit la taille de la police */
            }
        </style>

        <table class="table table-bordered" id="saisieTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Animal</th>
                    <th>Nourriture</th>
                    <th>État animal</th>
                    <th>État habitat</th>
                    <th>à faire</th>
                    <th style=" width: 86px;white-space: nowrap;">Date</th>
                    <th>Détails état animal</th>
                    <th>Détails état habitat</th>
                    <th style=" width: 100px;white-space: nowrap;">Actions</th>
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
                        <td><?= $saisie['action_nourriture'] ?></td>
                        <td><?= $saisie['date_passage'] ?></td>
                        <td><?= $saisie['detail_etat_animal'] ?></td>
                        <td><?= $saisie['detail_etat_habitat'] ?></td>
                        <!-- <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal<?= $saisie['id_saisie'] ?>"><i
                                    class="fas fa-edit fa-lg"></i></button>
                            <a href="delete_saisie.php?id=<?= $saisie['id_saisie'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Voulez-vous vraiment supprimer cette saisie ?');"><i
                                    class="fas fa-trash-alt fa-lg"></i></a>
                        </td> -->
                        <!-- Bouton pour modifier un habitat -->
                        <td>
                            <a href="javascript:void(0);" class="text-warning edit-btn"
                                data-id="<?= $saisie['id_saisie'] ?>">
                                <i class="fas fa-edit fa-lg"></i>
                            </a>
                            <a href="javascript:void(0);" class="text-danger btn-delete"
                                data-id="<?= $saisie['id_saisie'] ?>">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </a>
                        </td>




                    </tr>



                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <!-- Modal Ajouter -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <form id="addSaisieForm" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Ajouter une nouvelle saisie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <input type="date" class="form-control" name="date_passage" required>
                            </div>
                            <!-- Liste déroulante des animaux -->
                            <div class="col-md-3 mb-3">
                                <label for="id_animal" class="form-label">Animal</label>
                                <select id="id_animal" class="form-select" name="id_animal" required>
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
                                <select id="id_nourriture" class="form-select" name="id_nourriture" required>
                                    <option value="" disabled selected>Choisissez une nourriture</option>
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
                                <input type="text" class="form-control" name="etat_animal" id="etat_animal"
                                    list="etatAnimalList" required>
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
                                <label for="detail_etat_animal" class="form-label">Détails sur l'état de
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
                                <label for="action_nourriture" class="form-label">Action liée à la nourriture</label>
                                <!-- Champ de saisie avec liste de suggestions -->
                                <input type="text" class="form-control" name="action_nourriture" id="action_nourriture"
                                    list="actionNourritureList" required>
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
                                <label for="etat_habitat" class="form-label">État de l'habitat</label>
                                <!-- Champ de saisie avec liste de suggestions -->
                                <input type="text" class="form-control" name="etat_habitat" id="etat_habitat"
                                    list="etatHabitatList">
                                <!-- Liste des suggestions -->
                                <datalist id="etatHabitatList">
                                    <?php foreach ($etatsHabitat as $etat): ?>
                                        <option value="<?= ($etat['etat_habitat']) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>

                            <!-- Détails sur l'état de l'habitat -->
                            <div class="col-md-8 mb-3">
                                <label for="detail_etat_habitat" class="form-label">Détails sur l'état de
                                    l'habitat</label>
                                <textarea class="form-control" name="detail_etat_habitat"></textarea>
                            </div>




                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Modifier -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
        <form id="editForm" action="edit_saisie.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modifier la saisie : <?= $saisie['id_saisie'] ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_saisie" value="<?= $saisie['id_saisie'] ?>">
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
                                    value="<?= $saisie['date_passage'] ?>" required>
                            </div>
                            <!-- Liste déroulante des animaux -->
                            <div class="col-md-3 mb-3">
                                <label for="id_animal_mod" class="form-label">Animal</label>
                                <select id="id_animal_mod" class="form-select" name="id_animal_mod" required>
                                    <option value="" disabled>Choisissez un animal</option>
                                    <?php foreach ($lesAnimaux as $animal): ?>
                                        <option value="<?= $animal['id_animal'] ?>" <?= isset($saisie['id_animal']) && $animal['id_animal'] == $saisie['id_animal'] ? 'selected' : '' ?>>
                                            <?= $animal['nom_animal'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Liste déroulante des nourritures -->
                            <div class="col-md-3 mb-3">
                                <label for="id_nourriture_mod" class="form-label">Nourriture</label>
                                <select id="id_nourriture_mod" class="form-select" name="id_nourriture_mod" required
                                    data-selected="<?= $saisie['id_nourriture'] ?>">
                                    <option value="" disabled>Choisissez une nourriture</option>
                                    <?php foreach ($nourritures as $nourriture): ?>
                                        <option value="<?= $nourriture['id_nourriture'] ?>"
                                            <?= $nourriture['id_nourriture'] == $saisie['id_nourriture'] ? 'selected' : '' ?>>
                                            <?= $nourriture['nom_nourriture'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                            <!-- État de l'animal -->
                            <div class="col-md-3 mb-3">
                                <label for="etat_animal" class="form-label">État de l'animal</label>
                                <input type="text" class="form-control" name="etat_animal" id="etat_animal"
                                    list="etatAnimalList" value="<?= ($saisie['etat_animal']) ?>" required>
                                <datalist id="etatAnimalList">
                                    <?php foreach ($etatAnimaux as $etat): ?>
                                        <option value="<?= ($etat['etat_animal']) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Détails sur l'état de l'animal -->
                            <div class="col-md-8 mb-3">
                                <label for="detail_etat_animal" class="form-label">Détails sur l'état de
                                    l'animal</label>
                                <textarea class="form-control"
                                    name="detail_etat_animal"><?= ($saisie['detail_etat_animal']) ?></textarea>
                            </div>
                            <!-- Action liée à la nourriture -->
                            <div class="col-md-4 mb-3">
                                <label for="action_nourriture_mod" class="form-label">Action liée à la
                                    nourriture</label>
                                <input type="text" class="form-control" name="action_nourriture_mod"
                                    id="action_nourriture_mod" list="actionNourritureList"
                                    value="<?= ($saisie['action_nourriture']) ?>" required>
                                <datalist id="actionNourritureList">
                                    <?php foreach ($actionsNourriture as $action): ?>
                                        <option value="<?= ($action['action_nourriture']) ?>">
                                        </option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row">
                            <!-- État de l'habitat -->
                            <div class="col-md-4 mb-3">
                                <label for="etat_habitat" class="form-label">État de l'habitat</label>
                                <input type="text" class="form-control" name="etat_habitat" id="etat_habitat"
                                    list="etatHabitatList" value="<?= ($saisie['etat_habitat']) ?>">
                                <datalist id="etatHabitatList">
                                    <?php foreach ($etatsHabitat as $etat): ?>
                                        <option value="<?= ($etat['etat_habitat']) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <!-- Détails sur l'état de l'habitat -->
                            <div class="col-md-8 mb-3">
                                <label for="detail_etat_habitat" class="form-label">Détails sur l'état de
                                    l'habitat</label>
                                <textarea class="form-control"
                                    name="detail_etat_habitat"><?= ($saisie['detail_etat_habitat']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" id="submitEditForm" class="btn btn-primary">Enregistrer</button>

                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('id_animal_mod').addEventListener('change', function () {
            const idAnimal = this.value;

            fetch(`get_nourritures.php?id_animal=${idAnimal}`)
                .then(response => response.json())
                .then(data => {
                    const nourritureSelect = document.getElementById('id_nourriture_mod');
                    const currentSelection = nourritureSelect.value; // Conservez la sélection actuelle
                    nourritureSelect.innerHTML = '<option value="" disabled>Choisissez une nourriture</option>';

                    data.forEach(nourriture => {
                        nourritureSelect.innerHTML += `
                    <option value="${nourriture.id_nourriture}" 
                        ${nourriture.id_nourriture == currentSelection ? 'selected' : ''}>
                        ${nourriture.nom_nourriture}
                    </option>`;
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des nourritures :', error));
        });
        ///////////////////

        $(document).ready(function () {
            $('#editModal').on('show.bs.modal', function () {
                const idAnimal = $('#id_animal_mod').val(); // Récupère l'animal sélectionné
                if (idAnimal) {
                    $('#id_animal_mod').trigger('change'); // Simule un changement pour charger les nourritures
                }
            });
        });




        /////////////////////
        document.getElementById("submitEditForm").addEventListener("click", function () {
    const form = document.getElementById("editForm");
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || "Modification enregistrée avec succès !");
                
                // Ferme la modal
                const modalElement = document.querySelector('#editModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();

                // Met à jour la table avec les données reçues
                updateTable(data.updatedRow);
            } else {
                alert(data.message || "Une erreur s'est produite.");
            }
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
        });
});


    </script>

    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const saisieId = this.getAttribute('data-id');

                //const saisieId = event.target.closest('button').dataset.id;
                fetch(`get_saisie_data.php?id=${saisieId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Remplir les champs du formulaire modal avec les données récupérées
                        console.log(data);  // Vérifie la structure des données
                        if (data.status === 'success') {
                            // Remplir les champs du formulaire modal avec les données récupérées
                            document.querySelector('#editModal input[name="id_saisie"]').value = data.data.id_saisie;
                            document.querySelector('#editModal input[name="date_passage"]').value = data.data.date_passage;
                            document.querySelector('#editModal select[name="id_animal_mod"]').value = data.data.id_animal;
                            document.querySelector('#editModal select[name="id_nourriture_mod"]').value = data.data.id_nourriture;
                            document.querySelector('#editModal input[name="etat_animal"]').value = data.data.etat_animal;
                            document.querySelector('#editModal textarea[name="detail_etat_animal"]').value = data.data.detail_etat_animal;
                            document.querySelector('#editModal input[name="action_nourriture_mod"]').value = data.data.action_nourriture;
                            document.querySelector('#editModal input[name="etat_habitat"]').value = data.data.etat_habitat;
                            document.querySelector('#editModal textarea[name="detail_etat_habitat"]').value = data.data.detail_etat_habitat;

                            // Afficher la modal
                            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                            editModal.show();
                        } else {
                            console.error(data.message);
                        }
                    })
                    .catch(error => console.error('Erreur lors du chargement des données:', error));
            });
        });

        // Bouton Supprimer
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (event) => {
                const saisieId = event.target.closest('button').dataset.id;
                if (confirm('Voulez-vous vraiment supprimer cette saisie ?')) {
                    fetch(`delete_saisie.php?id=${saisieId}`, { method: 'GET' })
                        .then(response => response.text())
                        .then(result => {
                            alert(result);
                            location.reload(); // Recharger la page pour afficher les changements
                        })
                        .catch(error => console.error('Erreur lors de la suppression:', error));
                }
            });
        });


    </script>






    <script>
        $(document).ready(function () {
            // Écouter le changement de la liste des animaux
            $('#id_animal').change(function () {
                const animalId = $(this).val();

                // Vérifier qu'un animal est sélectionné
                if (animalId) {
                    $.ajax({
                        url: 'get_nourritures.php', // Fichier PHP qui retourne les nourritures
                        type: 'GET',
                        data: { id_animal: animalId },
                        dataType: 'json',
                        success: function (data) {
                            // Vider la liste des nourritures
                            $('#id_nourriture').empty();

                            // Ajouter une option par défaut
                            $('#id_nourriture').append('<option value="" disabled selected>Choisissez une nourriture</option>');

                            // Ajouter les options retournées
                            $.each(data, function (index, item) {
                                $('#id_nourriture').append(
                                    $('<option>', {
                                        value: item.id_nourriture,
                                        text: item.nom_nourriture
                                    })
                                );
                            });
                        },
                        error: function () {
                            alert('Erreur lors de la récupération des nourritures.');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // ID de la nourriture sélectionnée par défaut
            const selectedNourriture = $('#id_nourriture_mod').data('selected');

            // Écouter le changement de la liste des animaux
            $('#id_animal_mod').change(function () {
                const animalId = $(this).val();

                // Vérifier qu'un animal est sélectionné
                if (animalId) {
                    $.ajax({
                        url: 'get_nourritures.php', // Fichier PHP qui retourne les nourritures
                        type: 'GET',
                        data: { id_animal: animalId },
                        dataType: 'json',
                        success: function (data) {
                            // Vider la liste des nourritures
                            $('#id_nourriture_mod').empty();

                            // Ajouter une option par défaut
                            $('#id_nourriture_mod').append('<option value="" disabled selected>Choisissez une nourriture</option>');

                            // Ajouter les options retournées
                            $.each(data, function (index, item) {
                                const selected = item.id_nourriture == selectedNourriture ? 'selected' : '';
                                $('#id_nourriture_mod').append(
                                    $('<option>', {
                                        value: item.id_nourriture,
                                        text: item.nom_nourriture,
                                        selected: selected
                                    })
                                );
                            });
                        },
                        error: function () {
                            alert('Erreur lors de la récupération des nourritures.');
                        }
                    });
                }
            });
        });

    </script>
    <script>
        // Capture la soumission du formulaire
        document.getElementById('addSaisieForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Récupération des données du formulaire
            const formData = new FormData(this);

            // Envoi via AJAX
            fetch('add_saisie.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Succès
                        alert(data.message); // Ou affichez un message de succès dans la modal
                        // Rafraîchir les données de la table sans recharger la page
                        $('#addModal').modal('hide');
                        // Appeler une fonction pour recharger la table, exemple :
                        loadSaisieTable();
                    } else {
                        // Échec
                        alert(data.message); // Ou affichez un message d'erreur dans la modal
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Une erreur est survenue.");
                });
        });

        // Fonction pour recharger la table (à implémenter)
        function loadSaisieTable() {
            // Exemple : utiliser AJAX pour recharger les données de la table
            // fetch('get_saisies.php').then(...);
        }
    </script>

<script>
    function updateTable(updatedRow) {
    // Trouvez la ligne correspondante dans la table (en utilisant l'attribut data-id)
    const row = document.querySelector(`#saisieTable tr[data-id="${updatedRow.id_saisie}"]`);
    if (row) {
        // Mettre à jour chaque cellule en fonction des nouvelles données
        row.children[1].textContent = updatedRow.nom_animal;
        row.children[2].textContent = updatedRow.nom_nourriture;
        row.children[3].textContent = updatedRow.etat_animal;
        row.children[4].textContent = updatedRow.etat_habitat;
        row.children[5].textContent = updatedRow.action_nourriture;
        row.children[6].textContent = updatedRow.date_passage;
        row.children[7].textContent = updatedRow.detail_etat_animal;
        row.children[8].textContent = updatedRow.detail_etat_habitat;

        // Affiche un message dans la console pour vérifier
        console.log(`Ligne mise à jour pour l'ID ${updatedRow.id_saisie}`);
    } else {
        console.error("Ligne introuvable dans la table pour l'ID :", updatedRow.id_saisie);
    }
}


</script>



<?php
include("../pagesParametres/footer.php");
?>