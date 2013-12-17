<?php

   $connexion = mysql_connect("localhost", "root", "");
	mysql_select_db("etunote",$connexion);

if (isset ($_GET['nom'])) {	
	extract($_GET);
	getDonnee($nom, html_entity_decode($cours));
}

function getDonnee($etu, $cours) {
	$sql = "SELECT n.etu, n.note, n.maj, n.exercice, n.cours
		FROM notes n 
		WHERE n.etu = '".$etu."' AND n.cours = '".$cours."'
		ORDER BY n.exercice";
	
	//echo $sql;
	$rs = mysql_query($sql) or die('Requéte invalide : ' . mysql_error());
	$arrG = array();
	While ($arr = mysql_fetch_array($rs)){
		$arrG[] = $arr;
	}
	echo json_encode($arrG);
	
}

function getCours() {
	$sql = "SELECT DISTINCT n.cours
		FROM notes n
		ORDER by n.cours";
	
	//echo $sql;
	$rs = mysql_query($sql) or die('Requete invalide : ' . mysql_error());
	$options = "";
	While ($arr = mysql_fetch_array($rs)){
		$options .= '<option>'.$arr['cours'].'</option>';
	}
	return $options;
	
}

?>
