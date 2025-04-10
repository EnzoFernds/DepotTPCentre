<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Réservation</title>
    <link rel="stylesheet" href="Style/styleForm.css">
</head>
<body>
    <h2>Réservation</h2>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == "true") {
        echo "<p style='color: green;'>Réservation enregistrée avec succès !</p>";
    } elseif (isset($_GET['error'])) {
        echo "<p style='color: red;'>Erreur : " . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>

    <form action="index.php?action=Attribution Lit" method="POST">
        <label for="nom">Nom/Prénom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="age">Âge :</label>
        <input type="number" id="age" name="age" required min="1">

        <label for="classe">Genre :</label>
        <select id="classe" name="classe" required>
            <option value="1">Homme</option>
            <option value="2">Femme</option>
            <option value="3">Enfant</option>
        </select>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>