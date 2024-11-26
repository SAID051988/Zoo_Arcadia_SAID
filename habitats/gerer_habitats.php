<?php 
 include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");
require_once '../dbconnect.php';
require_once '../config.php';

$limit = 5; // Nombre d'habitats par page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Requête pour récupérer les habitats avec le filtre de recherche et pagination
$query = $pdo->prepare("SELECT * FROM habitats WHERE nom_habitat LIKE :searchTerm LIMIT :start, :limit");
$query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$query->bindParam(':start', $start, PDO::PARAM_INT);
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->execute();
$habitats = $query->fetchAll();

// Calcul du nombre total d'habitats pour la pagination
$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM habitats WHERE nom_habitat LIKE :searchTerm");
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
      <input class="form-control me-2" name="search" type="search" placeholder="Rechercher un habitat..."
        aria-label="Search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
        onchange="window.location.href='?search=' + encodeURIComponent(this.value)">
      <button type="button" class="btn btn-primary">
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>

  <div><?= $total ?> habitat(s) trouvé(s)</div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="habitatTable">
      <?php foreach ($habitats as $habitat): ?>
        <tr>
          <td><?= $habitat['id_habitat'] ?></td>
          <td><?= htmlspecialchars($habitat['nom_habitat']) ?></td>
          <td><?= htmlspecialchars($habitat['description_habitat']) ?></td>
          <td>
            <img src="<?= htmlspecialchars(BASE_IMAGE_PATH . $habitat['image_path']) ?>" alt="Image" class="table-image"
              onclick="openModal('<?= htmlspecialchars(BASE_IMAGE_PATH . $habitat['image_path']) ?>')">
          </td>
          <td>
            <a href="javascript:void(0);" class="text-warning edit-btn" data-id="<?= $habitat['id_habitat'] ?>"><i
                class="fas fa-edit fa-lg"></i></a>

            <a href="javascript:void(0);" 
               class="text-danger btn-delete" 
               data-id="<?= $habitat['id_habitat'] ?>">
              <i class="fas fa-trash-alt fa-lg"></i>
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

<!-- <div class="modal fade" id="animalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Aperçu de l'image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" alt="Image agrandie" style="max-width: 100%; max-height: 100%;">
      </div>
    </div>
  </div>
</div> -->
<!-- Modal pour afficher l'image en grand -->
<div class="modal fade" id="habitatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Aperçu de l'image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <img id="modalImage" class="img-fluid" src="" alt="Image agrandie" style="max-width: 100%; max-height: 100%;">
        </div>
      </div>
    </div>
  </div>
  <!-- Modal pour modifier un habitat -->
  <div class="modal fade" id="editHabitatModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modifier un Animal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editAnimalForm" enctype="multipart/form-data">
          <input type="hidden" id="editAnimalId" name="id_animal">

          <!-- Première ligne avec deux colonnes -->
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editNomAnimal" class="form-label">Nom</label>
                <input type="text" class="form-control" id="editNomAnimal" name="nomAnimal" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editHabitatAnimal" class="form-label">Habitat</label>
                <select id="editHabitatAnimal" name="habitat" class="form-select" required>
                  <?php foreach ($habitats as $habitat): ?>
                    <option value="<?= htmlspecialchars($habitat['id_habitat']) ?>">
                      <?= htmlspecialchars($habitat['nom_habitat']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <!-- Deuxième ligne avec deux colonnes -->
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editRaceAnimal" class="form-label">Race</label>
                <select id="editRaceAnimal" name="race" class="form-select" required>
                  <?php foreach ($races as $race): ?>
                    <option value="<?= htmlspecialchars($race['id_race']) ?>">
                      <?= htmlspecialchars($race['nom_race']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editStatusAnimal" class="form-label">Statut</label>
                <input type="text" class="form-control" id="editStatusAnimal" name="status" required>
              </div>
            </div>
          </div>

          <!-- Ligne pour le téléchargement de l'image -->
          <div class="mb-3">
            <label for="editImageUpload" class="form-label">Télécharger une nouvelle image</label>
            <input type="file" class="form-control" id="editImageUpload" name="image" accept=".jpg,.jpeg,.png,.gif">
          </div>

          <!-- Bouton pour soumettre le formulaire -->
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Soumettre le formulaire d'ajout d'habitat via AJAX
  document.getElementById('addHabitatForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Empêche la soumission classique du formulaire

    const formData = new FormData(this);

    fetch('add_habitat.php', {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          // Fermer le modal et rafraîchir la liste des habitats
          document.getElementById('addHabitatForm').reset();
          location.reload();
        } else {
          alert(data.message);
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
        alert("Une erreur s'est produite lors de l'ajout de l'habitat.");
      });
  });
</script>

<script>
  // Modifier un habitat
  document.querySelectorAll('.edit-habitat-btn').forEach(button => {
    button.addEventListener('click', function () {
      const habitatId = this.getAttribute('data-id');

      // Récupérer les données de l'habitat via AJAX
      fetch(`get_habitat.php?id=${habitatId}`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('editHabitatId').value = data.id_habitat;
          document.getElementById('editNomHabitat').value = data.nom_habitat;
          document.getElementById('editDescriptionHabitat').value = data.description_habitat;

          // Afficher la modale de modification
          var editModal = new bootstrap.Modal(document.getElementById('editHabitatModal'), {});
          editModal.show();
        })
        .catch(error => console.error('Erreur:', error));
    });
  });

  // Soumettre le formulaire de modification d'habitat via AJAX
  document.getElementById('editHabitatForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('edit_habitat.php', {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          location.reload();
        } else {
          alert(data.message);
        }
      })
      .catch(error => console.error('Erreur:', error));
  });
</script>

<script>
  // Supprimer un habitat
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-delete-habitat').forEach(button => {
      button.addEventListener('click', function () {
        const idHabitat = this.getAttribute('data-id');
        if (confirm('Êtes-vous sûr de vouloir supprimer cet habitat ?')) {
          fetch(`delete_habitat.php?id=${idHabitat}`, { method: 'GET' })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Habitat supprimé avec succès.');
                document.querySelector(`#habitat-row-${idHabitat}`).remove();
              } else {
                alert('Erreur lors de la suppression de l\'habitat.');
              }
            })
            .catch(err => console.error('Erreur AJAX:', err));
        }
      });
    });
  });
</script>

<script>
  // Afficher les détails d'un habitat
  function showHabitatDetails(id) {
    fetch(`details_habitat.php?id=${id}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          document.getElementById('detailsNomHabitat').textContent = data.habitat.nom_habitat;
          document.getElementById('detailsDescriptionHabitat').textContent = data.habitat.description_habitat;

          // Afficher la modale
          var detailsModal = new bootstrap.Modal(document.getElementById('detailsHabitatModal'));
          detailsModal.show();
        } else {
          alert("Erreur : " + data.message);
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
        alert("Une erreur s'est produite lors du chargement des détails.");
      });
  }
</script>

</div>



<script>
    // Fonction pour afficher l'image en grand dans le modal
    function openModal(imagePath) {
      document.getElementById("modalImage").src = imagePath;
      var myModal = new bootstrap.Modal(document.getElementById('habitatModal'), {});
      myModal.show();
    }

    // Mettre à jour le chemin de l'image lors de la sélection d'un fichier
    document.getElementById('imageUpload').addEventListener('change', function () {
      if (this.files.length > 0) {
        let fileName = this.files[0].name.replace(/\s+/g, '_'); // Remplace les espaces par des underscores
        document.getElementById('imagePath').value = "img/animaux/" + fileName; // Affiche le chemin modifié
      }
    });

    // Soumettre le formulaire via AJAX
    document.getElementById('addAnimalForm').addEventListener('submit', function (event) {
      event.preventDefault(); // Empêche la soumission classique du formulaire

      const formData = new FormData(this);

      // Récupérer et renommer le fichier image
      const imageInput = document.getElementById('imageUpload');
      if (imageInput.files.length > 0) {
        let imageFile = imageInput.files[0];
        let modifiedFileName = imageFile.name.replace(/\s+/g, '_'); // Remplace les espaces par des underscores

        // Créer un nouveau fichier avec le nom modifié
        let modifiedFile = new File([imageFile], modifiedFileName, { type: imageFile.type });

        // Mettre à jour FormData avec le fichier renommé
        formData.set('image', modifiedFile);
      }

      // Envoyer le formulaire via fetch
      fetch('add_animal.php', {
        method: 'POST',
        body: formData
      })
        .then(response => {
          // Vérifiez si le type de contenu est JSON
          const contentType = response.headers.get('content-type');
          if (contentType && contentType.includes('application/json')) {
            return response.json();
          } else {
            throw new Error("Réponse non-JSON reçue du serveur");
          }
        })
        .then(data => {
          if (data.success) {
            alert(data.message);
            // Fermer le modal ou rafraîchir la liste d'animaux
          } else {
            alert(data.message);
          }
        })
        .catch(error => {
          console.error('Erreur:', error);
          alert("Une erreur s'est produite lors de l'ajout de l'animal.");
        });
    });

  </script>

  <!-- Modifier un image -->
  <script>
    document.querySelectorAll('.edit-btn').forEach(button => {
      button.addEventListener('click', function () {
        const animalId = this.getAttribute('data-id');

        // Requête pour récupérer les données de l'animal en AJAX
        fetch(`get_animal.php?id=${animalId}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('editAnimalId').value = data.id_animal;
            document.getElementById('editNomAnimal').value = data.nom_animal;
            document.getElementById('editHabitatAnimal').value = data.id_habitat;
            document.getElementById('editRaceAnimal').value = data.id_race;
            document.getElementById('editStatusAnimal').value = data.status_animal;

            // Afficher la modale de modification
            var editModal = new bootstrap.Modal(document.getElementById('editHabitatModal'), {});
            editModal.show();
          })
          .catch(error => console.error('Erreur:', error));
      });
    });

    document.getElementById('editAnimalForm').addEventListener('submit', function (event) {
      event.preventDefault();

      const formData = new FormData(this);

      fetch('edit_animal.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert(data.message);
            location.reload(); // Recharge la page pour voir les modifications
          } else {
            alert(data.message);
          }
        })
        .catch(error => console.error('Erreur:', error));
    });
  </script>
  <script>
    function showAnimalDetails(id) {
      fetch(`details_animal.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Remplir les champs de la modale avec les données reçues
            document.getElementById('detailsNomAnimal').textContent = data.animal.nom_animal;
            document.getElementById('detailsStatusAnimal').textContent = data.animal.status_animal;
            document.getElementById('detailsHabitat').textContent = data.animal.habitat;
            document.getElementById('detailsRace').textContent = data.animal.race;

            // Afficher la modale
            var detailsModal = new bootstrap.Modal(document.getElementById('detailsAnimalModal'));
            detailsModal.show();
          } else {
            alert("Erreur : " + data.message);
          }
        })
        .catch(error => {
          console.error('Erreur:', error);
          alert("Une erreur s'est produite lors du chargement des détails.");
        });
    }
  </script>
  <script>
document.addEventListener('DOMContentLoaded', () => {
  // Gestion du clic sur le bouton supprimer
  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function () {
      const idAnimal = this.getAttribute('data-id');
      if (confirm('Êtes-vous sûr de vouloir supprimer cet animal ?')) {
        fetch(`supprimer_animal.php?id=${idAnimal}`, { method: 'GET' })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Animal supprimé avec succès.');
              // Actualiser la table dynamiquement
              document.querySelector(`#animal-row-${idAnimal}`).remove();
            } else {
              alert('Erreur lors de la suppression de l\'animal.');
            }
          })
          .catch(err => console.error('Erreur AJAX:', err));
      }
    });
  });
});


  </script>

</div>


<?php
include("../pagesParametres/footer.php");
?>