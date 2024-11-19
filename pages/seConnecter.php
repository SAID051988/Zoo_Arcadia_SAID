<?php

include("../pagesParametres/beforeHeader.php");
include("../pagesParametres/navbar.php");
include("../pagesParametres/header.php");

?>

  <!-- Conteneur de Connexion -->
  <div class="login-container">
    <div class="login-card text-center">
      <h2 class="text-primary">Connexion</h2>
      <p class="mb-4">Connectez-vous à votre compte</p>
      <form action="votre_script_de_connexion.php" method="POST">
        <div class="mb-3">
          <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            placeholder="Nom d'utilisateur"
            required
          />
        </div>
        <div class="mb-4">
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            placeholder="Mot de passe"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary">Se Connecter</button>
        <p class="form-text mt-3">
          <a href="#">Mot de passe oublié ?</a>
        </p>
      </form>
    </div>
  </div><?php
include("../pagesParametres/footer.php");
?>
