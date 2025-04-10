<?php
    if (isset($_GET['success']) && $_GET['success'] == "true" && isset($_GET['id_lit'])) {
        $idLit = htmlspecialchars($_GET['id_lit']);
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Patient ajouté !',
                    text: 'Lit attribué : #$idLit',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    } elseif (isset($_GET['error'])) {
        $error = htmlspecialchars($_GET['error']);
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Erreur !',
                    text: '$error',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
?>
