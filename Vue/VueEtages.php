<title><?= $title = "Etages"; ?></title>
<?php ob_start(); ?>
<link rel="stylesheet" href="Style/style.css">

<body>
    <div class="container mt-4">
        <!-- Le titre -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="text-center">Etages</h2>
            </div>
        </div>

        <!-- Représentation graphique -->
        <div class="container d-flex justify-content-center">
            <div class="graphique">
                <?php
                // Tableau des Etages avec le nombre de cellules par étage
                $etages = [
                    ['nom' => '3ème Etage', 'cellules' => 10],
                    ['nom' => '2ème Etage', 'cellules' => 10],
                    ['nom' => '1er Etage', 'cellules' => 10],
                ];

                // Parcours des Etages
                foreach ($etages as $index => $etage):
                    // Affichage de l'étiquette de l'étage
                    if ($index > 0) { // Ajout d'un séparateur entre les Etages
                        echo '<hr class="tilted">';
                    }
                    echo "<b>{$etage['nom']}</b>";

                    // Création des lignes de cellules
                    $cellulesParLigne = 5; // Nombre de cellules par ligne
                    $nombreDeLignes = $etage['cellules'] / $cellulesParLigne;

                    for ($i = 0; $i < $nombreDeLignes; $i++):
                        echo '<div class="row">';
                        for ($j = 0; $j < $cellulesParLigne; $j++):
                            echo '<div class="cell">

                                  </div>';
                        endfor;
                        echo '</div>';
                    endfor;
                endforeach;
                ?>
                <div>
                </div>
            </div>
        </div>
        </br>
        <div class="container d-flex justify-content-center">
            <div class="graphique">
                <p>Veuillez réserver une chambre :</p>
                <a href="index.php?action=Formulaire Réservation" class="btn btn-primary">Réserver</a>
            </div>
        </div>
    </div>
    </div>
</body>

<?php $contenu = ob_get_clean(); ?>
<?php require 'Gabarit/Gabarit.php'; ?>