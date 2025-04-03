<title><?=$title="Accueil";?></title>
<?php ob_start();?>
<body>
    <!-- contenu de la page -->
    <div class="container">
        <!-- Le titre -->
        <div class="row">
            <div class="col">
                <h2 style="margin-left:50px">Repas</h2>
        </div>
    </div>
    <p></p>
    <p></p>
            <div class ="container">
                <div class="graphique  ">
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
                foreach ($etages as $index => $repas) {
                    // Ajout d'un séparateur entre les jours sauf pour le premier
                    if ($index > 0) { 
                        echo '<hr class="tilted">';
                    }

                    // Affichage du nom du jour
                    echo "<b>{$repas['nom']}</b>";

                    // Création des lignes de cellules
                    $cellulesParLigne = 2; // Nombre de cellules par ligne
                    $nombreDeLignes = $repas['cellules'] / $cellulesParLigne;

                    for ($i = 0; $i < $nombreDeLignes; $i++) {
                        echo '<div class="row">';
                        for ($j = 0; $j < $cellulesParLigne; $j++) {
                            echo '<div class="cell">
                                    <Hey>
                                </div>';
                        }
                        echo '<div class="col-md-6">';
                        echo '<h5 class="text-center">Matin</h5>';
                    for ($i = 0; $i < 4; $i++) { // 5 cellules matin
                        echo '<div class="text-center">
                            <h2>Hey</h2>
                          </div>';
                        }
                        echo '</div>';

                        echo '<div class="col-md-6">';
                        echo '<h5 class="text-center">Soir</h5>';
                    for ($i = 0; $i < 4; $i++) { // 5 cellules soir
                        echo '<div class="text-center">
                                <h2>Hey</h2>
                            </div>';
                    }
                echo '</div>';
                echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <style>
        .container {
        }
    </style>
</body>

<?php $contenu = ob_get_clean();?>
<?php require 'Gabarit/Gabarit.php';?>