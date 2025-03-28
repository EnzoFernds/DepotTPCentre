<?php
function getPatient()
{
    $bdd = new PDO(
        'mysql:host=localhost;dbname=centre_convalescense ;charset=utf8',
        'root',
        '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $patient = $bdd->query("SELECT * FROM `patient`");
    return $patient;
}