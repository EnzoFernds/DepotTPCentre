<?php

//connexion à la BDD
function getBdd()
{
    $bdd = new PDO('mysql:host=localhost;dbname=centre_convalescense;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $bdd;
}

function getPatients($search = '')
{
    $bdd = getBdd();

    $sql = "
        SELECT 
            patient.id_patient,
            patient.nom,
            patient.age,
            patient.id_lit,
            lit.id_lit,
            chambre.numero_chambre,
            chambre.id_etage
        FROM patient
        JOIN lit     ON patient.id_lit     = lit.id_lit
        JOIN chambre ON lit.id_chambre     = chambre.id_chambre
    ";

    // Si on a un mot-clé, on ajoute le WHERE
    if ($search !== '') {
        $sql .= "
          WHERE patient.nom   LIKE :search
        ";
    }

    $stmt = $bdd->prepare($sql);

    if ($search !== '') {
        $stmt->execute([':search' => "%{$search}%"]);
    } else {
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        } else {
            $update = $bdd->prepare("UPDATE patient SET etat = 1 WHERE id_patient = :id_patient;");
            $update->execute([
                ':id_patient' => $id_patient
            ]);
        }

        header("Location: index.php?action=Attribution Lit&id_lit=$id_lit");
        exit();
    } catch (Exception $e) {
        erreur($e->getMessage());
    }
}


function compterLitsOccupesParEtage($id_etage)
{
    $bdd = getBdd();
    $sql = "
        SELECT COUNT(*) 
        FROM lit 
        INNER JOIN chambre ON lit.id_chambre = chambre.id_chambre
        WHERE chambre.id_etage = :id_etage AND lit.EstOccupe = 1";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':id_etage', $id_etage, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function compterLitsTotalParEtage($id_etage)
{
    $bdd = getBdd();
    $sql = "
        SELECT COUNT(*) 
        FROM lit 
        INNER JOIN chambre ON lit.id_chambre = chambre.id_chambre
        WHERE chambre.id_etage = :id_etage";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':id_etage', $id_etage, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getChambresEtOccupationParEtage($id_etage)
{
    $bdd = getBdd();
    $stmt = $bdd->prepare("
        SELECT 
            c.id_chambre, 
            c.numero_chambre, 
            COUNT(l.id_lit) AS nb_lits_total,
            SUM(l.EstOccupe = 1) AS nb_lits_occupees
        FROM chambre c
        LEFT JOIN lit l ON l.id_chambre = c.id_chambre
        WHERE c.id_etage = :id_etage
        GROUP BY c.id_chambre, c.numero_chambre
        ORDER BY c.numero_chambre
    ");
    $stmt->bindParam(':id_etage', $id_etage, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function supprimerPatientBD($id)
{
    $bdd = getBdd();
    $stmt = $bdd->prepare("DELETE FROM patient WHERE id_patient = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
