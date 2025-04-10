<title><?= $title = "Erreur"; ?></title>
<?php ob_start(); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "<?= addslashes($msgErreur) ?>",
            confirmButtonColor: '#d33',
            confirmButtonText: 'Fermer'
        }).then(() => {
            window.history.back(); // Retour à la page précédente après fermeture
        });
    });
</script>

<?php $contenu = ob_get_clean(); ?>
<?php require 'Gabarit/Gabarit.php'; ?>
