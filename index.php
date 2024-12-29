<?php

include("indexParametres/beforeHeader.php");
include("indexParametres/navbar.php");
include("indexParametres/header.php");
require_once 'dbconnect.php';
// Traitement des avis des clients
$statement_avis = $pdo->prepare("select * from avis where valider_avis=1");
$statement_avis->execute();
// Récupération des résultats de la requête
$row_avis = $statement_avis->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Début de la fenêtre modale de la vidéo -->
<div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Vidéo Youtube</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <!-- Rapport 16:9 -->
        <div class="ratio ratio-16x9">
          <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
            allow="autoplay"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Fin de la fenêtre modale de la vidéo -->

<!-- Début de la section "À propos" -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-6" data-wow-delay="0.1s">
        <p><span class="text-primary me-2">#</span>Bienvenue à ZooArcadia</p>
        <h1 class="display-5 mb-4">
          Pourquoi visiter le parc <span class="text-primary">ZooArcadia</span> ?
        </h1>
        <p class="mb-4">
          Stet no et lorem dolor et diam, amet duo ut dolore vero eos. No
          stet est diam rebum amet diam ipsum. Clita clita labore, dolor duo
          nonumy clita sit at, sed sit sanctus dolor eos.
        </p>
        <h5 class="mb-3">
          <i class="far fa-check-circle text-primary me-3"></i>Parking gratuit
        </h5>
        <h5 class="mb-3">
          <i class="far fa-check-circle text-primary me-3"></i>Environnement naturel
        </h5>
        <h5 class="mb-3">
          <i class="far fa-check-circle text-primary me-3"></i>Guide et sécurité professionnels
        </h5>
        <h5 class="mb-3">
          <i class="far fa-check-circle text-primary me-3"></i>Les meilleurs animaux du monde
        </h5>
        <a class="btn btn-primary py-3 px-5 mt-3" href="">En savoir plus</a>
      </div>
      <div class="col-lg-6" data-wow-delay="0.5s">
        <div class="img-border">
          <img class="img-fluid" src="img/about.jpg" alt="" />
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Fin de la section "À propos" -->

<!-- Début de la section "Faits" -->
<div class="container-xxl bg-primary facts my-5 py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
        <i class="fa fa-paw fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up">12345</h1>
        <p class="text-white mb-0">Nombre total d'animaux</p>
      </div>
      <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
        <i class="fa fa-users fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up">12345</h1>
        <p class="text-white mb-0">Visiteurs quotidiens</p>
      </div>
      <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
        <i class="fa fa-certificate fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up">12345</h1>
        <p class="text-white mb-0">Nombre total de membres</p>
      </div>
      <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
        <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up">12345</h1>
        <p class="text-white mb-0">Protection de la vie sauvage</p>
      </div>
    </div>
  </div>
</div>
<!-- Fin de la section "Faits" -->

<!-- Début de la section "Services" -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5 mb-5 wow fadeInUp" data-wow-delay="0.1s">
      <div class="col-lg-6">
        <p><span class="text-primary me-2">#</span>Nos services</p>
        <h1 class="display-5 mb-0">
          Services spéciaux pour les visiteurs de <span class="text-primary">ZooArcadia</span>
        </h1>
      </div>
      <div class="col-lg-6">
        <div class="bg-primary h-100 d-flex align-items-center py-4 px-4 px-sm-5">
          <i class="fa fa-3x fa-mobile-alt text-white"></i>
          <div class="ms-4">
            <p class="text-white mb-0">Appeler pour plus d'infos</p>
            <h2 class="text-white mb-0">+012 345 6789</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row gy-5 gx-4">
      <!-- Exemples de services avec descriptions -->
      <!-- ... Ajouter la traduction des autres services de la même manière -->
    </div>
  </div>
</div>
<!-- Fin de la section "Services" -->

<!-- Exemples d'animaux avec descriptions et images -->
<!-- Début de la section "Animaux" -->
<?php
// Requête pour récupérer les animaux avec leurs habitats et races
$query = "
 SELECT a.nom_animal, a.status_animal, a.image_path, h.nom_habitat, r.nom_race
 FROM animal a
 LEFT JOIN habitats h ON a.id_habitat = h.id_habitat
 LEFT JOIN races r ON a.id_race = r.id_race limit 12
";
$stmt = $pdo->query($query);
$animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5 mb-5 align-items-end wow fadeInUp" data-wow-delay="0.1s">
      <div class="col-lg-6">
        <p><span class="text-primary me-2">#</span>Nos animaux</p>
        <h1 class="display-5 mb-0">
          Découvrez nos incroyables animaux de <span class="text-primary">ZooArcadia</span>
        </h1>
      </div>
      <div class="col-lg-6 text-lg-end">
        <a class="btn btn-primary py-3 px-5" href="pages/gerer_animaux.php">
          Explorer plus d'animaux
        </a>
      </div>
    </div>
    <div class="row g-4">
      <?php foreach ($animaux as $animal): ?>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="row g-4">
            <div class="col-12">
              <a class="animal-item" href="<?= htmlspecialchars($animal['image_path']) ?>" data-lightbox="animal">
                <div class="position-relative">
                  <img class="img-fluid" src="<?= htmlspecialchars($animal['image_path']) ?>"
                    alt="<?= htmlspecialchars($animal['nom_animal']) ?>" />
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
  </div>
</div>
<!-- Fin de la section "Animaux" -->

<?php
// Récupération des heures de visite
$query = "SELECT jour, ouverture, fermeture, ferme FROM heures_visite ORDER BY FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')";
$stmt = $pdo->prepare($query);
$stmt->execute();
$heuresVisite = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
// Récupération de la date actuelle
$dateActuelle = new DateTime();

// Calcul du début de la semaine (lundi)
$debutSemaine = clone $dateActuelle;
$debutSemaine->modify('monday this week');

// Calcul de la fin de la semaine (dimanche)
$finSemaine = clone $debutSemaine;
$finSemaine->modify('sunday this week');

// Formatage des dates au format "jour mois année"
$format = 'd-m-Y';
$jourDebut = $debutSemaine->format('l');
$dateDebut = $debutSemaine->format($format);
$jourFin = $finSemaine->format('l');
$dateFin = $finSemaine->format($format);

// Génération du tableau associatif pour les jours et leurs dates
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$datesSemaine = [];
$currentDate = clone $debutSemaine;

foreach ($jours as $jour) {
    $datesSemaine[$jour] = $currentDate->format($format);
    $currentDate->modify('+1 day');
}

// Affichage des dates pour vérification
/*
echo '<pre>';
print_r($datesSemaine);
echo '</pre>';
*/
?>

<style>
  .small-text {
    font-size: 0.3em; /* Réduit la taille de la police */
    opacity: 0.8; /* Rendre le texte légèrement moins visible */
    display: inline-block; /* Maintenir sur la même ligne */
}
</style>
<!-- Heures de Visite Début -->
<div class="container-xxl bg-primary visiting-hours my-5 py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container py-5">
    <div class="row g-5">
    <div class="col-md-6 wow fadeIn" data-wow-delay="0.3s">
    <h1 class="display-6 text-white mb-5">Heures de Visite <span  class="small-text"><?php echo "Semaine du {$dateDebut} au {$dateFin}."; ?></span></h1>
    <ul class="list-group list-group-flush">
    <?php foreach ($heuresVisite as $visite): ?>
    <li class="list-group-item">
        <span>
            <?= htmlspecialchars($visite['jour']) . ' (' . ($datesSemaine[$visite['jour']] ?? '') . ')' ?>
        </span>
        <span>
            <?php 
            // Vérifie si le jour est fermé
            if ($visite['ferme']) {
                echo 'Fermé';
            } else {
                // Affiche les heures d'ouverture et de fermeture
                echo htmlspecialchars($visite['ouverture']) . ' - ' . htmlspecialchars($visite['fermeture']);
            }
            ?>
        </span>
    </li>
<?php endforeach; ?>

    </ul>
</div>
      <div class="col-md-6 text-light wow fadeIn" data-wow-delay="0.5s">
        <h1 class="display-6 text-white mb-5">Informations de Contact</h1>
        <table class="table">
          <tbody>
            <tr>
              <td>Bureau</td>
              <td>123 Rue, Rennes, France</td>
            </tr>
            <tr>
              <td>Zoo</td>
              <td>123 Rue, Rennes, France</td>
            </tr>
            <tr>
              <td>Billetterie</td>
              <td>
                <p class="mb-2">+012 345 6789</p>
                <p class="mb-0">billetterie@ZooArcadia.com</p>
              </td>
            </tr>
            <tr>
              <td>Support</td>
              <td>
                <p class="mb-2">+012 345 6789</p>
                <p class="mb-0">support@ZooArcadia.com</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Heures de Visite Fin -->

<!-- Adhésion Début -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5 mb-5 align-items-end wow fadeInUp" data-wow-delay="0.1s">
      <div class="col-lg-6">
        <p><span class="text-primary me-2">#</span>Adhésion</p>
        <h1 class="display-5 mb-0">
          Vous pouvez devenir un membre fier de
          <span class="text-primary">ZooArcadia</span>
        </h1>
      </div>
      <div class="col-lg-6 text-lg-end">
        <a class="btn btn-primary py-3 px-5" href="">Tarifs Spéciaux</a>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="membership-item position-relative">
          <img class="img-fluid" src="img/animal-lg-1.jpg" alt="" />
          <h1 class="display-1">01</h1>
          <h4 class="text-white mb-3">Populaire</h4>
          <h3 class="text-primary mb-4">$99.00</h3>
          <p><i class="fa fa-check text-primary me-3"></i>10% de réduction</p>
          <p>
            <i class="fa fa-check text-primary me-3"></i>2 adultes et 2 enfants
          </p>
          <p>
            <i class="fa fa-check text-primary me-3"></i>Exposition d'animaux gratuite
          </p>
          <a class="btn btn-outline-light px-4 mt-3" href="">Commencer</a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
        <div class="membership-item position-relative">
          <img class="img-fluid" src="img/animal-lg-2.jpg" alt="" />
          <h1 class="display-1">02</h1>
          <h4 class="text-white mb-3">Standard</h4>
          <h3 class="text-primary mb-4">$149.00</h3>
          <p><i class="fa fa-check text-primary me-3"></i>15% de réduction</p>
          <p>
            <i class="fa fa-check text-primary me-3"></i>4 adultes et 4 enfants
          </p>
          <p>
            <i class="fa fa-check text-primary me-3"></i>Exposition d'animaux gratuite
          </p>
          <a class="btn btn-outline-light px-4 mt-3" href="">Commencer</a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
        <div class="membership-item position-relative">
          <img class="img-fluid" src="img/animal-lg-3.jpg" alt="" />
          <h1 class="display-1">03</h1>
          <h4 class="text-white mb-3">Premium</h4>
          <h3 class="text-primary mb-4">$199.00</h3>
          <p><i class="fa fa-check text-primary me-3"></i>20% de réduction</p>
          <p>
            <i class="fa fa-check text-primary me-3"></i>6 adultes et 6 enfants
          </p>
          <p>
            <i class="fa fa-check text-primary me-3"></i>Exposition d'animaux gratuite
          </p>
          <a class="btn btn-outline-light px-4 mt-3" href="">Commencer</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Adhésion Fin -->

<!-- Début des Témoignages -->
<div class="container-xxl py-5">
  <div class="container">
    <h1 class="display-5 text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
      Ce que disent nos clients !
    </h1>

    <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">

      <?php
      // Parcourir les lignes récupérées de la base de données de la table avis
      foreach ($row_avis as $avis) {
        ?>
        <div class="testimonial-item text-center">
          <img class="img-fluid rounded-circle border border-2 p-2 mx-auto mb-4" src="img/<?php echo $avis['image_avis']; ?>"
            style="width: 100px; height: 100px" />
          <div class="testimonial-text rounded text-center p-4">
            <p>
                  <?php echo $avis['message_avis']; ?>
            </p>
            <h5 class="mb-1"><?php echo $avis['nom_avis']; ?></h5>
            <span class="fst-italic"><?php echo $avis['profession_avis']; ?></span>
          </div>
        </div>
        
        
        <?php
      }
      ?>
      </div>
  </div>
      <div class="col-lg-12 text-lg-end">
        <a class="btn btn-primary py-3 px-5" href="avis/ajouter_avis.php">Laissez un aviz</a>
      </div>
    
</div>
<!-- Fin des Témoignages -->

<?php
include("indexParametres/footer.php");
?>