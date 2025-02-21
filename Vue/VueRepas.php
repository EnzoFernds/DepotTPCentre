<title><?=$title="Accueil";?></title>
<?php ob_start();?>
<body>
    <!-- contenu de la page -->
    <div class="contrainer">
        <!-- Le titre -->
        <div class="row">
            <div class="col">
                <h2 style="margin-left:50px">Repas</h2>
        </div>
</body>
<?php $contenu = ob_get_clean();?>
<?php require 'Gabarit/Gabarit.php';?>