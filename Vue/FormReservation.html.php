<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - Centre de Convalescence</title>
    <link rel="stylesheet" href="Style/StyleFormReserv.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="form-container">
    <h2>Réserver un lit</h2>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == "true") {
        echo "<div class='alert success'>🎉 Réservation enregistrée avec succès !</div>";
    } elseif (isset($_GET['error'])) {
        echo "<div class='alert error'>❌ Erreur : " . htmlspecialchars($_GET['error']) . "</div>";
    }
    ?>

    <form method="POST" action="">
        <div class="input-group">
            <label for="nom">Nom / Prénom</label>
            <input type="text" id="nom" name="nom" placeholder="Jean Dupont" required>
        </div>

        <div class="input-group">
            <label for="age">Âge</label>
            <input type="number" id="age" name="age" min="1" placeholder="45" required>
        </div>

        <div class="input-group">
            <label for="classe">Genre</label>
            <select id="classe" name="classe" required>
                <option value="" disabled selected>Choisissez un genre</option>
                <option value="1">Homme</option>
                <option value="2">Femme</option>
                <option value="3">Enfant</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">✅ Réserver</button>
    </form>
</div>

</body>
</html>
