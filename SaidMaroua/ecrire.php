<?php

if (isset ($_GET['nom'])) {

	$connexion = mysql_connect("localhost", "root", "");
	mysql_select_db("etunote",$connexion);
		
	extract($_GET);
	enregister($nom, html_entity_decode($cours));
	echo $nom . " Ã  " . date("H:i") . " a eu la note $note pour l'exercice : ". $exe." du cours ".$cours;
	//echo "L'Ã©tudiant(e) ".$nom . " est ".$raison." le ".date("H:i") . " au cours ".$cours;
}else{
	echo "Y'a RIEN !!";
}

function enregister($etu, $exe, $note, $cours) {

	//$date= date("Y-m-j H:i:s");
	$sql = "INSERT INTO notes(etu, exercice, cours, note, maj) VALUES ('$etu', '$exe', '$cours', $note, NOW()) ";
	//$sql = "INSERT INTO historique(etudiant, cours, maj) VALUES ('$etu', '$cours', NOW()) ";
	mysql_query($sql) or die('RequÃªte invalide : ' . mysql_error());
}
	
require_once 'lire.php';
$options = getCours();
?>
<html>
	<head>
		<title>Evaluation des Etudiants</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
		<script type="text/javascript" src="js/jquery.min.js"></script>
		
	</head>
	<body >		
	<?php 
    $xml = simplexml_load_file("https://picasaweb.google.com/data/feed/base/user/112537161896190034287/albumid/5931538032377292977?alt=rss&kind=photo&authkey=Gv1sRgCJjJwc265LnxigE&hl=fr");
	//local
	
	//$xml = simplexml_load_file("http://localhost/trombino/trombino/data/5795380358275112865.xml");
	
	$i=0;
	
	foreach ($xml->channel->item as $item){
		if($i % 2 == 0) $c = 'good'; else $c = 'bad'; 
		
		
		
		echo "<div id='etu_".$i."' class='conteneur' >";
			echo "<div class='bloc' >";
				echo "<img title='récupérer les notes' src='img/SearchRecord.png' class='btn' onclick='getNote(".$i.")' />";
				echo '<br/><label>Cours : </label>
				<select id="cours_'.$i.'" name="listeCours" id="listeCours">
					<option value=""></option>
					'.$options.'
				</select> 
				<img title="ajouter un cours" src="img/AddRecord.png" class="btn" onclick="ajoutCours('.$i.')" style="vertical-align:middle;" />';
				
				echo "<br/><label>Exercice : </label><br/><input id='exe_".$i."' />";
				echo "<br/><label>Note : </label><input id='note_".$i."' size='3' />";
				
				echo "<img title='ajouter une note' src='img/AddRecord.png' class='btn' onclick='ajoutNote(".$i.")' style='vertical-align:middle;' />";
				echo "<br/>Moyenne :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total :
				<br/><label class='note' id='moyenne_".$i."' ></label>&nbsp;<label class='note' id='note_total_".$i."' ></label>";
				
			echo "</div>";
			echo "<div class='bloc' >";
				echo "<img id='etu_tof_".$i."' src='".$item->enclosure['url']."' class='tof' onclick='getRaison(".$i.")' />";
				echo "<div class='$c' id='etu_nom_".$i."'>".$item->title."</div>";
			echo "</div>";
			echo "<div class='bloc' >Note pondérée
				<br/><input id='max_".$i."' value='40' size='3' /> sur <input id='sur_".$i."' value='20' size='3' />
				<br/><div class='note' id='note_sur_".$i."'></div>
				</div>";		
			echo "<div id='etu_svg_".$i."' class='bloc' ></div>";
		echo "</div>";
		
		$i++;
	}
	?>
	</body>
</html>
