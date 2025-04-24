<?php ob_start(); ?>
<link rel="stylesheet" href="Style/etageStyle.css">
<title><?= $title = "Étage"; ?></title>

<body>
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col">
                <h2 class="text-center">Etages</h2>
            </div>
        </div>

        <div class="container d-flex justify-content-center">
            <div class="graphique">
                <?php foreach ($etages as $etage): ?>
                    <div class="etage mb-4 p-3 rounded border bg-light">
                        <h4 class="text-center"><?= $etage['nom'] ?></h4>
                        <p class="text-center">
                            <span class="badge bg-secondary">
                                Lits occupés : <?= compterLitsOccupesParEtage($etage['id']) ?> /
                                <?= compterLitsTotalParEtage($etage['id']) ?>
                            </span>
                        </p>

                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <?php foreach ($etage['chambres'] as $chambre): ?>
                                <div class="card text-center" style="width: 5rem;">
                                    <div class="card-body p-2">
                                        <strong><?= $chambre['numero_chambre'] ?></strong><br>
                                        <small><?= $chambre['nb_lits_occupees'] ?> / <?= $chambre['nb_lits_total'] ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>


                        </div>
                    </div>
                <?php endforeach; ?>
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
</body>

<?php $contenu = ob_get_clean(); ?>
<?php require 'Gabarit/Gabarit.php'; ?>