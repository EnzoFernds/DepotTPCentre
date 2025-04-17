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

    // Exécuter la requête SQL
    $stmt = $bdd->prepare("SELECT taux_remplissage() AS taux");
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si 'taux' existe dans le tableau et retourne la valeur correcte
    if (isset($result['taux'])) {
        return $result['taux'];
    } else {
        return "Non disponible";
    }
}

function getTauxRempEtg($etage_id)
{
    $bdd = getBdd();

    $stmt = $bdd->prepare("SELECT taux_remplissage_etage(:etage_id) AS taux");

    $stmt->bindParam(':etage_id', $etage_id, PDO::PARAM_INT);
    $stmt->execute();
    $tauxEtg = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie si 'taux' existe dans le tableau et retourne la valeur correcte
    return isset($tauxEtg['taux']) ? $tauxEtg['taux'] : "Non disponible";
}

function getTauxOccupationCls($classe_id)
{
    $bdd = getBdd();

    $stmt = $bdd->prepare("SELECT taux_occupation_classe(:classe_id) AS taux");

    $stmt->bindParam(':classe_id', $classe_id, PDO::PARAM_INT);
    $stmt->execute();
    $tauxCls = $stmt->fetch(PDO::FETCH_ASSOC);

    return isset($tauxCls['taux']) ? $tauxCls['taux'] : "Non disponible";
}