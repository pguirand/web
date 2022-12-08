<?php
#==================================================
#	POUR VERIFIER L'EXISTENCE D'UNE VALEUR
#==================================================
function verify_value ($db,$table,$field,$value)
	{
// Connexion et sélection de la base
		$link = mysql_connect("localhost", "root", "")
			or die("Impossible de se connecter");
//		echo "Connexion réussie";
		mysql_select_db("syren") or die("Could not select database");	
		
		// Exécuter des requêtes SQL
		$query = "SELECT * FROM ".$table." WHERE ".$field." = '".$value."'";
		$result = mysql_query($query) or die("Query failed");
		while ($line = mysql_fetch_assoc($result)) {
			foreach ($line as $col_value) {
				if ($col_value == $value)
					$value_exist = "1";
			}
		}
		return $value_exist;
		
		// Libération des résultats 
		mysql_free_result($result);
		
		// Fermeture de la connexion 
		mysql_close($link);
	
	}

?>