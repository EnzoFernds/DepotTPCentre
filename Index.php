<?php
    require('Controleur/controleur.php');
    try {
        if (isset($_GET['action']))
        {
            switch($_GET['action'])
            {  
                case 'Accueil':
                    accueil();break;
                case 'Etages':
                    etages();break;
                case 'Patients':
                    patients();break;
                case 'Formulaire Réservation':
                    formreserv();break;
                case 'Attribution Lit';
                    attributlit();break;
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