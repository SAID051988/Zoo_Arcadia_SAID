<?php

include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");
require_once '../dbconnect.php';
require_once '../config.php';

?>

<!-- Début de la fenêtre modale de la vidéo -->
<div
  class="modal modal-video fade"
  id="videoModal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Vidéo Youtube</h3>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Fermer"
        ></button>
      </div>
      <div class="modal-body">
        <!-- Rapport 16:9 -->
        <div class="ratio ratio-16x9">
          <iframe
            class="embed-responsive-item"
            src=""
            id="video"
            allowfullscreen
            allowscriptaccess="always"
            allow="autoplay"
          ></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Fin de la fenêtre modale de la vidéo -->


<!-- Fin de la section "À propos" -->




      <!-- Exemples d'animaux avec descriptions et images -->
<!-- Début de la section "Animaux" -->
 <?php
 // Requête pour récupérer les animaux avec leurs habitats et races
 $query = "
 SELECT a.nom_animal, a.status_animal, a.image_path, h.nom_habitat, r.nom_race
 FROM animal a
 LEFT JOIN habitats h ON a.id_habitat = h.id_habitat
 LEFT JOIN races r ON a.id_race = r.id_race
";
$stmt = $pdo->query($query);
$animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?>
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 mb-5 align-items-end wow fadeInUp" data-wow-delay="0.1s">
            
                <p><span class="text-primary me-2">#</span>Nos animaux</p>
                <h1 class="display-5 mb-0">
                    Liste de nos incroyables animaux
                </h1>
           
           
        </div>
        <div class="row g-4">
            <?php foreach ($animaux as $animal): ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row g-4">
                        <div class="col-12">
                            <a class="animal-item" href="<?= htmlspecialchars($animal['image_path']) ?>" data-lightbox="animal">
                                <div class="position-relative">
                                <img class="img-fluid" src="<?= htmlspecialchars(BASE_IMAGE_PATH . $animal['image_path']) ?>" alt="<?= htmlspecialchars($animal['nom_animal']) ?>" />
                                <div class="animal-text p-4">
                                        <p class="text-white small text-uppercase mb-0"><?= htmlspecialchars($animal['nom_race']) ?></p>
                                        <h5 class="text-white mb-0"><?= htmlspecialchars($animal['nom_animal']) ?></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
   

<!-- Fin de la section "Animaux" -->

<div class="d-grid gap-2 pt4 mt-4 ">
  <a href="gerer_animaux.php" class="btn btn-primary">Gérer les Animaux</a>
</div>
 </div>   
</div>
<?php
include("../pagesParametres/footer.php");
?>
