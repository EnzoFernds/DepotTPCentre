<title><?= $title = "Accueil"; ?></title>
<?php ob_start(); ?>

<body class="bg-light">
    <div class="container mt-5">
        <!-- Titre principal -->
        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="text-uppercase fw-bold text-primary">Accueil</h2>
                <hr class="w-25 mx-auto border-primary">
            </div>
        </div>

        <!-- Section des cartes -->
        <div class="row justify-content-center">

            <!-- Carte taux par étage -->
            <div class="col-md-6 mb-4 d-flex">
                <div class="card shadow-lg border-0 rounded-3 w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">Taux d'occupation par étage</h5>
                        <i class="fas fa-building fa-3x d-block text-center text-secondary mb-3"></i>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Étage 1 :</span>
                                <strong><?= htmlspecialchars($tauxEtg1) . "%" ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Étage 2 :</span>
                                <strong><?= htmlspecialchars($tauxEtg2) . "%" ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Étage 3 :</span>
                                <strong><?= htmlspecialchars($tauxEtg3) . "%" ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Carte taux par classe -->
            <div class="col-md-6 mb-4 d-flex">
                <div class="card shadow-lg border-0 rounded-3 w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">Taux d'occupation par classe</h5>
                        <i class="fas fa-users fa-3x d-block text-center text-info mb-3"></i>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Classe 1 :</span>
                                <strong><?= htmlspecialchars($tauxCls1) . "%" ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Classe 2 :</span>
                                <strong><?= htmlspecialchars($tauxCls2) . "%" ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Classe 3 :</span>
                                <strong><?= htmlspecialchars($tauxCls3) . "%" ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Carte taux global -->
            <div class="col-lg-6 mb-4 d-flex">
                <div class="card shadow-lg border-0 rounded-3 w-100 h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h5 class="card-title fw-bold">Taux d'occupation global</h5>
                        <i class="fas fa-chart-pie fa-3x text-primary mb-3"></i>
                        <p class="display-4 text-primary fw-bold"><?= htmlspecialchars($result) . "%" ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FontAwesome pour les icônes -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

<?php $contenu = ob_get_clean(); ?>
<?php require 'Gabarit/Gabarit.php'; ?>