<?php
require "Repository/repository.php";
function accueil()
{
    require 'Vue/Vueaccueil.php';
}

function etages()
{
    require 'Vue/VueEtages.php';
}

function patients()
{
    $patient=getPatient();
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
function deluser()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $userId = (int) $_POST['user_id'];
        
        $deleted = delPatients($userId);
    
        if ($deleted) {
            header('Location: index.php?action=delete_user.php');
        } else {
            echo "Erreur lors de la suppression.";
        }
    }
    require 'Vue/delete_user.php';
}
?>