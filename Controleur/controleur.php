<?php
require 'Repository/repository.php';

function accueil()
{
    $result = getTauxOccupation();
    $tauxEtg1 = getTauxRempEtg(1);
    $tauxEtg2 = getTauxRempEtg(2);
    $tauxEtg3 = getTauxRempEtg(3);
    $tauxCls1 = getTauxOccupationCls(1);
    $tauxCls2 = getTauxOccupationCls(2);
    $tauxCls3 = getTauxOccupationCls(3);
    require 'Vue/Vueaccueil.php';
}

function etages()
{
    $etagesSource = [
        ['id' => 3, 'nom' => '3ème Etage'],
        ['id' => 2, 'nom' => '2ème Etage'],
        ['id' => 1, 'nom' => '1er Etage'],
    ];

    $etages = [];

    foreach ($etagesSource as $etage) {
        $chambres = getChambresEtOccupationParEtage($etage['id']);


        $etages[] = [
            'id' => $etage['id'],
            'nom' => $etage['nom'],
            'chambres' => $chambres
        ];
    }

    require 'Vue/VueEtages.php';
}


function patients()
{
    require 'Vue/VuePatient.php';
}

function formreserv()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
        $age = isset($_POST['age']) ? (int) $_POST['age'] : 0;
        $classe = isset($_POST['classe']) ? trim($_POST['classe']) : '';

        if (empty($nom) || empty($age) || empty($classe)) {
            header("Location: index.php?error=" . urlencode("Tous les champs sont obligatoires"));
            exit();
        }

        if ($age < 1) {
            header("Location: index.php?error=" . urlencode("Âge invalide"));
            exit();
        }

        ajoutPatient($nom, $age, $classe);

    }

    require 'Vue/FormReservation.html.php';

}

function erreur($msgErreur)
{
    require 'Vue/vueErreur.php';
}

function attributlit()
{
    require 'Vue/AttributionLit.html.php';
}

?>