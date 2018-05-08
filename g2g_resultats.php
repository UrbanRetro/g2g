<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Grappe 2 Glass</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<?php

error_reporting(E_ALL);
	try
	{
		// On se connecte à MySQL
		$bdd = new PDO('mysql:host=localhost:3306;dbname=bars;charset=utf8', 'grapeglapuperson', 'QEiw7dFQutLb', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
		// En cas d'erreur, on affiche un message et on arrête tout

		die('Erreur : ' . $e->getMessage());
	}
	?>

	<div style="margin:20px;">
	<h1 style="text-align: center;">Grappe 2 Glass</h1>

	<p>Bonjour !</p>

	<p>Tu recherches un bar de type <b><?php echo htmlspecialchars($_POST['categorie']); ?></b> avec une ambiance <b><?php echo htmlspecialchars($_POST['ambiance1'])?></b> et <b><?php echo htmlspecialchars($_POST['ambiance2'])?></b> ainsi que <b><?php echo htmlspecialchars($_POST['ambiance3'])?></b> pour y aller <b><?php echo htmlspecialchars($_POST['occasion'])?></b> </p>

	<pL>Le bar idéal a les caractéristiques suivantes : <b><?php echo htmlspecialchars($_POST['feature1'])?></b>, <B><?php echo htmlspecialchars($_POST['feature2'])?></B> et <b><?php echo htmlspecialchars($_POST['feature3'])?></b></p>

	<p>Si tu veux changer de description, <a href="form.php">clique ici</a> pour revenir à la page de selection.</p></div>
	<hr>

	<?php


	$reponse = $bdd->prepare(
		'SELECT *
		FROM BARS WHERE (Category_1 = ? OR Category_2 = ?)'
	);
	$rrr = $reponse->execute(
		array($_POST['categorie'], $_POST['categorie'])
	); 

	while ($donnees = $reponse->fetch(PDO::FETCH_ASSOC)) {


//	echo '<li>' . $donnees['ID'] .', ' . $donnees['Name'] .', '. $donnees['Category_1'] .', '. $donnees['Ambiance_1'] . ', ' . $donnees['Feature_1'] . ', ' . $donnees['Occasion_1'] .'</li>';

	$donnees['ambiances'] = array_filter([$donnees['Ambiance_1'], $donnees['Ambiance_2'], $donnees['Ambiance_3']]);
	$donnees['occasions'] = array_filter([$donnees['Occasion_1'], $donnees['Occasion_2'], $donnees['Occasion_3'], $donnees['Occasion_4'], $donnees['Occasion_5']]);
	$donnees['features']  = array_filter([$donnees['Feature_1'], $donnees['Feature_2'], $donnees['Feature_3']]);

	$monTableau[] = $donnees;
}

$ambiances = array_filter([$_POST['ambiance1'], $_POST['ambiance2'], $_POST['ambiance3']]);
$occasions = array_filter([$_POST['occasion']]);
$features  = array_filter([$_POST['feature1'], $_POST['feature2'], $_POST['feature3']]);



foreach ($monTableau as $key => $value) 
{

	$interesection_ambiances = array_intersect($ambiances, $value['ambiances']);
	$interesection_occasions = array_intersect($occasions, $value['occasions']);
	$interesection_features	 = array_intersect($features, $value['features']);

	$monTableau[$key]['value'] = count($interesection_ambiances) + count($interesection_occasions) + count($interesection_features);

}

function sort_values($a, $b){
	return $a["value"]<$b["value"]?1:0;
}

usort($monTableau, "sort_values");
echo json_encode($monTableau, JSON_PRETTY_PRINT);


echo "<ol>";


foreach ($monTableau as $key => $value) 
{
	if ($value['value'] == 0) {
		echo "Désolé, nous n'avons pas de résultats valables";
		exit();
	}
	else{
	for ($i= $value['value'] ; $i >0 ; $i--) { 
	echo "<li>";
	echo '<p> <!-- ID=' . $value['ID'] .',' .'ID' . $key . "--><b>" . '<div style="width:60%;">' . $value['Name'] .'</b>, '. $value['Address'].'<br> '. $value['Category_1'] . ', ' . $value['Ambiance_1'] . ', ' . $value['Ambiance_2'] . ' & ' . $value['Ambiance_3'] . '<br>' . '<span  style="font-style: italic;">'. $value['Description'] .'</p>'. '<span style="visibility: hidden;"> points :' . $value['value'] . '</span>' . '</div>';
	echo "</li>";
	}
	}
}
echo "</ol>";
?>
</body>
</html>