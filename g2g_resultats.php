<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<title>Grape2Glass</title>
	<link rel="stylesheet" href="assets/css/resultats.css" />
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="icon" type="image/png" href="images/logo/Black_Short_WEB.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
	<?php
	include("GA.php")
	?>

	<div class="body_container">

		<nav>

			<!-- For Desktop-->
			<div class="nav_container">
				<div class="bloc_nav">
					<a href="index.php" title="Home">Grape2Glass Discovery @Paris</a>
				</div>

				<div class="bloc_nav">
					<ul>
						<li><a href="http://www.grape2glass.fr/blog/" target="_blank" title="Blog">Blog</a></li>
						<li><a href="https://www.instagram.com/drinker_diary/" target="_blank" title="Instagram">Instagram</a></li>
						<li><a href="https://www.linkedin.com/company/grape2glass/" target="_blank" title="Linkedin">LinkedIn</a></li>
					</ul>
				</div>
			</div>

			<!-- For Smartphone-->
			<div class="nav_container">
				<h3 class="bloc_nav">
					<a href="index.php" title="Home">Grape2Glass Discovery @Paris</a>
				</h3>
			</div>

		</nav>

		<header>
			<div class="bloc_header">
				<a href="index.php" title="Home">
					<img src="assets/images/logo/White_Short_WEB.png" alt="logo G2G">
				</a>
			</div>
		</header>

		<section>
			<div class="section_container">
				<div class="section_bloc">

					<p>Vos critères de recherche sont les suivants :</p>

					<p>Catégorie : <b><?php echo htmlspecialchars($_POST['categorie']); ?></b></p>

					<p>Ambiance(s) : <b><?php echo htmlspecialchars($_POST['ambiance1'])?></b> <b><?php echo htmlspecialchars($_POST['ambiance2'])?></b> <b><?php echo htmlspecialchars($_POST['ambiance3'])?></b></p>

					<p>Occasion : <b><?php echo htmlspecialchars($_POST['occasion'])?></b></p>

					<p>Option(s) : <b><?php echo htmlspecialchars($_POST['feature1'])?></b> <b><?php echo htmlspecialchars($_POST['feature2'])?></b> <b><?php echo htmlspecialchars($_POST['feature3'])?></b></p>

					<p>Arrondissement : <b><?php echo htmlspecialchars($_POST['arrondissement'])?></b></p>
				</div>

				<div class="section_bloc">
					<div id="backbutton"><a href="index.php" title="Retour à la sélection">Retour</a></div>
				</div>
			</div>
		</section>
	</div>

	<div class="recommendations">

		<div class="bloc_recommendations">

			<?php include("config.php");?>

	<?php

	$reponse = $bdd->prepare(
		'SELECT *
		FROM BARS3 WHERE (Category_1 = ? OR Category_2 = ?)'
	);
	$rrr = $reponse->execute(
		array($_POST['categorie'], $_POST['categorie'])
	);

	while ($donnees = $reponse->fetch(PDO::FETCH_ASSOC)) {
		//je fais un tableau regroupant toutes mes données en bdd
	$donnees['ambiances'] = array_filter([$donnees['Ambiance_1'], $donnees['Ambiance_2'], $donnees['Ambiance_3']]);
	$donnees['occasions'] = array_filter([$donnees['Occasion_1'], $donnees['Occasion_2'], $donnees['Occasion_3'], $donnees['Occasion_4'], $donnees['Occasion_5']]);
	$donnees['features']  = array_filter([$donnees['Feature_1'], $donnees['Feature_2'], $donnees['Feature_3']]);
	$donnees['arrondissement'] = array_filter($donnees['Arrondissement']);

	$monTableau[] = $donnees;
	}
		//je compare ce qu'a demandé l'utilisateur et les données en bdd
	$ambiances = array_filter([$_POST['ambiance1'], $_POST['ambiance2'], $_POST['ambiance3']]);
	$occasions = array_filter([$_POST['occasion']]);
	$features  = array_filter([$_POST['feature1'], $_POST['feature2'], $_POST['feature3']]);
	$arrondissement = array_filter($_POST['arrondissement']);

$nbr_ambiances = count($ambiances);
$nbr_occasions = count($occasions);
$nbr_features = count($features);
$nbr_arrondissement = count($arrondissement);

//Calcul du nombre d'arguments donnés par l'utilisateur
$taille_arguments = $nbr_ambiances + $nbr_occasions + $nbr_features + $nbr_arrondissement;


foreach ($monTableau as $key => $value)
	{

		$intersection_ambiances = array_intersect($ambiances, $value['ambiances']);
		$intersection_occasions = array_intersect($occasions, $value['occasions']);
		$intersection_features	 = array_intersect($features, $value['features']);
		$intersection_arrondissement = array_intersect($arrondissement, $value['arrondissement']);

		$points_ambiances = (count($intersection_ambiances) * 1);
		$points_occasions = (count($intersection_occasions) * 1);
		$points_feature = (count($intersection_features) * 1);
		$points_arrondissement = (count($intersection_arrondissement) * 2);

		$monTableau[$key]['value'] = $points_ambiances + $points_occasions + $points_feature + $points_arrondissement;
		$monTableau[$key]['points_ambiances'] = $points_ambiances;
		$monTableau[$key]['value_occasions'] = $points_occasions;
		$monTableau[$key]['value_feature'] = $points_feature;
		$monTableau[$key]['value_arrondissement'] = $points_arrondissement;

		echo $intersection_arrondissement;

	}

function sort_values($a, $b){
	return $a["value"]<$b["value"]?1:0;
}

usort($monTableau, "sort_values");
//echo json_encode($monTableau, JSON_PRETTY_PRINT);
?>


<div class="container-fluid">

<div class="row">

<ol class ="col-md-8">

<?php

//initialisation du compteur
$cpt = 0;
$have_element = 0;
$info_maps = [];

if(!$monTableau){
	echo "Nous n'avons pas trouvé de résultats";
}

foreach ($monTableau as $key => $value)
{
	//on visualise si le compteur est bien inférieur à 5
	if ($cpt < 5)
	{
		//On change la class de la div selon le nombre de points
		if ($value['value'] > 'O')
		{
			$have_element = 1;

			echo "<li>";
			if($value['value'] > 0.66 * $taille_arguments ){
				echo '<div class = "compatible" >';
			}
			if($value['value'] >= 0.33 * $taille_arguments && $value['value'] <= 0.66 * $taille_arguments){
				echo '<div class = "bon" >';
			}
			if($value['value'] < 0.33 * $taille_arguments){
				echo '<div class = "mauvais">';
			}

			//recherche des posotions geographiques (lat & long) du bar depuis le service api-adresse.data.gouv.fr en rentrant l'adresse sur laquelle on a remplacé les espaces par des '+'.
			$position = json_decode(file_get_contents("https://api-adresse.data.gouv.fr/search/?q=" . str_replace(' ', '+', $value['Address'])), true);

			//Création d'un tableau associant le nom du bar et sa position geographique
			$info_maps[] = [
			'coordinates' => $position['features'][0]['geometry']['coordinates'],
			'Name' 				=> $value['Name'],
			'categorie1'		=> $value['Category_1'],
			'categorie2'		=> $value['Category_2']
		];

			echo '<!-- ID=' . $value['ID'] . ', ' . $key . "-->" . '<b>' . $value['Name'] .'</b>, '. $value['Address'] .' '. '<a target="_blank" href=" ' .$value['Map'] . '">' .'(Map)' . '</a>'. '<br>' . 'La categorie du bar est : ';

			if($value['Category_1'] == $_POST['categorie']) {
				echo '<span class="underline">' . $value['Category_1'] . '</span>';
			}
			else{
				echo $value['Category_1'];
			}

			//si la Category_2 existe, alors on l'affiche
			if(!empty($value['Category_2'])){
				//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
				if($value['Category_2'] == $_POST['categorie']) {
					echo ' & ' . '<span class="underline">' . $value['Category_2'] .'</span>';
				}
				else{
				echo ' & ' . $value['Category_2'];
				}
			}

			echo '<br> L\'ambiance y est :  ';
			//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
			if($value['Ambiance_1'] == $ambiances[0] OR $value['Ambiance_1'] == $ambiances[1] OR $value['Ambiance_1'] == $ambiances[2]){
			 	echo '<span class="underline">' . $value['Ambiance_1'] . '</span>' . ', ';
			}
			else{
			 	echo $value['Ambiance_1'] . ', ';
			}
			//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
			if($value['Ambiance_2'] == $ambiances[0] OR $value['Ambiance_2'] == $ambiances[1] OR $value['Ambiance_2'] == $ambiances[2]){
			 	echo '<span class="underline">' . $value['Ambiance_2'] . '</span>' . ' & ';
			}
			else{
			 echo $value['Ambiance_2'] . ' & ';
			}
			//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
			if($value['Ambiance_3'] == $ambiances[0] OR $value['Ambiance_3'] == $ambiances[1] OR $value['Ambiance_3'] == $ambiances[2]){
			 	echo '<span class="underline">' . $value['Ambiance_3'] . '</span>' . '<br>';
			}
			else{
			 	echo $value['Ambiance_3'] . '<br>';
			}

			//Si il a une feature 1, alors il l'affiche
			if(!empty($value['Feature_1'])){
				//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
				if ($value['Feature_1'] == $features[0] OR $value['Feature_1'] == $features[1] OR $value['Feature_1'] == $features[2]) {
					echo 'Il possède : ' . '<span class=underline>' . $value['Feature_1'] . '</span>';
				}
				else{
					echo 'Il possède : ' . $value['Feature_1'];
				}
				//si le bar possède des feature 2 & 3, alors il les affiche
				if(!empty($value['Feature_2'])){
					//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
					if ($value['Feature_2'] == $features[0] OR $value['Feature_2'] == $features[1] OR $value['Feature_2'] == $features[2]) {
					echo ' et ' . '<span class=underline>' . $value['Feature_2'] . '</span>';
				}
					else{
					echo ' et ' . $value['Feature_2'];
					}
				}
				if(!empty($value['Feature_3'])){
					//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
					if ($value['Feature_3'] == $features[0] OR $value['Feature_3'] == $features[1] OR $value['Feature_3'] == $features[2]) {
					echo ' et ' . '<span class="underline">' . $value['Feature_3'] . '</span>';
				}
					else{
					echo ' et ' . $value['Feature_3'];
					}
				}
				echo '<br>';
			}

			//Si il a une occasion 1, alors il l'affiche
			if(!empty($value['Occasion_1'])){
				echo 'Et il est idéalement adapté pour y aller avec : ';

				if ($value['Occasion_1'] == $_POST['occasion']) {
				 	echo '<span class="underline">' . $value['Occasion_1'] . '</span>';
				 }
				 else{
				 	echo $value['Occasion_1'];
				 }

				//Si il y a des occasions 2, 3, 4 ou 5, alors il les affiche
				if(!empty($value['Occasion_2'])){
					//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
					if($value['Occasion_2'] == $_POST['occasion']){
						echo ' ou ' . '<span class="underline">' . $value['Occasion_2'] . '</span>';
					}
					else{
						echo ' ou ' . $value['Occasion_2'];
					}
				}
				if(!empty($value['Occasion_3'])){
					//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
					if($value['Occasion_3'] == $_POST['occasion']){
						echo ' ou ' . '<span class="underline">' . $value['Occasion_3'] . '</span>';
					}
					else{
					echo ' ou ' . $value['Occasion_3'];
					}
				}
				if(!empty($value['Occasion_4'])){
					//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
					if($value['Occasion_4'] == $_POST['occasion']){
						echo ' ou ' . '<span class="underline">' . $value['Occasion_4'] . '</span>';
					}
					else{
					echo ' ou ' . $value['Occasion_4'];
					}
				}
				if(!empty($value['Occasion_5'])){
					//Si la valeur est la même que celle demandée par l'utilisateur, alors je souligne
					if($value['Occasion_5'] == $_POST['occasion']){
						echo ' ou ' . '<span class="underline">' .$value['Occasion_5'] . '</span>';
					}
					else{
					echo ' ou ' . $value['Occasion_5'];
					}
				}
			}
			echo '<p><br>' . '<span style="font-style: italic;">'. $value['Description'] . '</span>' . '</p><p>' . '<!-- Score : ' . $value['value'] . '-->'. '<a target="_blank" href="' . $value['Site'] . '"> ' .'Site web' . '</a>' .'</p>' . '</div>';

			echo "</li>";
			//on incrémente le compteur
			$cpt++;
		}
		elseif ($have_element === 0)
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
echo "</ol>";?>


<!-- Appel de la carte Gmap-->
<div class="col-md-4">
	<div id="map"></div>
</div>
</div><!-- Fin div row-->
</div><!-- Fin div Wrapper -->
<?php

//Début du script Gmap
   echo "<script>
            function initMap() {

              //Affichage de la carte focus sur Paris
              var myLatLng = {lat: 48.86, lng: 2.34};

              // Create a map object and specify the DOM element
              // for display.
              var map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 12.01
              });";

    //Récuperation des infos de geolocalisation des bars
    foreach ($info_maps as $i => $info) {
    	echo "var contentString_$i = '<div id=\"content\">'+
            '<div id=\"siteNotice\">'+
            '</div>'+
            '<h1 id=\"firstHeading\" class=\"firstHeading\">" . $info['Name'] . "</h1>'+
            '<div id=\"bodyContent\">'+
            '</div>'+
						'<p class=\"categorie1\">" . $info['categorie1'] . "</p>'+
            '</div>';";

    	echo "var infowindow_$i = new google.maps.InfoWindow({
          content: contentString_$i
        	});";

        echo "// Create a marker and set its position.
                var marker_$i = new google.maps.Marker({
                  map: map,
                  position: {lat: " . $info['coordinates'][1] . ", lng: " .$info['coordinates'][0] ."},
                  title: '" . $info['Name'] . "'
                });
              ";
        echo "marker_$i.addListener('click', function() {
          infowindow_$i.open(map, marker_$i);
        });";

  	}
      echo "}</script>";
 ?>

<!-- Appel du footer -->
<?php
include("footer.php");
?>
<!-- API Key pour Gmap -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD12uBzc9KfSwdhQ7HcqGE1KYenmITS180&callback=initMap"
        async defer></script>


</body>
</html>
