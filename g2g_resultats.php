<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<title>Grape2Glass</title>
	<link rel="icon" type="image/png" href="assets/images/Black_Short_WEB.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

	<div style="margin:20px;">
	<p>Bonjour !</p>

	<p>Tu recherches un bar de type <b><?php echo htmlspecialchars($_POST['categorie']); ?></b> avec une ambiance <b><?php echo htmlspecialchars($_POST['ambiance1'])?></b> et <b><?php echo htmlspecialchars($_POST['ambiance2'])?></b> ainsi que <b><?php echo htmlspecialchars($_POST['ambiance3'])?></b> pour y aller <b><?php echo htmlspecialchars($_POST['occasion'])?></b> </p>

	<p>le bar idéal a les caractéristiques suivantes : <b><?php echo htmlspecialchars($_POST['feature1'])?></b>, <B><?php echo htmlspecialchars($_POST['feature2'])?></B> et <b><?php echo htmlspecialchars($_POST['feature3'])?></b></p>

	<p>Si tu veux changer de description, <a href="index.php">clique ici</a> pour revenir à la page formulaire.php.</p></div>
	<hr>

<?php
	include("config.php");
?>

	<?php


	$reponse = $bdd->prepare(
		'SELECT *
		FROM BARS2 WHERE (Category_1 = ? OR Category_2 = ?)'
	);
	$rrr = $reponse->execute(
		array($_POST['categorie'], $_POST['categorie'])
	); 

	while ($donnees = $reponse->fetch(PDO::FETCH_ASSOC)) {

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
//echo json_encode($monTableau, JSON_PRETTY_PRINT);


echo "<ol>";

//initialisation du compteur
$cpt = 0;

foreach ($monTableau as $key => $value) 
{
	//on visualise si le compteur est bien inférieur à 5
	if ($cpt < 5)
	{
		//On change la class de la div selon le nombre de points
		if ($value['value'] > 'O')
		{
			echo "<li>";
			if($value['value'] > 1){
				echo '<div class = "compatible" >';
			}
			if($value['value'] == 1){
				echo '<div class = "bon" >';
			}
			if($value['value'] < 1){
				echo '<div class = "mauvais">';
			}

			echo '<!-- ID=' . $value['ID'] . ', ' . $key . "-->" . '<b>' . $value['Name'] .'</b>, '. $value['Address'] . '<br>' . 'La categorie du bar est : ' . $value['Category_1'];

			//si la Category_2 existe, alors on l'affiche
			if(!empty($value['Category_2'])){

				echo ' & ' . $value['Category_2'];
			}

			//J'affiche les 3 ambiances
			echo '<br> l\'ambiance y est :  ' . $value['Ambiance_1'] . ', ' . $value['Ambiance_2'] . ' & ' . $value['Ambiance_3'] . '<br>'; 


			//Si il a une feature 1, alors il l'affiche
			if(!empty($value['Feature_1'])){
				echo 'Il possède : ' . $value['Feature_1'];

				//si le bar possède des feature 2 & 3, alors il les affiche
				if(!empty($value['Feature_2'])){
					echo ' et ' . $value['Feature_2'];
				}
				if(!empty($value['Feature_3'])){
					echo ' et ' . $value['Feature_3'];
				}
				echo '<br>';
			}

			//Si il a une occasion 1, alors il l'affiche
			if(!empty($value['Occasion_1'])){
				echo 'Et il est idéalement adapté pour y aller avec : ' . $value['Occasion_1'];

				//Si il y a des occasions 2, 3, 4 ou 5, alors il les affiche
				if(!empty($value['Occasion_2'])){
					echo ' ou ' . $value['Occasion_2'];
				}
				if(!empty($value['Occasion_3'])){
					echo ' ou ' . $value['Occasion_3'];
				}
				if(!empty($value['Occasion_4'])){
					echo ' ou ' . $value['Occasion_4'];
				}
				if(!empty($value['Occasion_5'])){
					echo ' ou ' . $value['Occasion_5'];
				}
			}

			echo '<br><br>' . '<p>' . '<span style="font-style: italic; padding-top: 15px;">'. $value['Description'] . '</span>' . '<br/><br/> <span>' . 'Score : ' . $value['value'] . '</span>' . '</p>' . '</div>';

			echo "</li>";
			//on incrémente le compteur
			$cpt++;
		}
		else
		{
			echo "Désolé, nous n'avons pas de résultats pour cette recherche.";
			break;
		}
	}
	else
	{
		break;
	}
	echo "</li>";
}
echo "</ol>";
?>

</body>
</html>