<?php
    require('Controleur/controleur.php');
    try {
        if (isset($_GET['action']))
        {
            switch($_GET['action'])
            {  
                case 'Accueil':
                    accueil();break;
                case 'Étages':
                    etages();break;
                case 'Patients':
                    patients();break;
                case 'Repas':
                    repas();break;
                case 'Formulaire Réservation':
                    formreserv();break;
            }
        }
        else 
        {
            accueil();
        }
            }
catch (Exception $e)
{
    erreur ($e->getMessage());
}