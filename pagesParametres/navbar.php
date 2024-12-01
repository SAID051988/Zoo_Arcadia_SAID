<!-- Début du Spinner -->
<div
      id="spinner"
      class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
    >
      <div
        class="spinner-border text-primary"
        style="width: 3rem; height: 3rem"
        role="status"
      >
        <span class="sr-only">Chargement...</span>
      </div>
</div>
<!-- Fin du Spinner -->

<!-- Début de la Barre Supérieure -->
<div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s">
      <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
          <div class="h-100 d-inline-flex align-items-center py-3 me-4">
            <small class="fa fa-map-marker-alt text-primary me-2"></small>
            <small>123 Rue, New York, USA</small>
          </div>
          <div class="h-100 d-inline-flex align-items-center py-3">
            <small class="far fa-clock text-primary me-2"></small>
            <small>Lun - Ven : 09:00 - 21:00</small>
          </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
          <div class="h-100 d-inline-flex align-items-center py-3 me-4">
            <small class="fa fa-phone-alt text-primary me-2"></small>
            <small>+012 345 6789</small>
          </div>
          <div class="h-100 d-inline-flex align-items-center">
            <a class="btn btn-sm-square bg-white text-primary me-1" href=""
              ><i class="fab fa-facebook-f"></i
            ></a>
            <a class="btn btn-sm-square bg-white text-primary me-1" href=""
              ><i class="fab fa-twitter"></i
            ></a>
            <a class="btn btn-sm-square bg-white text-primary me-1" href=""
              ><i class="fab fa-linkedin-in"></i
            ></a>
            <a class="btn btn-sm-square bg-white text-primary me-0" href=""
              ><i class="fab fa-instagram"></i
            ></a>
          </div>
        </div>
      </div>
</div>
<!-- Fin de la Barre Supérieure -->

<!-- Début de la Barre de Navigation -->
<nav
      class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-lg-0 px-4 px-lg-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <a href="../index.php" class="navbar-brand p-0">
        <img class="img-fluid me-3" src="../img/icon/icon-10.png" alt="Icône" />
        <h1 class="m-0 text-primary">ZooAccradia</h1>
      </a>
      <button
        type="button"
        class="navbar-toggler"
        data-bs-toggle="collapse"
        data-bs-target="#navbarCollapse"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse py-4 py-lg-0" id="navbarCollapse">
        <div class="navbar-nav ms-auto">
          <a href="../index.php" class="nav-item nav-link active">Accueil</a>
          <a href="about.html" class="nav-item nav-link">À propos</a>
          <a href="s../ervices/gerer_service.php" class="nav-item nav-link">Services</a>
          <div class="nav-item dropdown">
            <a
              href="#"
              class="nav-link dropdown-toggle"
              data-bs-toggle="dropdown"
              >Pages</a
            >
            <div class="dropdown-menu rounded-0 rounded-bottom m-0">
            <a href="../pages/liste_animaux.php" class="dropdown-item">Nos Animaux</a>
            <a href="../habitats/gerer_habitats.php" class="dropdown-item">Nos habitats</a>
              <a href="visiting.html" class="dropdown-item">Heures de Visite</a>
              <a href="testimonial.html" class="dropdown-item">Témoignages</a>
              <a href="404.html" class="dropdown-item">Page 404</a>
            </div>
          </div>
          <a href="contact.html" class="nav-item nav-link">Contact</a>
        </div>
        <a href="../inscription/formulaire_connexion_utilisateur.php" class="btn btn-primary"
          >Se connecter<i class="fa fa-arrow-right ms-3"></i
        ></a>
      </div>
</nav>
<!-- Fin de la Barre de Navigation -->
