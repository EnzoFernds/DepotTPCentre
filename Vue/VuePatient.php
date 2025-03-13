<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="Style/navBarStyle.css">
<title><?= $title = "Accueil"; ?></title>
<?php ob_start(); ?>

<body>
  <!-- contenu de la page -->
  <div class="contrainer">
    <!-- Le titre -->
    <div class="row">
      <div class="col">
        <h2 style="margin-left:50px">Patients</h2>

        <body>
          <div class="topnav">
            <div class="search-container">
              <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
              </form>
            </div>
          </div>
        </body>

        </html>

      </div>
</body>
<?php $contenu = ob_get_clean(); ?>
<?php require 'Gabarit/Gabarit.php'; ?>