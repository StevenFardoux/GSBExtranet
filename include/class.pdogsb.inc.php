<?php

/** 
 * Classe d'accÃ¨s aux donnÃ©es. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb
{
    private static $serveur = 'mysql:host=localhost:3306';
    private static $bdd = 'dbname=gsbextranet';
    private static $user = 'root';
    private static $mdp = '';
    private static $monPdo;
    private static $monPdoGsb = null;

    /**
     * Constructeur privÃ©, crÃ©e l'instance de PDO qui sera sollicitÃ©e
     * pour toutes les mÃ©thodes de la classe
     */
    private function __construct()
    {

        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }
    public function _destruct()
    {
        PdoGsb::$monPdo = null;
    }
    /**
     * Fonction statique qui crÃ©e l'unique instance de la classe
 
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
     * @return l'unique objet de la classe PdoGsb
     */
    public  static function getPdoGsb()
    {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }
    /**
     * vÃ©rifie si le login et le mot de passe sont corrects
     * renvoie true si les 2 sont corrects
     * @param type $login
     * @param type $pwd
     * @return bool
     * @throws Exception
     */
    function checkUser($login, $pwd)
    {
        //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
        $user = false;
        $valideCompte = false;
        $token = false;
        $pdo = PdoGsb::$monPdo;
        $tab = array();
        $monObjPdoStatement = $pdo->prepare("SELECT motDePasse, token, valideCompte FROM medecin LEFT OUTER JOIN token ON medecin.id = token.idmedecin WHERE mail = :login");
        $bvc1 = $monObjPdoStatement->bindValue(':login', $login, PDO::PARAM_STR);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
            if (is_array($unUser)) {
                if ($pwd == $unUser['motDePasse']) {
                    $user = true;
                }
                $tab[] = $user;

                if ($unUser['token'] == null) {
                    $token = true;
                }
                $tab[] = $token;

                if ($unUser['valideCompte'] == 1) {
                    $valideCompte = true;
                }
                $tab[] = $valideCompte;
            }
        } else
            throw new Exception("erreur dans la requÃªte");
        return $tab;
    }

    /**
     * Il prend une chaîne comme argument et renvoie un tableau.
     * Renvoie le nom de connexion de l'utilisateur.
     * @param type $login
     * @return mixed
     * @throws Exception
     */
    function donneLeMedecinByMail($login)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT id, nom, prenom, mail, rpps FROM medecin WHERE mail= :login");
        $bvc1 = $monObjPdoStatement->bindValue(':login', $login, PDO::PARAM_STR);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
        } else
            throw new Exception("erreur dans la requéte");
        return $unUser;
    }

    function donneLeMedecinByToken($token)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT id, nom, prenom, mail, rpps FROM medecin LEFT OUTER JOIN token ON medecin.id = token.idmedecin WHERE token.token= :token");
        $bvc1 = $monObjPdoStatement->bindValue(':token', $token, PDO::PARAM_STR);
        if ($monObjPdoStatement->execute()) {
            $unUser = $monObjPdoStatement->fetch();
        } else
            throw new Exception("erreur dans la requéte");
        return $unUser;
    }

    /**
     * Il renvoie la longueur maximale du champ mail dans la table medecin
     * 
     * @return int
     */
    public function tailleChampsMail()
    {
        $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'medecin' AND COLUMN_NAME = 'mail'");
        $execution = $pdoStatement->execute();
        $leResultat = $pdoStatement->fetch();

        return $leResultat[0];
    }

    /**
     * Il prend deux paramètres, email et mdp, et les insère dans la base de données
     * Renvoie le résultat de l'exécution de la requête.
     * @param email
     * @param mdp
     * 
     * @return bool
     */
    public function creeMedecin($email, $mdp, $nom, $prenom, $rpps)
    {
        $pdo = PdoGsb::$monPdo;

        $pdoStatement = $pdo->prepare("SELECT mail FROM medecin WHERE mail = :email");
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->execute();

        if ($pdoStatement->rowCount() != 0) {
            return false;
        }

        $pdoStatement = $pdo->prepare("INSERT INTO medecin(nom, prenom, mail, motDePasse, rpps, dateCreation, dateConsentement) VALUES (:leNom, :lePrenom, :leMail, :leMdp, :leRpps, now(),now())");
        $pdoStatement->bindValue(':leMail', $email);
        $pdoStatement->bindValue(':leMdp', $mdp);
        $pdoStatement->bindValue(':leNom', $nom);
        $pdoStatement->bindValue(':lePrenom', $prenom);
        $pdoStatement->bindValue(':leRpps', $rpps);
        $exec1 = $pdoStatement->execute();

        $token = PdoGsb::getNewToken();
        $pdoStatement = $pdo->prepare("INSERT INTO token (idmedecin, token, datecreation) VALUES (LAST_INSERT_ID(), :leToken, now())");
        $pdoStatement->bindValue(':leToken', $token);
        $exec2 = $pdoStatement->execute();

        $pdoStatement = $pdo->prepare("INSERT INTO niveaudecompte (idDroit, id) VALUES (1, LAST_INSERT_ID())");
        $exec3 = $pdoStatement->execute();

        if ($exec1 && $exec2 && $exec3) {
            return array("email" => $email, "token" => $token);
        };
    }

    /**
     * Il vérifie si une adresse e-mail donnée est déjà dans la base de données.
     * 
     * @param email
     * @return bool
     */
    function testMail($email)
    {
        $pdo = PdoGsb::$monPdo;
        $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM medecin WHERE mail = :leMail");
        $bv1 = $pdoStatement->bindValue(':leMail', $email);
        $execution = $pdoStatement->execute();
        $resultatRequete = $pdoStatement->fetch();
        if ($resultatRequete['nbMail'] == 0)
            $mailTrouve = false;
        else
            $mailTrouve = true;

        return $mailTrouve;
    }

    /**
     * Il insère une nouvelle ligne dans la table historiqueconnexion avec la date et l'heure actuelles et le medecin.
     * 
     * @param id
     * @return bool
     */
    function ajouteConnexionInitiale($id)
    {
        $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(), now())");
        $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
        $execution = $pdoStatement->execute();
        return $execution;
    }

    /**
     * Enregistre la connexion de l'utilisateur par son email.
     * 
     * @param mail
     */
    function connexionInitiale($mail)
    {
        $pdo = PdoGsb::$monPdo;
        $medecin = $this->donneLeMedecinByMail($mail);
        $id = $medecin['id'];
        $this->ajouteConnexionInitiale($id);
    }

    /**
     * Il prend un identifiant en paramètre et renvoie le nom et le prénom du médecin avec cet
     * identifiant
     * 
     * @param id
     * @return user
     * @throws Exception
     */
    function donneinfosmedecin($id)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT id,nom,prenom FROM medecin WHERE id= :lId");
        $bvc1 = $monObjPdoStatement->bindValue(':lId', $id, PDO::PARAM_INT);
        if ($monObjPdoStatement->execute()) {
            return $monObjPdoStatement->fetch();
        } else
            throw new Exception("erreur");
    }

    function genToken()
    {
        if (function_exists("com_create_guid")) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }

    function getNewToken()
    {
        $token = null;

        while (true) {
            $token = strtolower($this->genToken());
            $monObjPdoStatement = PdoGsb::$monPdo->prepare("SELECT token from token WHERE token = :token;");
            $bvn = $monObjPdoStatement->bindValue(':token', $token);
            $monObjPdoStatement->execute();
            if ($monObjPdoStatement->rowCount() == 0) {
                break;
            }
        }

        return $token;
    }

    function validationToken($token)
    {
        $pdo = PdoGsb::$monPdo;

        $medecin = $this->donneLeMedecinByToken($token);

        if ($medecin == null) {
            return;
        }

        $monObjPdoStatement = $pdo->prepare("DELETE FROM token WHERE token = :token");
        $monObjPdoStatement->bindValue(':token', $token);
        $monObjPdoStatement->execute();

        $monObjPdoStatement = $pdo->prepare("SELECT mail FROM medecin 
        INNER JOIN niveaudecompte 
        ON medecin.id = niveaudecompte.id 
        WHERE niveaudecompte.idDroit = " . DROIT_VALIDATEUR . " OR niveaudecompte.idDroit = " . DROIT_ADMIN);
        $monObjPdoStatement->execute();

        $validateurs = $monObjPdoStatement->fetchAll();

        return array("medecin" => $medecin, "validateurs" => $validateurs);
    }

    function estValidateur()
    {
        if (!estConnecte()) {
            return false;
        }
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT idDroit FROM medecin INNER JOIN niveaudecompte ON niveaudecompte.id = medecin.id WHERE medecin.id = :id");
        $monObjPdoStatement->bindValue(':id', $_SESSION['id']);
        $monObjPdoStatement->execute();
        $resultat = $monObjPdoStatement->fetch();
        return $resultat['idDroit'] == 3 || $resultat['idDroit'] == 5;
    }

    function validationMedecin($id)
    {
        $pdo = PdoGsb::$monPdo;

        $monObjPdoStatement = $pdo->prepare("SELECT idDroit, token FROM medecin LEFT OUTER JOIN token ON medecin.id = token.idmedecin INNER JOIN niveaudecompte ON niveaudecompte.id = medecin.id WHERE medecin.id = :id");
        $monObjPdoStatement->bindValue(':id', $id);
        $monObjPdoStatement->execute();

        if (!$this->estValidateur() || $monObjPdoStatement->rowCount() == 0 || $monObjPdoStatement->fetch()['token'] != null) {
            return false;
        }

        $monObjPdoStatement = $pdo->prepare("UPDATE medecin SET valideCompte = 1 WHERE id = :id");
        $monObjPdoStatement->bindValue(':id', $id);
        return $monObjPdoStatement->execute();
    }

    function getDroitCompte($id)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT idDroit FROM niveaudecompte WHERE id = :id;");
        $bvc = $monObjPdoStatement->bindValue(':id', $id);
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetch()['idDroit'];
    }

    function getNomPrenomCompte($id)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT nom, prenom FROM medecin WHERE id = :id;");
        $bvc = $monObjPdoStatement->bindValue(':id', $id);
        $monObjPdoStatement->execute();

        if ($result = $monObjPdoStatement->fetch()) {
            return $result['nom'] . " " . $result['prenom'];
        } else {
            return "Inconnu";
        }
    }

    function maintenance($id)
    {
        $pdo = PdoGsb::$monPdo;
        $isMaintenance = PdoGsb::checkMaintenance();
        
        if ($this->getDroitCompte($id) != DROIT_ADMIN) return;

        $monObjPdoStatement = $pdo->prepare("UPDATE maintenance SET maintenance = :maintenance");
        $monObjPdoStatement->bindValue(':maintenance', $isMaintenance ? 0 : 1);
        $monObjPdoStatement->execute();

        // echo $isMaintenance ? "Maintenance désactivée" : "Maintenance activée";
    }

    function checkMaintenance()
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT maintenance FROM maintenance");
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetch()['maintenance'];
    }

    function getProduits() {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT * FROM produit");
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, 'Produit');
    }

    function getProduitsByChef($id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare("SELECT * FROM produit where idChefProd = :id");
        $bvc = $monObjPdoStatement->bindValue(":id",$id);
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetchAll(PDO::FETCH_CLASS, 'Produit');
    }

    function getVisoFutur()
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT id, nomVisio, objectif, url, dateVisio FROM visioconference WHERE dateVisio >= now()');
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetchAll();
    }

    function getVisioByMedecinId($id)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT id, nomVisio, objectif, url, dateVisio FROM visioconference V INNER JOIN medecinvisio M 
                                             ON v.id = m.idVisio WHERE idMedecin = :id');
        $bvc = $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetchAll();
    }

    function insertInscripVisioByMedecin($idVisio, $id)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('INSERT INTO medecinVisio VALUES(:idMedecin, :idVisio, now())');
        $bvc = $monObjPdoStatement->bindValue(":idMedecin", $id);
        $bvc = $monObjPdoStatement->bindValue(":idVisio", $idVisio);
        $monObjPdoStatement->execute();
    }

    function getAvisByVisio($idVisio)
    {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT description, valider FROM avisvisio AV INNER JOIN avis A ON AV.idAvis = A.idAvis
                                             WHERE idVisio = :id;');
        $bvc = $monObjPdoStatement->bindValue(":id", $idVisio);
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetchAll();
    }

    function insertAvisByVisio($idVisio, $text) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('INSERT INTO avis VALUES(null, :text, 0);
                                             INSERT INTO avisvisio VALUES((SELECT MAX(idAvis) FROM avis), :id);');
        $bvc = $monObjPdoStatement->bindValue(':text', $text);
        $bvc = $monObjPdoStatement->bindValue(':id', $idVisio);
        $monObjPdoStatement->execute();
    }

    function getAvis() {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT idAvis, description, valider FROM avis');
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetchAll();
    }
    
    function acceptAvis($id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('UPDATE avis SET valider = 1 WHERE idAvis = :id;');
        $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();
    }

    function refuseAvis($id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('DELETE FROM avis WHERE idAvis = :id;');
        $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();
    }

    function addVisio($nom, $objectif, $url, $date, $id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('INSERT INTO visioconference VALUES(null, :nom, :objectif, :url, :date, :id);');
        $monObjPdoStatement->bindValue(":nom", $nom);
        $monObjPdoStatement->bindValue(":objectif", $objectif);
        $monObjPdoStatement->bindValue(":url", $url);
        $monObjPdoStatement->bindValue(":date", $date);
        $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();
    }

    function delVisio($id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('DELETE FROM visioconference WHERE id = :id');
        $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();
    }

    function getVisioByIdChef($id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT id, nomVisio, objectif, url, dateVisio FROM visioconference WHERE idChefProd = :id');
        $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetchAll();
    }

    function getVisioById($id) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT nomVisio, objectif, url, dateVisio FROM visioconference WHERE id = :id');
        $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();

        return $monObjPdoStatement->fetch();
    }

    function modifVisio($id, $nom, $objectif, $url, $date) {
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('UPDATE visioconference SET nomVisio = :nom, objectif = :objectif, url = :url, dateVisio = :date WHERE id = :id;');
        $monObjPdoStatement->bindValue(":nom", $nom);
        $monObjPdoStatement->bindValue(":objectif", $objectif);
        $monObjPdoStatement->bindValue(":url", $url);
        $monObjPdoStatement->bindValue(":date", $date);
        $monObjPdoStatement->bindValue(":id", $id);
        $monObjPdoStatement->execute();

    }

    function getProByIdChef($id){
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT nom,objectif,information,effetIndesirable,image,idChefProd from produit WHERE idChefProd = :id ;');
        $monObjPdoStatement->bindValue(":id",$id);
        $monObjPdoStatement->execute();
    }
    function getProdById($id){
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('SELECT nom,objectif,information,effetIndesirable,image FROM produit WHERE id = :id;');
        $monObjPdoStatement->bindValue(":id",$id);
        $monObjPdoStatement->execute();
    }
    function delProd($idProd){
        $pdo = PdoGsb::$monPdo;
        $monObjPdoStatement = $pdo->prepare('DELETE FROM produit WHERE id = :id;');
        $monObjPdoStatement->bindValue(":id",$idProd);
        $monObjPdoStatement->execute();
    }
}
