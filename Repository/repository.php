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

function ajoutPatient($nom, $age, $classe)
{
    try {
        $bdd = getBdd();

        $sql = "INSERT INTO patient (nom, age, classe) VALUES (:nom, :age, :classe)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':classe', $classe);

        $stmt->execute();

        $id_patient = $bdd->lastInsertId();

        // Appel de la fonction stockée pour trouver un lit disponible
        $sql = "SELECT trouver_lit_disponible(:classe) AS id_lit";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([':classe' => $classe]);

        // Récupérer le résultat du SELECT
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_lit = $result['id_lit'];

        // Si un lit est trouvé, on l'attribue au patient
        if ($id_lit !== null && $id_lit != -1) {
            $update = $bdd->prepare("UPDATE patient SET id_lit = :id_lit WHERE id_patient = :id_patient");
            $update->execute([
                ':id_lit' => $id_lit,
                ':id_patient' => $id_patient
            ]);
        }

        header("Location: index.php?action=Attribution Lit&id_lit=$id_lit");
        exit();
    } catch (Exception $e) {
        erreur($e->getMessage());
    }
}