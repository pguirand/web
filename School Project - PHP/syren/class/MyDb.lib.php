<?php
/**
 * Fichier contenant les fonctions de base de manipulation de la base
 */
/**
 * Classe permettant d'intéragir avec php sur la base
 *
 * @param bool $showerror Debug, affiche les erreurs Mysql
 * @param bool $showsql Debug, affiche les requêtes SQL
 * @param int $sqlcounter compteur pour le nombre de commandes SQL envoyées
 * @param int $rowcounter compteur pour le nombre de lignes renvoyées par un SELECT
 * @param int $dbtime compteur pour le temps écoulé pour effectuer les requêtes
 *
 * @todo Gérer les droits d'accès
 * @todo Ajouter des méthodes pour manipuler les procédures et les fonctions
 */
class MyDb
{
	public $mysqli;
	public $showerror = FALSE;
	public $showsql = FALSE;
	protected $sqlcounter = 0;
	protected $rowcounter = 0;
	protected $dbtime = 0;
	protected $starttime;
	function __construct($serveur = '')
	{
		if(isset($GLOBALS['SHOW_SQL']))
		{
			$this->showsql = $GLOBALS['SHOW_SQL'];
		}
		if(isset($GLOBALS['SHOW_SQL_ERRORS']))
		{
			$this->showerror = $GLOBALS['SHOW_SQL_ERRORS'];
		}
		if(empty($serveur) || $serveur == 'main')//'main' était l'encien code du serveur principal, on garde par sécurité avec des vieux scripts
		{
			$this->mysqli = @new mysqli($GLOBALS['SQL_SERVER'],$GLOBALS['SQL_LOGIN'],$GLOBALS['SQL_PASSWORD'],$GLOBALS['SQL_DATABASE']);
		}
		else
		{
			$this->mysqli = @new mysqli($GLOBALS['SQL_SERVER_' . strtoupper($serveur)],$GLOBALS['SQL_LOGIN_' . strtoupper($serveur)],$GLOBALS['SQL_PASSWORD_' . strtoupper($serveur)],$GLOBALS['SQL_DATABASE_' . strtoupper($serveur)]);
		}
		if(mysqli_connect_errno())
		{
			$this->printerror('<p style="color:#f00;"><span style="background-color:#fff;">Erreur de connection à la base : ' . mysqli_connect_error() . '</span></p>');
			$this->mysqli = FALSE;
			exit();
		}
		$this->starttime = $this->microtime_float();
	}
	function __destruct()
	{
		$this->close();//On ferme proprement la connexion mysql avant de partir.
	}
	function close()
	{
		if($this->mysqli)
		{
			$this->mysqli->close();
		}
		$this->mysqli = FALSE;
	}
	function query($sql)
	{//A ne pas utiliser, normalement les autres méthodes doivent suffir
		if($this->showsql === true)
		{
			$this->printsql($sql);
		}
		return $this->mysqli->query($sql);
	}
	function getMysqli()
	{
		return $this->mysqli;
	}
	function queryProcdureStockeeSimple($sql)
	{
		return $this->mysqli->query($sql);
	}
	function queryObjectArray($sql)
	{
		$this->sqlcounter++;
		$this->printsql($sql);
		$time1 = $this->microtime_float();
		$result = $this->mysqli->query($sql);
		$time2 = $this->microtime_float();
		$this->dbtime += ($time2 - $time1);
		if($result)
		{
			if($result->num_rows)
			{
				while($row = $result->fetch_object())
				{
					$result_array[] = $row;
				}
				$this->rowcounter += sizeof($result_array);
				return $result_array;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$this->printerror($sql . ' -> ' . $this->mysqli->error);
			return FALSE;
		}
	}
	function queryResult($sql, $mode = 'MYSQLI_STORE_RESULT')
	{
		$this->sqlcounter++;
		$this->printsql($sql);
		$time1 = $this->microtime_float();
		switch($mode)
		{
			case 'MYSQLI_USE_RESULT':
			case MYSQLI_USE_RESULT:
				$result = $this->mysqli->query($sql, MYSQLI_USE_RESULT);
			break;
			default:
				$result = $this->mysqli->query($sql);
			break;
		}
		$time2 = $this->microtime_float();
		$this->dbtime += ($time2 - $time1);
		if($result)
		{
			return $result;
		}
		else
		{
			$this->printerror($sql . ' -> ' . $this->mysqli->error);
			return FALSE;
		}
	}
	function queryArray($sql)
	{
		$this->sqlcounter++;
		$this->printsql($sql);
		$time1 = $this->microtime_float();
		$result = $this->mysqli->query($sql);
		$time2 = $this->microtime_float();
		$this->dbtime += ($time2 - $time1);
		if($result)
		{
			if($result->num_rows)
			{
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					$result_array[] = $row;
				}
				$this->rowcounter += sizeof($result_array);
				return $result_array;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$this->printerror($sql . ' -> ' . $this->mysqli->error);
			return FALSE;
		}
	}
	function querySingleItem($sql)
	{
		$this->sqlcounter++;
		$this->printsql($sql);
		$time1 = $this->microtime_float();
		$result = $this->mysqli->query($sql);
		$time2 = $this->microtime_float();
		$this->dbtime += ($time2 - $time1);
		if($result)
		{
			if($row = $result->fetch_array(MYSQLI_NUM))
			{
				$this->rowcounter++;
				return $row[0];
			}
			else
			{
				return -1;
			}
		}
		else
		{
			$this->printerror($sql . ' -> ' . $this->mysqli->error);
			return -1;
		}
	}
	function querySingleItemObject($sql)
	{
		$this->sqlcounter++;
		$this->printsql($sql);
		$time1 = $this->microtime_float();
		$result = $this->mysqli->query($sql);
		$time2 = $this->microtime_float();
		$this->dbtime += ($time2 - $time1);
		if($result)
		{
			if($result->num_rows)
			{
				$row = $result->fetch_object();
				return $row;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$this->printerror($sql . ' -> ' . $this->mysqli->error);
			return FALSE;
		}
	}
	function execute($sql)
	{
		$this->sqlcounter++;
		$this->printsql($sql);
		$time1  = $this->microtime_float();
		$result = $this->mysqli->real_query($sql);
		$time2  = $this->microtime_float();
		$this->dbtime += ($time2 - $time1);
		if($result)
		{
			return true;
		}
		else
		{
			$this->printerror($sql . ' -> ' . $this->mysqli->error);
			return FALSE;
		}
	}
	function insertId()
	{
		return $this->mysqli->insert_id;
	}
	function escape($txt)
	{
		return trim(addslashes($txt));
	}
	function escapequotes($txt)
	{
		if(empty($txt) && !is_numeric($txt))
		{
			return 'NULL';
		}
		else
		{
			return '"' . trim(addslashes($txt)) . '"';
		}
	}
	private function error()
	{
		return $this->mysqli->error;
	}
	private function printsql($sql)
	{
		if($this->showsql)
		{
			echo "<p style=\"color:#090;\"><span style=\"background-color:#fff;\">\n\t" . htmlspecialchars($sql) . "\n</span></p>\n";
		}
	}
	private function printerror($txt)
	{
		if($this->showerror)
		{
			echo '<p style="color:#f00;"><span style=\"background-color:#fff;\">' . htmlspecialchars($txt) . "</span></p>\n";
		}
	}
	function __tostring()
	{
		$totalTime = $this->microtime_float() - $this->starttime;
		$chaine = '<p style="color:#090;"><span style=\"background-color:#fff;\">Commande SQL : ' . $this->sqlcounter . "\n";
		$chaine .= '<br />Total du nb de lignes retournées : ' . $this->rowcounter . "\n";
		$chaine .= '<br />Total du temps d\'exécution la requête Mysql : ' . $this->dbtime . " sec\n";
		$chaine .= '<br />Temps de parsing PHP : ' . ($totalTime - $this->dbtime) . " sec\n";
		$chaine .= '<br />Temps écoulé depuis l\'initialisation de cet objet MyDb : ' . $totalTime . " sec</span></p>\n";
		return $chaine;
	}
	function resetStatistics()
	{
		$this->sqlcounter = 0;
		$this->rowcounter = 0;
		$this->dbtime = 0;
		$this->starttime = $this->microtime_float();
	}
	private function microtime_float()
	{
		list($usec, $sec) = explode(' ',microtime());
		return ((float)$usec + (float)$sec);
	}
}
?>
