<title><?= $title = "Accueil"; ?></title>
<?php ob_start(); ?>

<body>
    <div class="container mt-4">
        <!-- Le titre -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="text-center">Accueil</h2>
            </div>
        </div>

        <!-- Section principale -->
        <div class="row justify-content-center">
            <!-- Carte du taux d'occupation global -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Taux d'occupation global</h5>
                        <p class="display-4 text-primary"><?= htmlspecialchars($result) . "%" ?></p>
                    </div>
                </div>
            </div>

            <!-- Carte du taux d'occupation par étage -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title text-center">Taux d'occupation par étage</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Étage 1 :
                                <strong><?= htmlspecialchars($tauxEtg1) . "%" ?></strong></li>
                            <li class="list-group-item">Étage 2 :
                                <strong><?= htmlspecialchars($tauxEtg2) . "%" ?></strong></li>
                            <li class="list-group-item">Étage 3 :
                                <strong><?= htmlspecialchars($tauxEtg3) . "%" ?></strong></li>
                        </ul>
                        <div class="text-center mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Autre section (ex: Statistiques ou Infos supplémentaires) -->
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Informations supplémentaires</h5>
                        <p class="card-text">Découvrez plus de statistiques et tendances sur l'occupation des étages.
                        </p>
                        <a href="#" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php $contenu = ob_get_clean(); ?>
<?php require 'Gabarit/Gabarit.php'; ?>