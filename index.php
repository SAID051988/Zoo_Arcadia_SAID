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

// Exécuter la requête pour récupérer le total et la somme des vues
$statement_animaux = $pdo->prepare("SELECT COUNT(*) as total, SUM(view_animal) as nombre_vue FROM animal");
$statement_animaux->execute();
// Récupération des résultats
$row_animaux = $statement_animaux->fetch(PDO::FETCH_ASSOC);
$nombre_animaux = $row_animaux['total'];
$nombre_vue = $row_animaux['nombre_vue'];

// Exécuter la requête pour récupérer le total des avis
$statement_nbr_avis = $pdo->prepare("SELECT COUNT(*) as total_avis From avis");
$statement_nbr_avis->execute();
// Récupération des résultats
$row_nbr_avis = $statement_nbr_avis->fetch(PDO::FETCH_ASSOC);
$nombre_nbr_avis = $row_nbr_avis['total_avis'];
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
  Découvrez un univers fascinant où plus de 500 espèces évoluent dans des habitats immersifs.<br> 
  Plongez dans des expériences interactives : nourrissages, rencontres pédagogiques et safaris guidés.<br>
  Engagez-vous pour la conservation grâce à nos programmes de protection de la biodiversité.<br>
  Un lieu unique alliant aventure familiale, émerveillement et respect du vivant.
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
  <h1 class="text-white mb-2" data-toggle="counter-up"><?php echo htmlspecialchars($nombre_animaux); ?></h1>
  <p class="text-white mb-0">Nombre total d'animaux</p>
</div>
      <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
        <i class="fa fa-users fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up"><?php echo htmlspecialchars($nombre_vue); ?></h1>
        <p class="text-white mb-0">Visiteurs quotidiens</p>
      </div>
      <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
        <i class="fa fa-certificate fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up">
          <?php echo htmlspecialchars($nombre_nbr_avis); ?></h1>
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
      <div class="col-lg-6 text-lg-end">
        <a class="btn btn-primary py-3 px-5" href="habitats/gerer_habitats.php">Voir tous les habitats</a>
      </div>
    </div>
    <div class="row gy-5 gx-4">
  <!-- Parking pour voitures -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
    <img class="img-fluid mb-3" src="img/icon/icon-2.png" alt="Icône" />
    <h5 class="mb-3">Parking pour voitures</h5>
    <span>Un espace sécurisé pour garer votre véhicule durant votre visite.</span>
  </div>

  <!-- Photos d’animaux -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
    <img class="img-fluid mb-3" src="img/icon/icon-3.png" alt="Icône" />
    <h5 class="mb-3">Photos d’animaux</h5>
    <span>Capturez des souvenirs uniques grâce à nos photographies d’animaux.</span>
  </div>

  <!-- Services de guide -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
    <img class="img-fluid mb-3" src="img/icon/icon-4.png" alt="Icône" />
    <h5 class="mb-3">Services de guide</h5>
    <span>Découvrez le site avec nos guides experts pour enrichir votre visite.</span>
  </div>

  <!-- Restauration et boissons -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
    <img class="img-fluid mb-3" src="img/icon/icon-5.png" alt="Icône" />
    <h5 class="mb-3">Restauration et boissons</h5>
    <span>Des repas délicieux et des rafraîchissements pour agrémenter votre visite.</span>
  </div>

  <!-- Boutique du zoo -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
    <img class="img-fluid mb-3" src="img/icon/icon-6.png" alt="Icône" />
    <h5 class="mb-3">Boutique du zoo</h5>
    <span>Trouvez des souvenirs uniques et des articles inspirés du zoo.</span>
  </div>

  <!-- Wi-Fi haut débit gratuit -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
    <img class="img-fluid mb-3" src="img/icon/icon-7.png" alt="Icône" />
    <h5 class="mb-3">Wi-Fi haut débit gratuit</h5>
    <span>Un accès Internet rapide et gratuit pour tous les visiteurs.</span>
  </div>

  <!-- Aire de jeux -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
    <img class="img-fluid mb-3" src="img/icon/icon-8.png" alt="Icône" />
    <h5 class="mb-3">Aire de jeux</h5>
    <span>Une zone spécialement aménagée pour le plaisir des plus jeunes.</span>
  </div>

  <!-- Maison de repos -->
  <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
    <img class="img-fluid mb-3" src="img/icon/icon-9.png" alt="Icône" />
    <h5 class="mb-3">Maison de repos</h5>
    <span>Un espace pour se détendre et profiter d’un moment de calme.</span>
  </div>
</div>

<!-- Fin de la section "Services" -->

<!-- Exemples d'animaux avec descriptions et images -->
<!-- Début de la section "Animaux" -->
<?php
// Requête pour récupérer les animaux avec leurs habitats et races
$query = "
 SELECT a.nom_animal, a.status_animal, a.image_path, h.nom_habitat, r.nom_race, a.id_animal as id_animal,h.description_habitat as description
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
            <a 
  class="animal-item" 
  href="<?= htmlspecialchars($animal['image_path']) ?>" 
  data-id="<?= htmlspecialchars($animal['id_animal']) ?>" 
  data-lightbox="animal"
>
                <div class="position-relative">
                  <img class="img-fluid" src="<?= htmlspecialchars($animal['image_path']) ?>"
                    alt="<?= htmlspecialchars($animal['nom_animal']) ?>"  data-id="<?= htmlspecialchars($animal['id_animal']) ?>" />
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
              <td>123 Rue, New York, USA</td>
            </tr>
            <tr>
              <td>Zoo</td>
              <td>123 Rue, New York, USA</td>
            </tr>
            <tr>
              <td>Billetterie</td>
              <td>
                <p class="mb-2">+012 345 6789</p>
                <p class="mb-0">billetterie@example.com</p>
              </td>
            </tr>
            <tr>
              <td>Support</td>
              <td>
                <p class="mb-2">+012 345 6789</p>
                <p class="mb-0">support@example.com</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Heures de Visite Fin -->

<!-- Habitats Début -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5 mb-5 align-items-end wow fadeInUp" data-wow-delay="0.1s">
      <div class="col-lg-6">
        <p><span class="text-primary me-2">#</span>Habitats</p>
        <h1 class="display-5 mb-0">
          Découvrez les habitats uniques de
          <span class="text-primary">ZooArcadia</span>
        </h1>
      </div>
      <div class="col-lg-6 text-lg-end">
        <a class="btn btn-primary py-3 px-5" href="habitats/gerer_habitats.php">Voir tous les habitats</a>
      </div>
    </div>
    <div class="row g-4">
      <!-- Habitat 1 -->
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
      <div class="membership-item position-relative">
    <img class="img-fluid" src="img/habitats/savane_africaine.jpg" alt="Habitat Savane Africaine" />
    <h1 class="display-1">01</h1>
    <h4 class="text-white mb-3">Savane Africaine</h4>
    <h3 class="text-primary mb-4">Découvrez la Faune Unique</h3>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Rencontrez les majestueux lions et observez-les dans toute leur splendeur.
    </p>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Admirez les troupeaux d'antilopes dans leur environnement naturel.
    </p>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Plongez dans un décor authentique de savane.
    </p>
    <a class="btn btn-outline-light px-4 mt-3" href="">Explorer</a>
  </div>
</div>
      <!-- Habitat 1 -->


      <!-- Habitat 2 -->
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
      <div class="membership-item position-relative">
    <img class="img-fluid" src="img/habitats/jungle_tropicale.jpg" alt="Habitat Jungle Tropicale" />
    <h1 class="display-1">02</h1>
    <h4 class="text-white mb-3">Jungle Tropicale</h4>
    <h3 class="text-primary mb-4">Plongez au Cœur de la Nature</h3>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Explorez une biodiversité exceptionnelle.
    </p>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Observez les singes et oiseaux tropicaux.
    </p>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Profitez d'une immersion sonore unique.
    </p>
    <a class="btn btn-outline-light px-4 mt-3" href="">Explorer</a>
  </div>
</div>


      <!-- Habitat 3 -->
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
      <div class="membership-item position-relative">
    <img class="img-fluid" src="img/habitats/region_polaire.jpg" alt="Habitat Région Polaire" />
    <h1 class="display-1">03</h1>
    <h4 class="text-white mb-3">Région Polaire</h4>
    <h3 class="text-primary mb-4">Découvrez la Beauté Glaciale</h3>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Admirez les ours polaires et les phoques.
    </p>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Vivez une expérience dans un environnement glacé.
    </p>
    <p>
      <i class="fa fa-check text-primary me-3"></i>Explorez les conditions extrêmes et la faune polaire.
    </p>
    <a class="btn btn-outline-light px-4 mt-3" href="">Explorer</a>
  </div>
</div>

    </div>
  </div>
</div>
<!-- Habitats Fin -->


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
  </div>
  </div></div>
<!-- Fin des Témoignages -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
  const animalItems = document.querySelectorAll('.animal-item');

  animalItems.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault(); // Empêche l'ouverture du lien

      // Récupérer les données via dataset
      const animalId = item.dataset.id;

      console.log(`Animal ID: ${animalId}`);

      // Incrémenter le compteur de vues pour cet animal
      incrementViewCount(animalId);
    });
  });
});

// Fonction pour incrémenter le compteur de vues
function incrementViewCount(idAnimal) {
  const url = `pages/increment_view.php?id_animal=${idAnimal}`;
    console.log(`URL de la requête : ${url}`); // Ajoutez ceci pour vérifier l'URL
    fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        console.log("Compteur de vues incrémenté avec succès !");
      } else {
        console.error("Erreur lors de l'incrémentation : " + data.message);
      }
    })
    .catch(error => console.error("Erreur réseau :", error));
}


</script>

<?php
include("indexParametres/footer.php");
?>