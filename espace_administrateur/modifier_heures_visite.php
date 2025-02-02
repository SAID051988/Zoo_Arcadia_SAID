<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include("../espace_administrateur/espace_administrateur.php");


// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['jours'] as $id => $data) {
        $ouverture = !empty($data['ouverture']) ? $data['ouverture'] : null;
        $fermeture = !empty($data['fermeture']) ? $data['fermeture'] : null;
        $ferme = isset($data['ferme']) ? 1 : 0;

        try {
            $stmt = $pdo->prepare("UPDATE heures_visite SET ouverture = ?, fermeture = ?, ferme = ? WHERE id = ?");
            $stmt->execute([$ouverture, $fermeture, $ferme, $id]);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        
    }
    $message = "Mise à jour réussie !";
}

// Récupération des données actuelles
$stmt = $pdo->query("SELECT * FROM heures_visite");
$jours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




    <section class="intro">
        <div class="mask d-flex align-items-center h-100 gradient-custom">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9 col-xl-7">
                        <div class="card shadow-lg">
                            <div class="card-body p-4 p-md-5">
                                <h2 class="text-center text-primary">Modifier les heures de visite</h2>
                                <?php if (isset($message)): ?>
                                    <div class="alert alert-success text-center">
                                        <?= $message ?>
                                    </div>
                                <?php endif; ?>
                                <form method="post">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-primary text-center">
                                                <tr>
                                                    <th>Jour</th>
                                                    <th>Ouverture</th>
                                                    <th>Fermeture</th>
                                                    <th>Fermé</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jours as $jour): ?>
                                                    <tr>
                                                        <td><?= $jour['jour'] ?></td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                                                <input type="time" class="form-control" name="jours[<?= $jour['id'] ?>][ouverture]"
                                                                    value="<?= $jour['ouverture'] ?>">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                                                <input type="time" class="form-control" name="jours[<?= $jour['id'] ?>][fermeture]"
                                                                    value="<?= $jour['fermeture'] ?>">
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="form-check-input" name="jours[<?= $jour['id'] ?>][ferme]" <?= $jour['ferme'] ? 'checked' : '' ?>>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
include("../pagesParametres/footer.php");
?>