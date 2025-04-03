<?php

//connexion à la BDD
function getBdd()
{
    $bdd = new PDO('mysql:host=localhost;dbname=centre_convalescense;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $bdd;
}
function getPatient()
{
    $bdd = getBdd();

    $patient = $bdd->query("SELECT * FROM `patient`");
    return $patient;
}

function getTauxOccupation()
{
    $bdd = getBdd();

    // Préparer la requête SQL pour appeler la fonction stockée
    $stmt = $bdd->prepare("SELECT taux_remplissage()");

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}