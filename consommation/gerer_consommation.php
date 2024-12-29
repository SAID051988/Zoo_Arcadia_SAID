<?php
/*include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header-page.php");*/
require_once '../dbconnect.php';
require_once '../config.php';

$limit = 5; // Nombre de consommations par page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Requête pour récupérer les consommations avec le filtre de recherche et pagination
$query = $pdo->prepare("SELECT c.*, a.nom_animal AS nom_animal, n.nom AS nom_nourriture
                        FROM consommation c
                        JOIN animal a ON c.id_animal = a.id_animal
                        JOIN nourriture n ON c.id_nourriture = n.id_nourriture
                        WHERE a.nom_animal LIKE :searchTerm OR n.nom LIKE :searchTerm
                        ");

$query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$query->execute();
$consommations = $query->fetchAll();

// Calcul du nombre total de consommations pour la pagination
$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM consommation c
                             JOIN animal a ON c.id_animal = a.id_animal
                             JOIN nourriture n ON c.id_nourriture = n.id_nourriture
                             WHERE a.nom LIKE :searchTerm OR n.nom LIKE :searchTerm");
$totalQuery->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$totalQuery->execute();
$total = $totalQuery->fetchColumn();
$pages = ceil($total / $limit);
?>

<style>
  .table-image {
    width: 30px;
    height: 30px;
    object-fit: cover;
    cursor: pointer;
  }

  #searchInput {
    width: 300px;
  }

  #resultCount {
    margin-top: 10px;
    font-weight: bold;
  }
</style>

<div class="container mt-5">
  <div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHabitatModal">Ajouter un Habitat</button>
    <form class="d-flex">
      <input class="form-control me-2" name="search" type="search" placeholder="Rechercher une consommation..."
        aria-label="Search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
        onchange="window.location.href='?search=' + encodeURIComponent(this.value)">
      <button type="button" class="btn btn-primary">
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>

  <div><?= $total ?> consommation(s) trouvée(s)</div>

  <table class="table table-striped">
    <thead>
    <tr>
      <th>ID Consommation</th>
      <th>Animal</th>
      <th>Nourriture</th>
      <th>Date</th>
      <th>Heure</th>
      <th>Grammage</th>
      <th>Quantité</th>
    </tr>
    </thead>
    <tbody id="habitatTable">
    <?php foreach ($consommations as $consommation): ?>
      <tr>
        <td><?= $consommation['id_consommation'] ?></td>
        <td><?= $consommation['nom_animal'] ?></td>
        <td><?= $consommation['nom_nourriture'] ?></td>
        <td><?= $consommation['date'] ?></td>
        <td><?= $consommation['heure'] ?></td>
        <td><?= $consommation['grammage'] ?></td>
        <td><?= $consommation['quantite'] ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <nav>
    <ul class="pagination">
      <?php for ($i = 1; $i <= $pages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link"
            href="?page=<?= $i ?>&search=<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>

  <!-- Modal pour ajouter un habitat -->
  <div class="modal fade" id="addHabitatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajouter un Habitat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="addHabitatForm" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nomHabitat" class="form-label">Nom</label>
              <input type="text" class="form-control" id="nomHabitat" name="nomHabitat" required />
            </div>
            <div class="mb-3">
              <label for="descriptionHabitat" class="form-label">Description</label>
              <textarea class="form-control" id="descriptionHabitat" name="descriptionHabitat" required></textarea>
            </div>
            <div class="mb-3">
              <label for="imageUpload" class="form-label">Télécharger l'image</label>
              <input type="file" class="form-control" id="imageUpload" name="image" accept=".jpg,.jpeg,.png,.gif" />
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include("../pagesParametres/footer.php");
?>
