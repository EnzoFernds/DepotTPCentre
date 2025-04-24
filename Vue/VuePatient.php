<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title = "Accueil"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Style/navBarStyle.css">
    <link rel="stylesheet" href="Style/PatientStyle.css">
</head>

<body>

    <?php ob_start(); ?>

    <div class="topnav">
        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="container">
        <h2>Patients</h2>
        <div class="patients-wrapper">
            <?php foreach ($patient as $p): ?>
                <div class="patient-card">
                    <p><strong>Patient n°<?= htmlspecialchars($p['id_patient']) ?></strong></p>

                    <!-- Formulaire pour suppression -->
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($p['id_patient']) ?>">

                    <p>Nom : <?= htmlspecialchars($p['nom']) ?></p>
                    <p>Âge : <?= htmlspecialchars($p['age']) ?></p>
                    <p>Lit : <?= htmlspecialchars($p['id_lit']) ?></p>
                    <p>Numero chambre : <?= htmlspecialchars($p['numero_chambre']) ?></p>
                    <p>Étage : <?= htmlspecialchars($p['id_etage']) ?></p>

                    <form method="POST" action="index.php?action=supprimerPatient"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?');">
                        <input type="hidden" name="id_patient" value="<?= $patient['id_patient'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <?php $contenu = ob_get_clean(); ?>
        <?php require 'Gabarit/Gabarit.php'; ?>
</body>

</html>