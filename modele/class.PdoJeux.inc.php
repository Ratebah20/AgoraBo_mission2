<?php

/**
 *  AGORA
 * 	©  Logma, 2019
 * @package default
 * @author MD
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 * 
 * Classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application AGORA
 * Les attributs sont tous statiques,
 * $monPdo de type PDO 
 * $monPdoJeux qui contiendra l'unique instance de la classe
 */
class PdoJeux {

    private static $monPdo;
    private static $monPdoJeux = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
		// A) >>>>>>>>>>>>>>>   Connexion au serveur et à la base
		try {   
			// encodage
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''); 
			// Crée une instance (un objet) PDO qui représente une connexion à la base
			PdoJeux::$monPdo = new PDO(DSN,DB_USER,DB_PWD, $options);
			// configure l'attribut ATTR_ERRMODE pour définir le mode de rapport d'erreurs 
			// PDO::ERRMODE_EXCEPTION: émet une exception 
			PdoJeux::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// configure l'attribut ATTR_DEFAULT_FETCH_MODE pour définir le mode de récupération par défaut 
			// PDO::FETCH_OBJ: retourne un objet anonyme avec les noms de propriétés 
			//     qui correspondent aux noms des colonnes retournés dans le jeu de résultats
			PdoJeux::$monPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}
		catch (PDOException $e)	{	// $e est un objet de la classe PDOException, il expose la description du problème
			die('<section id="main-content"><section class="wrapper"><div class = "erreur">Erreur de connexion à la base de données !<p>'
				.$e->getmessage().'</p></div></section></section>');
		}
    }
	
    /**
     * Destructeur, supprime l'instance de PDO  
     */
    public function _destruct() {
        PdoJeux::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoJeux = PdoJeux::getPdoJeux();
     * 
     * @return l'unique objet de la classe PdoJeux
     */
    public static function getPdoJeux() {
        if (PdoJeux::$monPdoJeux == null) {
            PdoJeux::$monPdoJeux = new PdoJeux();
        }
        return PdoJeux::$monPdoJeux;
    }

     //==============================================================================
    //
    //  METHODES POUR LA GESTION DES MEMBRES
    //
    //==============================================================================
    //

    public function getUnMembre(string $loginMembre, string $mdpMembre): ?object {
        try {
            // préparer la requête
            $requete_prepare = PdoJeux::$monPdo->prepare(
            'SELECT idMembre, prenomMembre, nomMembre, mdpMembre, selMembre
            FROM membre
            WHERE loginMembre = :loginMembre');
            // associer les valeurs aux paramètres
            $requete_prepare->bindValue(':loginMembre', $loginMembre, PDO::PARAM_STR);
            // exécuter la requête
            $requete_prepare->execute();
            // récupérer l'objet
            if ($utilisateur = $requete_prepare->fetch()) {
                // vérifier le mot de passe
                $hash = hash('sha512', $mdpMembre . $utilisateur->selMembre);
                if ($hash == $utilisateur->mdpMembre) {
                    return $utilisateur;
                }
                else{
                    return NULL;
                }
            }
            else {
                return NULL;
            }
        } catch (PDOException $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
            .$e->getmessage().'</p></div>');
        }
    } 

   
    

	//==============================================================================
	//
	//	METHODES POUR LA GESTION DES GENRES
	//
	//==============================================================================
	
    /**
    * Retourne tous les genres sous forme d'un tableau d'objets 
    * 
    * @return array le tableau d'objets  (Genre)
    */

    public function getLesGenres(): array {
  		$requete =  ('SELECT idGenre as identifiant, libGenre as libelle 
						FROM genre 
						ORDER BY libGenre');
		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbGenres  = $resultat->fetchAll();	
			return $tbGenres;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

	
	/**
	 * Ajoute un nouveau genre avec le libellé donné en paramètre
	 * 
	 * @param string $libGenre : le libelle du genre à ajouter
	 * @return int l'identifiant du genre crée
	 */
    public function ajouterGenre(string $libGenre): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO genre "
                    . "(idGenre, libGenre) "
                    . "VALUES (0, :unLibGenre) ");
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	 /**
     * Modifie le libellé du genre donné en paramètre
     * 
     * @param int $idGenre : l'identifiant du genre à modifier  
     * @param string $libGenre : le libellé modifié
     */
    public function modifierGenre(int $idGenre, string $libGenre): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE genre "
                    . "SET libGenre = :unLibGenre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	/**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerGenre(int $idGenre): void {
       try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM genre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getLesPlateforme(): array {
        $requete =  'SELECT idPlateforme as identifiant, libPlateforme as libelle 
                      FROM plateforme 
                      ORDER BY libplateforme';
      try	{	 
          $resultat = PdoJeux::$monPdo->query($requete);
          $tbPlateformes  = $resultat->fetchAll();	
          return $tbPlateformes;		
      }
      catch (PDOException $e)	{  
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }


    /**
	 * Ajoute un nouveau genre avec le libellé donné en paramètre
	 * 
	 * @param string $libGenre : le libelle du genre à ajouter
	 * @return int l'identifiant du genre crée
	 */
    public function ajouterPlateforme(string $libPlateforme): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO Plateforme "
                    . "(idPlateforme, libPlateforme) "
                    . "VALUES (0, :unLibPlateforme) ");
            $requete_prepare->bindParam(':unLibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	


     /**
     * Modifie le libellé du genre donné en paramètre
     * 
     * @param int $idGenre : l'identifiant du genre à modifier  
     * @param string $libGenre : le libellé modifié
     */
    public function modifierPlateforme(int $idPlateforme, string $libPlateforme): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE plateforme "
                    . "SET libPlateforme = :unLibPlateforme "
                    . "WHERE genre.idPlateforme = :unIdPlateforme");
            $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unLibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }


    /**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerPlateforme(int $idPlateforme): void {
        try {
             $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM plateforme "
                     . "WHERE genre.idplateforme = :unIdplateforme");
             $requete_prepare->bindParam(':unIdplateforme', $idPlateforme, PDO::PARAM_INT);
             $requete_prepare->execute();
         } catch (Exception $e) {
             die('<div class = "erreur">Erreur dans la requête !<p>'
                 .$e->getmessage().'</p></div>');
         }
     }





     /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getLesMarque(): array {
        $requete =  'SELECT idMarque as identifiant, nomMarque as libelle 
                      FROM Marque 
                      ORDER BY nomMarque';
      try	{	 
          $resultat = PdoJeux::$monPdo->query($requete);
          $tbMarques  = $resultat->fetchAll();	
          return $tbMarques;		
      }
      catch (PDOException $e)	{  
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }


    /**
	 * Ajoute un nouveau genre avec le libellé donné en paramètre
	 * 
	 * @param string $libGenre : le libelle du genre à ajouter
	 * @return int l'identifiant du genre crée
	 */
    public function ajouterMarque(string $nomMarque): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO Marque "
                    . "(idMarque, NomMarque) "
                    . "VALUES (0, :unNomMarque) ");
            $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	


     /**
     * Modifie le libellé du genre donné en paramètre
     * 
     * @param int $idGenre : l'identifiant du genre à modifier  
     * @param string $libGenre : le libellé modifié
     */
    public function modifierMarque(int $idMarque, string $nomMarque): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE Marque "
                    . "SET nomMarque = :unnomMarque "
                    . "WHERE genre.idMarque = :unIdMarque");
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unnomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }


    /**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerMarque(int $idMarque): void {
        try {
             $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM Marque "
                     . "WHERE genre.idMarque = :unIdMarque");
             $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
             $requete_prepare->execute();
         } catch (Exception $e) {
             die('<div class = "erreur">Erreur dans la requête !<p>'
                 .$e->getmessage().'</p></div>');
         }
     }







    /**
    * Retourne tous les Pegi sous forme d'un tableau d'objets 
    * 
    * @return array le tableau d'objets  (Pegi)
    */
    public function getLesPegi(): array {
        $requete =  'SELECT idPegi as identifiant, ageLimite as age, descPegi as libelle 
                  FROM Pegi 
                  ORDER BY descPegi';
        try {	 
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbPegis  = $resultat->fetchAll();	
            return $tbPegis;		
        } catch (PDOException $e) {  
            die('<div class = "erreur">Erreur dans la requête !<p>'
            .$e->getmessage().'</p></div>');
        }
    }


   /**
    * Ajoute un nouveau Pegi avec l'age donné en paramètre
    * 
    * @param string $agePegi : l'age du Pegi à ajouter
    * @return int l'identifiant du Pegi crée
    */
    public function ajouterPegi(string $agePegi, string $descPegi): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO Pegi "
                . "(idPegi, ageLimite, descPegi)
                values (:unAgePegi, :unDescPegi)");
            $requete_prepare->bindParam(':unAgePegi', $agePegi, PDO::PARAM_STR);
            $requete_prepare->bindParam(':unDescPegi', $descPegi, PDO::PARAM_STR);
            $requete_prepare->execute();
        // récupérer l'identifiant crée
                return PdoJeux::$monPdo->lastInsertId();
                } catch (Exception $e) {
                die('<div class = "erreur">Erreur dans la requête !<p>'
                .$e->getmessage().'</p></div>');
            }
        }


    

// Modifie l'age du Pegi donné en paramètre
// @param int $idPegi : l'identifiant du Pegi à modifier
// @param string $agePegi : le age modifié
// @param string $descPegi : la description modifié

    public function modifierPegi(int $idPegi, string $agePegi, string $descPegi): void {
        try {
        $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE Pegi "
        . "SET ageLimite = :unAgePegi, descPegi = :unDescPegi "
        . "WHERE idPegi = :unIdPegi");
        $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unAgePegi', $agePegi, PDO::PARAM_STR);
        $requete_prepare->bindParam(':unDescPegi', $descPegi, PDO::PARAM_STR);
        $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
            .$e->getmessage().'</p></div>');
        }
    }

//     
// Supprime le Pegi donné en paramètre
// @param int $idPegi :l'identifiant du Pegi à supprimer
// 
    public function supprimerPegi(int $idPegi): void {
        try {
        $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM Pegi "
        . "WHERE idPegi = :unIdPegi");
        $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
        $requete_prepare->execute();
        } catch (Exception $e) {
        die('<div class = "erreur">Erreur dans la requête !<p>'
        .$e->getmessage().'</p></div>');
        }
    }



    /**
    * Retourne tous les jeux sous forme d'un tableau d'objets 
    * 
    * @return array le tableau d'objets  (Jeux)
    */
    public function getLesJeux(): array {
        $requete =  'SELECT refJeu as référence, idPlateforme as plateforme, 
                idPegi as Pegi, idGenre as genre, idMarque as Marque, nom as nomjeux,
                prix as prixJeux FROM jeu_video ORDER BY nom';
        try {	 
            $resultat = PdoJeux::$monPdo->query($requete);
            $tbJeux  = $resultat->fetchAll();	
            return $tbJeux;		
        } catch (PDOException $e) {  
            die('<div class = "erreur">Erreur dans la requête !<p>'
            .$e->getmessage().'</p></div>');
        }   
    }


    public function ajouterJeu(string $refJeu, int $idPlateforme, int $idPegi, int $idGenre, int $idMarque, string $nomJeux, float $prixJeux): void {
    try {
        $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO Jeux "
            . "(refJeu, idPlateforme, idPegi, idGenre, idMarque, nom, prix)
            values (:uneRefJeu, :unIdPlateforme, :unIdPegi, :unIdGenre, :unIdMarque, :unNomJeux, :unPrixJeux) ");
        $requete_prepare->bindParam(':uneRefJeu', $refJeu, PDO::PARAM_STR);
        $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unNomJeux', $nomJeux, PDO::PARAM_STR);
        $requete_prepare->bindParam(':unPrixJeux', $prixJeux, PDO::PARAM_STR);
        $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
            .$e->getmessage().'</p></div>');
        }
    }

    // Supprime le jeu donné en paramètre
    // @param int $idJeu :l'identifiant du jeu à supprimer
    // */
    public function supprimerJeu(int $idJeu): void {
        try {
        $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM jeu_video WHERE idJeu = :unIdJeu");
        $requete_prepare->bindParam(':unIdJeu', $idJeu, PDO::PARAM_INT);
        $requete_prepare->execute();
        } catch (Exception $e) {
        die('<div class = "erreur">Erreur dans la requête !<p>'
        .$e->getmessage().'</p></div>');
        }
    }

    }

    


?>