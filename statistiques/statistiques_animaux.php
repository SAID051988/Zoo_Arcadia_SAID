<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include("../espace_administrateur/espace_administrateur.php");

// Requête pour récupérer les données des animaux et leurs vues
$query = $pdo->prepare("SELECT nom_animal, view_animal FROM animal");
$query->execute();
$animalData = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // Charger la bibliothèque Google Charts
    google.charts.load('current', { packages: ['corechart'] });

    // Appeler drawChart une fois Google Charts chargé
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    console.log("Google Charts is loading...");  // Vérification du chargement du graphique
    var data = google.visualization.arrayToDataTable([
        ['Animal', 'Nombre de vues'],
        <?php
        foreach ($animalData as $row) {
            echo "['" . htmlspecialchars($row['nom_animal'], ENT_QUOTES, 'UTF-8') . "', " . (int) $row['view_animal'] . "],";
        }
        ?>
    ]);

    var options = {
        title: 'Histogramme des vues par animal',
        hAxis: { title: 'Animal', titleTextStyle: { color: '#333' } },
        vAxis: { minValue: 0 },
        chartArea: { width: '70%', height: '70%' }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

</script>


<section class="statistiques">
    <div class="mask d-flex align-items-center h-100 gradient-custom">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-12 col-xl-9">
                    <div class="card shadow-lg">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="text-center text-primary">Histogramme des vues par animal</h2>
                            <!-- <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Animal</th>
                                        <th>Vue</th>
                                    </tr>
                                    <?php
                                    // Assurez-vous que cette ligne génère correctement les données
                                    // foreach ($animalData as $row) {
                                    //     echo "<tr><td>" . htmlspecialchars($row['nom_animal'], ENT_QUOTES, 'UTF-8')
                                    //         . "</td><td> " . (int) $row['view_animal'] . "</td></tr>";
                                    // }
                                    ?>
                                </thead>
                            </table> -->
                            <div id="chart_div" style="width: 1000px; height: 500px;"></div>
                            <!-- Conteneur pour le graphique -->
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