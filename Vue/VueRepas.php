<title><?=$title="Accueil";?></title>
<?php ob_start();?>
<body>
    <div class="container d-flex justify-content-center">
    <div class="col-lg-8">
        <h2 class="text-center my-4">Repas</h2>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th style="font-size: 22px;">Jour</th>
                        <th style="font-size: 22px;">Matin</th>
                        <th style="font-size: 22px;">Soir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Tableau des jours avec le nombre de repas disponibles par jour
                    $etages = [
                        ['nom' => 'Lundi', 'cellules' => 10],
                        ['nom' => 'Mardi', 'cellules' => 10],
                        ['nom' => 'Mercredi', 'cellules' => 10],
                        ['nom' => 'Jeudi', 'cellules' => 10],
                        ['nom' => 'Vendredi', 'cellules' => 10],
                        ['nom' => 'Samedi', 'cellules' => 10],
                        ['nom' => 'Dimanche', 'cellules' => 10],
                    ];

                    foreach ($etages as $repas) {
                        echo '<tr>';
                        
                        // Affichage du jour, centré et en plus grand
                        echo "<td style='font-size: 20px; font-weight: bold; vertical-align: middle;'>{$repas['nom']}</td>";

                        // Matin (5 lignes)
                        echo '<td>';
                        for ($i = 0; $i < 5; $i++) {
                            echo '<h5 class="m-2">Matin</h5>';
                        }
                        echo '</td>';

                        // Soir (5 lignes)
                        echo '<td>';
                        for ($i = 0; $i < 5; $i++) {
                            echo '<h5 class="m-2">Soir</h5>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
</div>
</body>
<?php $contenu = ob_get_clean();?>
<?php require 'Gabarit/Gabarit.php';?>