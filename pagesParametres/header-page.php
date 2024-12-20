<!-- Page Header Start -->
<div class="container-fluid header-bg py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="container py-5">
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>
    <h1 class="display-4 text-white mb-3 animated slideInDown">
      <?php
    if($currentPage == 'gerer_habitats.php'){
      echo 'Nos habitats';
    }
    ?>
    </h1>

  </div>
</div>
<!-- Page Header End -->