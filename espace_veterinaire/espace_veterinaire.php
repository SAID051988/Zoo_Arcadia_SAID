<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'veterinaire') {
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
            <h4 class="page-title">Espace vétérinaire</h4>
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
          <div class="card card-hover" onclick="loadContent('gerer_veterinaire_saisie.php')">
            <div class="box bg-cyan text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-calendar-check"></i>
              </h1>
              <h6 class="text-white">Comptes rendus</h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
          <div class="card card-hover" onclick="loadContent('')">
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
          <div class="card card-hover" onclick="loadContent('')">
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
              if (pageUrl.includes('gerer_veterinaire_saisie.php')) {
                attachVeterinaireHandler();
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
        function attachVeterinaireHandler() {
          const form = document.querySelector("form");
          if (form) {
            form.addEventListener("submit", function (e) {
              e.preventDefault();
              const formData = new FormData(form);
              fetch("gerer_veterinaire_saisie.php", {
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
    const url = `gerer_veterinaire_saisie.php?page=${page}&search=${encodeURIComponent(searchParam)}`;

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


<!-- JavaScript gérer veterinaire saisie
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
    <script>
        document.getElementById('id_animal_mod').addEventListener('change', function () {
            const idAnimal = this.value;

            fetch(`get_nourritures.php?id_animal=${idAnimal}`)
                .then(response => response.json())
                .then(data => {
                    const nourritureSelect = document.getElementById('id_nourriture_mod');
                    const currentSelection = nourritureSelect.value; // Conservez la sélection actuelle
                    nourritureSelect.innerHTML = '<option value="" disabled>Choisissez une nourriture</option>';

                    data.forEach(nourriture => {
                        nourritureSelect.innerHTML += `
                    <option value="${nourriture.id_nourriture}" 
                        ${nourriture.id_nourriture == currentSelection ? 'selected' : ''}>
                        ${nourriture.nom_nourriture}
                    </option>`;
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des nourritures :', error));
        });
        ///////////////////

        $(document).ready(function () {
            $('#editModal').on('show.bs.modal', function () {
                const idAnimal = $('#id_animal_mod').val(); // Récupère l'animal sélectionné
                if (idAnimal) {
                    $('#id_animal_mod').trigger('change'); // Simule un changement pour charger les nourritures
                }
            });
        });




        /////////////////////
        document.getElementById("submitEditForm").addEventListener("click", function () {
    const form = document.getElementById("editForm");
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || "Modification enregistrée avec succès !");
                
                // Ferme la modal
                const modalElement = document.querySelector('#editModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();

                // Met à jour la table avec les données reçues
                updateTable(data.updatedRow);
            } else {
                alert(data.message || "Une erreur s'est produite.");
            }
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
        });
});


    </script>

    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const saisieId = this.getAttribute('data-id');

                //const saisieId = event.target.closest('button').dataset.id;
                fetch(`get_saisie_data.php?id=${saisieId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Remplir les champs du formulaire modal avec les données récupérées
                        console.log(data);  // Vérifie la structure des données
                        if (data.status === 'success') {
                            // Remplir les champs du formulaire modal avec les données récupérées
                            document.querySelector('#editModal input[name="id_saisie"]').value = data.data.id_saisie;
                            document.querySelector('#editModal input[name="date_passage"]').value = data.data.date_passage;
                            document.querySelector('#editModal select[name="id_animal_mod"]').value = data.data.id_animal;
                            document.querySelector('#editModal select[name="id_nourriture_mod"]').value = data.data.id_nourriture;
                            document.querySelector('#editModal input[name="etat_animal"]').value = data.data.etat_animal;
                            document.querySelector('#editModal textarea[name="detail_etat_animal"]').value = data.data.detail_etat_animal;
                            document.querySelector('#editModal input[name="action_nourriture_mod"]').value = data.data.action_nourriture;
                            document.querySelector('#editModal input[name="etat_habitat"]').value = data.data.etat_habitat;
                            document.querySelector('#editModal textarea[name="detail_etat_habitat"]').value = data.data.detail_etat_habitat;

                            // Afficher la modal
                            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                            editModal.show();
                        } else {
                            console.error(data.message);
                        }
                    })
                    .catch(error => console.error('Erreur lors du chargement des données:', error));
            });
        });

        // Bouton Supprimer
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (event) => {
                const saisieId = event.target.closest('button').dataset.id;
                if (confirm('Voulez-vous vraiment supprimer cette saisie ?')) {
                    fetch(`delete_saisie.php?id=${saisieId}`, { method: 'GET' })
                        .then(response => response.text())
                        .then(result => {
                            alert(result);
                            location.reload(); // Recharger la page pour afficher les changements
                        })
                        .catch(error => console.error('Erreur lors de la suppression:', error));
                }
            });
        });


    </script>






    <script>
        $(document).ready(function () {
            // Écouter le changement de la liste des animaux
            $('#id_animal').change(function () {
                const animalId = $(this).val();

                // Vérifier qu'un animal est sélectionné
                if (animalId) {
                    $.ajax({
                        url: 'get_nourritures.php', // Fichier PHP qui retourne les nourritures
                        type: 'GET',
                        data: { id_animal: animalId },
                        dataType: 'json',
                        success: function (data) {
                            // Vider la liste des nourritures
                            $('#id_nourriture').empty();

                            // Ajouter une option par défaut
                            $('#id_nourriture').append('<option value="" disabled selected>Choisissez une nourriture</option>');

                            // Ajouter les options retournées
                            $.each(data, function (index, item) {
                                $('#id_nourriture').append(
                                    $('<option>', {
                                        value: item.id_nourriture,
                                        text: item.nom_nourriture
                                    })
                                );
                            });
                        },
                        error: function () {
                            alert('Erreur lors de la récupération des nourritures.');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // ID de la nourriture sélectionnée par défaut
            const selectedNourriture = $('#id_nourriture_mod').data('selected');

            // Écouter le changement de la liste des animaux
            $('#id_animal_mod').change(function () {
                const animalId = $(this).val();

                // Vérifier qu'un animal est sélectionné
                if (animalId) {
                    $.ajax({
                        url: 'get_nourritures.php', // Fichier PHP qui retourne les nourritures
                        type: 'GET',
                        data: { id_animal: animalId },
                        dataType: 'json',
                        success: function (data) {
                            // Vider la liste des nourritures
                            $('#id_nourriture_mod').empty();

                            // Ajouter une option par défaut
                            $('#id_nourriture_mod').append('<option value="" disabled selected>Choisissez une nourriture</option>');

                            // Ajouter les options retournées
                            $.each(data, function (index, item) {
                                const selected = item.id_nourriture == selectedNourriture ? 'selected' : '';
                                $('#id_nourriture_mod').append(
                                    $('<option>', {
                                        value: item.id_nourriture,
                                        text: item.nom_nourriture,
                                        selected: selected
                                    })
                                );
                            });
                        },
                        error: function () {
                            alert('Erreur lors de la récupération des nourritures.');
                        }
                    });
                }
            });
        });

    </script>
    <script>
        // Capture la soumission du formulaire
        document.getElementById('addSaisieForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Récupération des données du formulaire
            const formData = new FormData(this);

            // Envoi via AJAX
            fetch('add_saisie.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Succès
                        alert(data.message); // Ou affichez un message de succès dans la modal
                        // Rafraîchir les données de la table sans recharger la page
                        $('#addModal').modal('hide');
                        // Appeler une fonction pour recharger la table, exemple :
                        loadSaisieTable();
                    } else {
                        // Échec
                        alert(data.message); // Ou affichez un message d'erreur dans la modal
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Une erreur est survenue.");
                });
        });

        // Fonction pour recharger la table (à implémenter)
        function loadSaisieTable() {
            // Exemple : utiliser AJAX pour recharger les données de la table
            // fetch('get_saisies.php').then(...);
        }
    </script>

<script>
    function updateTable(updatedRow) {
    // Trouvez la ligne correspondante dans la table (en utilisant l'attribut data-id)
    const row = document.querySelector(`#saisieTable tr[data-id="${updatedRow.id_saisie}"]`);
    if (row) {
        // Mettre à jour chaque cellule en fonction des nouvelles données
        row.children[1].textContent = updatedRow.nom_animal;
        row.children[2].textContent = updatedRow.nom_nourriture;
        row.children[3].textContent = updatedRow.etat_animal;
        row.children[4].textContent = updatedRow.etat_habitat;
        row.children[5].textContent = updatedRow.action_nourriture;
        row.children[6].textContent = updatedRow.date_passage;
        row.children[7].textContent = updatedRow.detail_etat_animal;
        row.children[8].textContent = updatedRow.detail_etat_habitat;

        // Affiche un message dans la console pour vérifier
        console.log(`Ligne mise à jour pour l'ID ${updatedRow.id_saisie}`);
    } else {
        console.error("Ligne introuvable dans la table pour l'ID :", updatedRow.id_saisie);
    }
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