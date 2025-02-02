<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'administrateur') {
  header('Location: ../inscription/formulaire_connexion_utilisateur.php');
  exit();
}


include("../pagesParametres/beforeHeader.php");

require_once '../dbconnect.php';
require_once '../config.php';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<link href="../lib/dashboard/float-chart.css" rel="stylesheet" />
<!-- Custom CSS -->
<link href="../lib/dashboard/style.min.css" rel="stylesheet" />

<style>
 .active-card {
  border: 4px solid #ffc107;
  border-radius: 8px;
  transition: all 0.25s ease;
}

.active-card h1 {
  font-size: 2.075rem; /* Taille du texte de l'icône */
}

.active-card h6 {
  font-size: 1.2rem; /* Taille du texte sous l'icône */
}

  .card-hover {
    cursor: pointer;
  }
</style>


<div class="container-fluid py-5">

  <!-- Début de la Barre Supérieure -->
  <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s" style="margin: 0; padding: 0;">
    <div class="row gx-0 d-none d-lg-flex align-items-center" style="margin: 0; padding: 0;">
      <div class="col-lg-3 px-2 text-start">
        <div class="h-100 d-inline-flex align-items-center me-4">
          <small class="fa fa-map-marker-alt text-primary me-2"></small>
          <small>123 Rue, New York, USA</small>
        </div>
        <div class="h-100 d-inline-flex align-items-center">
          <small class="far fa-clock text-primary me-2"></small>
          <small>Lun - Ven : 09:00 - 21:00</small>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <a href="../index.php" class="navbar-brand p-0 d-flex align-items-center justify-content-center">
          <img class="img-fluid me-3" src="../img/icon/icon-10.png" alt="Icône" style="height: 50px;" />
          <h1 class="m-0 text-primary">ZooArcadia</h1>
        </a>
      </div>
      <div class="col-lg-3 px-2 text-end">
        <div class="h-100 d-inline-flex align-items-center me-4">
          <small class="fa fa-phone-alt text-primary me-2"></small>
          <small>+012 345 6789</small>
        </div>
        <div class="h-100 d-inline-flex align-items-center">
          <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
          <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
          <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
          <a class="btn btn-sm-square bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin de la Barre Supérieure -->

  <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s" style="margin: 0; padding: 0;">

    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Espace Administrateur</h4>
            <div class="ms-auto text-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <a href="../logout.php" class="btn btn-danger btn-sm mb-2">Déconnexion</a>
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    include("../pagesParametres/header-page.php");
    ?>

    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Sales Cards  -->
      <!-- ============================================================== -->
      <div class="row">
       <!-- Column -->
<div class="col-md-6 col-lg-5 col-xlg-3">
  <div class="card card-hover <?php echo $currentPage === 'inscription.php' ? 'active-card' : ''; ?>"  
       onclick="window.location.href='../inscription/inscription.php';" style="cursor: pointer;">
    <div class="box bg-success text-center">
      <h1 class="font-light text-white">
        <i class="mdi mdi-chart-areaspline"></i>
      </h1>
      <h6 class="text-white">Inscrire un employé ou un vétérinaire</h6>
    </div>
  </div>
</div>

        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-hover <?php echo $currentPage === 'gerer_service.php' ? 'active-card' : ''; ?>"   
          onclick="window.location.href='../services/gerer_service.php';" style="cursor: pointer;">
            <div class="box bg-secondary text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-collage"></i>
              </h1>
              <h6 class="text-white">Gérer les services</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
          <div class="card card-hover <?php echo $currentPage === 'modifier_heures_visite.php' ? 'active-card' : ''; ?>"
          onclick="window.location.href='../espace_administrateur/modifier_heures_visite.php';" style="cursor: pointer;">
            <div class="box bg-cyan text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-calendar-check"></i>
              </h1>
              <h6 class="text-white">Heures de visite</h6>
            </div>
          </div>
        </div>

        
        <!-- Column -->
<div class="col-md-6 col-lg-3 col-xlg-3">
  <div class="card card-hover <?php echo $currentPage === 'gerer_habitats.php' ? 'active-card' : ''; ?>"
  onclick="window.location.href='../habitats/gerer_habitats.php';" style="cursor: pointer;">
    <div class="box bg-danger text-center">
      <h1 class="font-light text-white">
        <i class="mdi mdi-border-outside"></i>
      </h1>
      <h6 class="text-white">Gérer les habitats</h6>
    </div>
  </div>
</div>

        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover <?php echo $currentPage === 'gerer_veterinaire_saisie.php' ? 'active-card' : ''; ?>"
        onclick="window.location.href='../espace_veterinaire/gerer_veterinaire_saisie.php';" style="cursor: pointer;">
            <div class="box bg-info text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-arrow-all"></i>
              </h1>
              <h6 class="text-white">Comptes redus</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
        <div class="card card-hover <?php echo $currentPage === 'statistiques_animaux.php' ? 'active-card' : ''; ?>" 
          onclick="window.location.href='../statistiques/statistiques_animaux.php';" style="cursor: pointer;">
            <div class="box bg-danger text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-receipt"></i>
              </h1>
              <h6 class="text-white">Suivi et Analyse des Interactions avec les Animaux</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-hover <?php echo $currentPage === 'gerer_animaux.php' ? 'active-card' : ''; ?>" 
        onclick="window.location.href='../pages/gerer_animaux.php';" style="cursor: pointer;">
            <div class="box bg-success text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-relative-scale"></i>
              </h1>
              <h6 class="text-white">Gérer les animaux</h6>
            </div>
          </div>
        </div>
        
       
        
      </div>
