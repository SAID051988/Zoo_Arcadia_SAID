<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'veterinaire') {
    require_once '../dbconnect.php';
require_once '../config.php';
}else if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrateur'){
    include("../espace_administrateur/espace_administrateur.php");
}else{
    // header('Location: ../inscription/formulaire_connexion_utilisateur.php');
    // exit();
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

<style>
    .text-primary {
        --bs-text-opacity: 1;
        color: #2EB872 !important;
    }
</style>

<div class="container mt-5">

    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h1 class="mb-5">Gestion des comptes rendus</h1>
    </div>


    <!-- Bouton pour ajouter une saisie -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter un compte
        rendu</button>

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
            <tr style="background-color: #555555; color: white;">
                <th style="font-weight: bold;">ID</th>
                <th style="font-weight: bold;">Animal</th>
                <th style="font-weight: bold;">Nourriture</th>
                <th style="font-weight: bold;">État animal</th>
                <th style="font-weight: bold;">État habitat</th>
                <th style="font-weight: bold;">à faire</th>
                <th style=" width: 86px;white-space: nowrap;font-weight: bold;">Date</th>
                <th style="font-weight: bold;">Détails état animal</th>
                <th style="font-weight: bold;">Détails état habitat</th>
                <th style=" width: 100px;white-space: nowrap;font-weight: bold;">Actions</th>
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
                        <a href="javascript:void(0);" class="text-warning edit-btn" data-bs-toggle="modal"
                            data-bs-target="#editModal<?= $saisie['id_saisie'] ?>" data-id="<?= $saisie['id_saisie'] ?>">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>
                        <a href="javascript:void(0);" class="text-danger btn-delete" data-id="<?= $saisie['id_saisie'] ?>">
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
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $i ?>&search=<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                        data-page="<?= $i ?>" onclick="loadPage(event, <?= $i ?>)">
                        <?= $i ?>
                    </a>
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
                    <h5 class="modal-title" id="addModalLabel">Ajouter un compte rendu</h5>
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
<div class="modal fade" id="editModal<?= $saisie['id_saisie'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="edit_saisie.php">
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






<?php
//include("../pagesParametres/footer.php");
?>