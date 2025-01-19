<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'employe') {
    header('Location: ../inscription/formulaire_connexion_utilisateur.php');
    exit();
}



include("../pagesParametres/beforeHeader.php");

require_once '../dbconnect.php';
require_once '../config.php';
?>

<link href="../lib/dashboard/float-chart.css" rel="stylesheet" />
<!-- Custom CSS -->
<link href="../lib/dashboard/style.min.css" rel="stylesheet" />
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


  <style>
    .card-hover {
      cursor: pointer;
    }
  </style>

  <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s" style="margin: 0; padding: 0;">

    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Espace employé</h4>
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
        <div class="col-md-6 col-lg-2 col-xlg-3">
          <div class="card card-hover" onclick="loadContent('avis.php')">
            <div class="box bg-cyan text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-calendar-check"></i>
              </h1>
              <h6 class="text-white">Valider les avis</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
          <div class="card card-hover" onclick="loadContent('gerer_service.php')">
            <div class="box bg-success text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-chart-areaspline"></i>
              </h1>
              <h6 class="text-white">Gérer les services du zoo</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
          <div class="card card-hover" onclick="loadContent('../services/gerer_service.php')">
            <div class="box bg-warning text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-collage"></i>
              </h1>
              <h6 class="text-white">Gérer les services</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
          <div class="card card-hover">
            <div class="box bg-danger text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-border-outside"></i>
              </h1>
              <h6 class="text-white">Tables</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
          <div class="card card-hover">
            <div class="box bg-info text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-arrow-all"></i>
              </h1>
              <h6 class="text-white">Full Width</h6>
            </div>
          </div>
        </div>


        <!-- Column -->
      </div>

      <!-- ============================================================== -->
      <!-- Sales chart -->
      <!-- ============================================================== -->
      <!-- Dynamic Content Area -->
      <div id="content">
        <h5>Le contenu chargé s'affichera ici...</h5>
      </div>

      <script>
        function loadContent(pageUrl) {
          const contentDiv = document.getElementById('content');
          fetch(pageUrl)
            .then(response => {
              if (!response.ok) {
                throw new Error('Erreur lors du chargement de la page');
              }
              return response.text();
            })
            .then(html => {
              contentDiv.innerHTML = html;

              // Ajouter des comportements spécifiques selon la page
              if (pageUrl.includes('avis.php')) {
                attachAvisHandler();
              } else if (pageUrl.includes('gerer_service.php')) {
                attachGererServicePageHandler();
              } else if (pageUrl.includes('statistiques_animaux.php')) {
                attachStatistiquesPageHandler();
              }
              // Ajouter ici d'autres cas pour vos pages spécifiques
            })
            .catch(error => {
              contentDiv.innerHTML = `<p class="text-danger">${error.message}</p>`;
            });
        }
        function attachAvisHandler() {
          const form = document.querySelector("form");
          if (form) {
            form.addEventListener("submit", function (e) {
              e.preventDefault();
              const formData = new FormData(form);
              fetch("avis.php", {
                method: "POST",
                body: formData,
              })
                .then(response => response.text())
                .then(updatedHtml => {
                  document.getElementById('content').innerHTML = updatedHtml;
                })
                .catch(error => {
                  alert("Erreur lors de l'envoi : " + error.message);
                });
            });
          }
        }
        function attachGererServicePageHandler() {
          const form = document.querySelector("form");
          if (form) {
            form.addEventListener("submit", function (e) {
              e.preventDefault();
              const formData = new FormData(form);
              fetch("gerer_service.php", {
                method: "POST",
                body: formData,
              })
                .then(response => response.text())
                .then(updatedHtml => {
                  document.getElementById('content').innerHTML = updatedHtml;
                })
                .catch(error => {
                  alert("Erreur lors de l'envoi : " + error.message);
                });
            });
          }
        }



      </script>

    </div>

  </div>

</div>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>function loadPage(event, page) {
    event.preventDefault(); // Empêche le rechargement de la page
    const searchParam = new URLSearchParams(window.location.search).get('search') || '';
    const url = `gerer_service.php?page=${page}&search=${encodeURIComponent(searchParam)}`;

    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur lors du chargement de la page');
        }
        return response.text();
      })
      .then(html => {
        document.getElementById('content').innerHTML = html;
        attachGererServicePageHandler(); // Réattachez les événements nécessaires
      })
      .catch(error => {
        alert("Erreur : " + error.message);
      });
  }
</script>




<script>

  function updateAvis(id) {
    // Récupérer l'état de la checkbox
    var isChecked = $("#valider_avis_" + id).prop("checked");

    // Debug : Afficher les informations
    console.log("ID:", id, "État:", isChecked);

    // Utilisez AJAX pour envoyer la mise à jour au script PHP
    $.ajax({
      url: 'update_valider_avis.php',
      method: 'POST',
      data: {
        id: id,
        value: isChecked ? 1 : 0
      },
      success: function (response) {
        // Affichez un message de succès si nécessaire
        console.log("Succès:", response);
        alert("Mise à jour réussie !");
      },
      error: function (xhr, status, error) {
        // Gérez les erreurs ici
        console.error("Erreur:", error);
        alert("Une erreur est survenue lors de la mise à jour.");
      }
    });
  }

</script>



<!-- Bootstrap tether Core JavaScript -->
<script src="../lib/dashboard/bootstrap.bundle.min.js"></script>
<script src="../lib/dashboard/perfect-scrollbar.jquery.min.js"></script>
<script src="../lib/dashboard/sparkline.js"></script>
<!--Wave Effects -->
<script src="../lib/dashboard/waves.js"></script>
<!--Menu sidebar -->
<script src="../lib/dashboard/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="../lib/dashboard/custom.min.js"></script>
<!--This page JavaScript -->
<!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<!-- <script src="../lib/dashboard/flot/excanvas.js"></script>
<script src="../lib/dashboard/flot/jquery.flot.js"></script>
<script src="../lib/dashboard/flot/jquery.flot.pie.js"></script>
<script src="../lib/dashboard/flot/jquery.flot.time.js"></script>
<script src="../lib/dashboard/flot/jquery.flot.stack.js"></script>
<script src="../lib/dashboard/flot/jquery.flot.crosshair.js"></script>
<script src="../lib/dashboard/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="../lib/dashboard/pages/chart/chart-page-init.js"></script> -->
</body>

</html>