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

    $patient = $bdd->query("SELECT * FROM `patient` 
    INNER JOIN lit ON patient.id_lit = lit.id_lit 
    INNER JOIN chambre ON lit.id_chambre = chambre.id_chambre");
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
function delPatients($id_patient)
{
    $bdd = getBdd();

    $patient = $bdd->prepare("DELETE FROM patientWHERE id_patient = :id_patient");
    $patient->bindParam(':id_patient',$id_patient,PDO::PARAM_INT);
    $patient->execute();
    return $patient;
}