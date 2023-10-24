  <!DOCTYPE html>
  <html lang="fr">

  <head>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <title>GSB -extranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/profilcss/profil.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body background="assets/img/laboratoire.jpg">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Galaxy Swiss Bourdin</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <?php if ($droit == DROIT_MEDECIN) : ?>
              <li class="<?= $_GET['uc'] == 'inscription' && $_GET['action'] == 'demandeVisio' ? 'active' : '' ?>"><a href="index.php?uc=inscription&action=demandeVisio">M'inscrire à une visio</a></li>
              <li class="<?= $_GET['uc'] == 'consulter' && $_GET['action'] == 'visio' ? 'active' : '' ?>"><a href="index.php?uc=consulter&action=visio">Consulter Visio</a></li>
              <li class="<?= $_GET['uc'] == 'consulter' && $_GET['action'] == 'prod' ? 'active' : '' ?>"><a href="index.php?uc=consulter&action=prod">Consulter les Produits</a></li>
            <?php elseif ($droit == DROIT_ADMIN) : ?>
              <li><a href="index.php?uc=maintenance&action=maintenance"><?= $isMaintenance ? "Retirer la maintenance" : "Mettre en maintenance" ?></a></li>
            <?php elseif ($droit == DROIT_MODERATEUR) : ?>
              <li class="<?= $_GET['uc'] == 'consulter' && $_GET['action'] == 'visio' ? 'active' : '' ?>"><a href="index.php?uc=consulter&action=visio">vérification des avis sur les Visio</a></li>
            <?php elseif ($droit == DROIT_CHEFPROD) : ?>
              <li class="<?= $_GET['uc'] == 'consulter' && $_GET['action'] == 'prod' ? 'active' : '' ?>"><a href="index.php?uc=consulter&action=ChefProd">Consulter les Produits</a></li>
              <li class="<?= $_GET['uc'] == 'consulter' && $_GET['action'] == 'visio' ? 'active' : '' ?>"><a href="index.php?uc=consulter&action=Chefvisio">Consulter Visio</a></li>
            <?php endif; ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a><?php echo $nomPrenom ?></a></li>
            <li><a>Médecin</a></li>

          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>




    <div class="page-content">
      <div class="row">