<!-- Page Header Start -->
<div class="container-fluid header-bg py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="container py-5">
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>
    <h1 class="display-4 text-white mb-3 animated slideInDown">
      <?php
    if($currentPage == 'gerer_habitats.php'){
      echo 'Gestion des habitats';
    }else if($currentPage == 'inscription.php'){
      echo 'Création des comptes';
    }else if($currentPage == 'gerer_service.php'){
      echo 'Gestion des services';
    }else if($currentPage == 'modifier_heures_visite.php'){
      echo 'Gestion des horaires';
    }else if($currentPage == 'statistiques_animaux.php'){
      echo 'Statistique des interactions avec les animaux';
    }else if($currentPage == 'gerer_animaux.php'){
      echo 'Gérer les animaux';
    }else if($currentPage == 'gerer_veterinaire_saisie.php'){
      echo 'Gestion des comptes rendus';
    }
    
    ?>
    </h1>

  </div>
</div>
<!-- Page Header End -->