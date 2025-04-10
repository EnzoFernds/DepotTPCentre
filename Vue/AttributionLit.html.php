<?php
// Vérifie si l'ID du lit est passé en paramètre dans l'URL
$id_lit = isset($_GET['id_lit']) ? $_GET['id_lit'] : null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Réservation</title>
    <link rel="stylesheet" href="Style/styleForm.css">
</head>

<body>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const idLit = "<?php echo $id_lit; ?>";
            console.log('idLit:', idLit); // Affiche dans la console pour déboguer

            Swal.fire({
                title: 'Patient ajouté !',
                text: idLit ? 'Lit attribué : #' + idLit : 'Aucun lit attribué.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'index.php?action=Accueil'; // Redirige vers la page d'accueil
            });
        });
    </script>
</body>

</html>
