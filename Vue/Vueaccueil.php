<title><?=$title="Accueil";?></title>
<?php ob_start();?>

<body>
    <div class="container mt-4">
        <!-- Le titre -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="text-center">Accueil</h2>
            </div>
        </div>

        <!-- Section avec des cartes -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <!-- <img src="https://via.placeholder.com/300" class="card-img-top" alt="Image 1"> -->
                    <div class="card-body">
                        <h5 class="card-title">Titre 1</h5>
                        <p class="card-text">Description rapide du contenu présenté ici.</p>
                        <a href="#" class="btn btn-primary">En savoir plus</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <!-- <img src="https://via.placeholder.com/300" class="card-img-top" alt="Image 2"> -->
                    <div class="card-body">
                        <h5 class="card-title">Titre 2</h5>
                        <p class="card-text">Une autre description de section ou d'article.</p>
                        <a href="#" class="btn btn-primary">Découvrir</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <!-- <img src="https://via.placeholder.com/300" class="card-img-top" alt="Image 3"> -->
                    <div class="card-body">
                        <h5 class="card-title">Titre 3</h5>
                        <p class="card-text">Une autre section intéressante à explorer.</p>
                        <a href="#" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php $contenu = ob_get_clean();?>
<?php require 'Gabarit/Gabarit.php';?>