
<?php
require_once("include/produits.php");
require_once("include/fct.inc.php");
require_once("include/class.pdogsb.inc.php");

define("DROIT_MEDECIN", "1");
define("DROIT_CHEFPROD", "2");
define("DROIT_VALIDATEUR", "3");
define("DROIT_MODERATEUR", "4");
define("DROIT_ADMIN", "5");

session_start();



date_default_timezone_set('Europe/Paris');



if (empty($_GET)) {
	deconnecter();
}

$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
$isMaintenance = $pdo->checkMaintenance();

if (!isset($_GET['uc'])) {
	$_GET['uc'] = 'connexion';
} else {
	if ($_GET['uc'] == "connexion" && !estConnecte()) {
		$_GET['uc'] = 'connexion';
	}
}

if ($_GET["uc"] != "connexion" && $isMaintenance && ((estConnecte() && $pdo->getDroitCompte($_SESSION["id"]) != DROIT_ADMIN) || !estConnecte())) {
	include('vues/v_maintenance.php');
	die();
}

if ($estConnecte) {
	$droit = $pdo->getDroitCompte($_SESSION["id"]);
	$nomPrenom = $pdo->getNomPrenomCompte($_SESSION["id"]);
}


$uc = $_GET['uc'];
switch ($uc) {
	case 'connexion': {
			include("controleurs/c_connexion.php");
			break;
		}
	case 'creation': {
			include("controleurs/c_creation.php");
			break;
		}
	case 'inscription': {
			include("controleurs/c_inscription.php");
			break;
		}
	case 'consulter': {
			include("controleurs/c_consulter.php");
			break;
		}
	case 'maintenance': {
			include("controleurs/c_maintenance.php");
			break;
		}
	case 'avis': {
			include("controleurs/c_avis.php");
			break;
		}
	case 'visio': {
			include('controleurs/c_visio.php');
			break;
	}
	case 'prod':{
			include('controleurs/c_prod.php');
			break;
	}
	}
?>







