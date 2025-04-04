<?php
require 'Repository/repository.php';

function accueil()
{
    $result = getTauxOccupation();
    $tauxEtg1 = getTauxRempEtg(1);
    $tauxEtg2 = getTauxRempEtg(2);
    $tauxEtg3 = getTauxRempEtg(3);
    $tauxCls1 = getTauxOccupationCls();
    require 'Vue/Vueaccueil.php';
}

function etages()
{
    require 'Vue/VueEtages.php';
}

function patients()
{
    require 'Vue/VuePatient.php';
}

function repas()
{
    require 'Vue/VueRepas.php';
}

function formreserv()
{
    require 'Vue/FormReservation.html';
}

?>