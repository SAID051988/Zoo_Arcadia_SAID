<?php

// include("../pagesParametres/beforeHeader.php");
// include("../pagesParametres/navbar.php");
// include("../pagesParametres/header.php");
require_once '../dbconnect.php';
require_once '../config.php';

$limit = 5; // Nombre d'éléments par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Requête pour récupérer les données avec filtre et pagination
$query = $pdo->prepare("SELECT * FROM services WHERE nom_service LIKE :searchTerm LIMIT $start, $limit");
$query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$query->execute();
$donnees = $query->fetchAll();


// Calcul du nombre total d'éléments pour la pagination
$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM services WHERE nom_service LIKE :searchTerm");
$totalQuery->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$totalQuery->execute();
$total = $totalQuery->fetchColumn();
$pages = ceil($total / $limit);

?>
<div class="container mt-5">
  
  <div class="text-center wow fadeInUp" data-wow-delay="0.1s">               
                <h1 class="mb-5">Gestion des services</h1>
            </div>

<div class="d-flex justify-content-between mb-3">

  <?php
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "Administrateur") {
  ?>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">Ajouter un élément</button>
  <?php } ?>
  <div><?= $total ?> élément(s) trouvé(s)</div>
    <form class="d-flex">
      <input class="form-control me-2" name="search" type="search" placeholder="Rechercher..." 
        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
        onchange="window.location.href='?search=' + encodeURIComponent(this.value)">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>

  

  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Descriptions</th>
        <?php
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "Administrateur") {
  ?>
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
          

          <td>
            <a href="#" class="text-warning edit-btn" data-id="<?= $data['id_service'] ?>">
              <i class="fas fa-edit"></i>
            </a>
            <a href="#" class="text-danger delete-btn" data-id="<?= $data['id_service'] ?>">
              <i class="fas fa-trash"></i>
            </a>
          </td>
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <li class="page-item <?= $i == $page ? 'active' : '' ?>">
        <a 
          class="page-link" 
          href="?page=<?= $i ?>&search=<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
          data-page="<?= $i ?>"
          onclick="loadPage(event, <?= $i ?>)">
          <?= $i ?>
        </a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>


<!-- Modal Ajouter un élément -->
<div class="modal fade" id="addDataModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">

    <h5 class="modal-title">Ajouter un élément</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

      </div>
      <div class="modal-body">
        <form id="addDataForm">
          <div class="mb-3">
            <label for="dataName" class="form-label">Nom</label>
            <input type="text" class="form-control" id="dataName" name="dataName" required>
          </div>
          <div class="mb-3">
            <label for="dataInfo" class="form-label">Info</label>
            <textarea class="form-control" id="dataInfo" name="dataInfo" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
// include("../pagesParametres/footer.php");
?>