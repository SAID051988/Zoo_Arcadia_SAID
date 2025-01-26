<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once '../dbconnect.php';
require_once '../config.php';

$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Récupération des données
$sql = "SELECT * FROM services WHERE nom_service LIKE :searchTerm LIMIT :start, :limit";
$query = $pdo->prepare($sql);
$query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$query->bindParam(':start', $start, PDO::PARAM_INT);
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->execute();
$donnees = $query->fetchAll();

$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM services WHERE nom_service LIKE :searchTerm");
$totalQuery->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$totalQuery->execute();
$total = $totalQuery->fetchColumn();
$pages = ceil($total / $limit);
?>


<section class="intro">
  <div class="mask d-flex align-items-center h-100 gradient-custom">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-12 col-xl-9">
          <div class="card  shadow-lg">
            <div class="card-body p-4 p-md-5">
              <h2 class="text-center text-primary">Gestion des services</h2>

              <div class="d-flex justify-content-between mb-3">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "employe") { ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                    Ajouter un élément
                  </button>
                <?php } ?>
                <form class="d-flex ms-auto" method="GET" action="">
  <input class="form-control" name="search" type="search" placeholder="Rechercher..."
    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
  <button type="submit" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button>
</form>
              </div>

              <div><?= $total ?> élément(s) trouvé(s)</div>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Descriptions</th>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "administrateur") { ?>
                      <th>Actions</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
    <?php foreach ($donnees as $data): ?>
        <tr>
            <td><?= htmlspecialchars($data['id_service']) ?></td>
            <td><?= htmlspecialchars($data['nom_service']) ?></td>
            <td><?= htmlspecialchars($data['description_service']) ?></td>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "administrateur") { ?>
                <td>
                    <a href="javascript:void(0);" class="text-warning edit-btn" data-bs-toggle="modal"
                       data-bs-target="#editModal<?= $data['id_service'] ?>">
                        <i class="fas fa-edit fa-lg"></i>
                    </a>
                </td>
            <?php } ?>
        </tr>

        <!-- Modal Modifier -->
        <div class="modal fade" id="editModal<?= $data['id_service'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="edit_service.php">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Modifier le service : <?= htmlspecialchars($data['nom_service']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_service" value="<?= $data['id_service'] ?>">
                            <div class="mb-3">
                                <label for="nom_service_<?= $data['id_service'] ?>" class="form-label">Nom du service</label>
                                <input type="text" class="form-control" id="nom_service_<?= $data['id_service'] ?>" name="nom_service"
                                       value="<?= htmlspecialchars($data['nom_service']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description_service_<?= $data['id_service'] ?>" class="form-label">Description</label>
                                <textarea class="form-control" id="description_service_<?= $data['id_service'] ?>" name="description_service" rows="3" required><?= htmlspecialchars($data['description_service']) ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</tbody>

              </table>

              

              <!-- Pagination -->
              <nav>
                <ul class="pagination">
                  <?php for ($i = 1; $i <= $pages; $i++): ?>
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
          </div>
        </div>
      </div>
    </div>
</section>




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