<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Grappe 2 Glass</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<h1 style="margin-left:20px;">Grappe 2 Glass</h1>

	<i style="margin-left:20px;">Selectionner la catégorie souhaitée : </i> 
	<form action="g2g_resultats.php" method="post" style="margin:20px;">
		<div class="form-group">
		<label for="categorie"> Catégorie du bar :</label>
		<select name="categorie" required />
			<option></option>
			<option>beer bar</option>
			<option>hotel bar</option>
			<option>Wine Bar</option>
			<option>Cocktail Bar</option>
			<option>Champagne Bar</option>
			<option>Spirit Bar</option>
			<option>Home Bar Tender</option>
			<option>Speakeasy</option>
			<option>Into the Wild </option>
			<option>Tasting</option>
			<option>Wine &amp; Spirit Cellar</option>
			<option>jazz bar</option>
			<option>Restaurant</option>
		</select></div>

	<i>Merci de sélectionner au moins une caractéristique (plus vous en mettrez, meilleur sera le résultat!) : </i><br><br>
	<div class="form-group">
	<label for="ambiance1">Ambiance 1 :</label>
		<select name="ambiance1" />
			<option></option>
			<option>Cosy</option>
			<option>Intimate</option>
			<option>Exotic</option>
			<option>Vintage</option>
			<option>Boudoir</option>
			<option>Intellectual</option>
			<option>Crowded</option>
			<option>Funky</option>
			<option>Artistic</option>
			<option>Hushed</option>
			<option>Luxurious</option>
			<option>Parisian</option>
			<option>Friendly</option>
			<option>American</option>
			<option>Modern</option>
			<option>Mediterranean</option>
			<option>Lounge</option>
			<option>Eco-friendly</option>
			<option>Historical</option>
			<option>Millennials</option>
			<option>LGBTQ+</option>
		</select><br>
	<label for="ambiance2">Ambiance 2 :</label>
		<select name="ambiance2" />
			<option></option>
			<option>Cosy</option>
			<option>Intimate</option>
			<option>Exotic</option>
			<option>Vintage</option>
			<option>Boudoir</option>
			<option>Intellectual</option>
			<option>Crowded</option>
			<option>Funky</option>
			<option>Artistic</option>
			<option>Hushed</option>
			<option>Luxurious</option>
			<option>Parisian</option>
			<option>Friendly</option>
			<option>American</option>
			<option>Modern</option>
			<option>Mediterranean</option>
			<option>Lounge</option>
			<option>Eco-friendly</option>
			<option>Historical</option>
			<option>Millennials</option>
			<option>LGBTQ+</option>
		</select><br>
	<label for="ambiance3">Ambiance 3 :</label>
		<select name="ambiance3" />
			<option></option>
			<option>Cosy</option>
			<option>Intimate</option>
			<option>Exotic</option>
			<option>Vintage</option>
			<option>Boudoir</option>
			<option>Intellectual</option>
			<option>Crowded</option>
			<option>Funky</option>
			<option>Artistic</option>
			<option>Hushed</option>
			<option>Luxurious</option>
			<option>Parisian</option>
			<option>Friendly</option>
			<option>American</option>
			<option>Modern</option>
			<option>Mediterranean</option>
			<option>Lounge</option>
			<option>Eco-friendly</option>
			<option>Historical</option>
			<option>Millennials</option>
			<option>LGBTQ+</option>
		</select><br>	
	<label for="occasion">Occasion :</label>
		<select name="occasion" />
			<option></option>
			<option>all</option>
			<option>Couple</option>
			<option>Business</option>
			<option>With friends</option>
			<option>With children</option>
			<option>Alone</option>
		</select><br>
	<label for="feature1">Feature 1 :</label>
		<select name="feature1" />
			<option></option>
			<option>terrace</option>
			<option>dancing Floor</option>
			<option>Concert/live</option>
			<option>Smokehouse</option>
			<option>Landscape view</option>
			<option>Rooftop</option>
			<option>Pool</option>
			<option>Bar a tapas</option>
			<option>Jazz</option>
		</select><br>
	<label for="feature2">Feature 2 :</label>
		<select name="feature2" />
			<option></option>
			<option>terrace</option>
			<option>dancing Floor</option>
			<option>Concert/live</option>
			<option>Smokehouse</option>
			<option>Landscape view</option>
			<option>Rooftop</option>
			<option>Pool</option>
			<option>Bar a tapas</option>
			<option>Jazz</option>
		</select><br>	
	<label for="feature3">Feature 3 :</label>
		<select name="feature3" />
			<option></option>
			<option>terrace</option>
			<option>dancing Floor</option>
			<option>Concert/live</option>
			<option>Smokehouse</option>
			<option>Landscape view</option>
			<option>Rooftop</option>
			<option>Pool</option>
			<option>Bar a tapas</option>
			<option>Jazz</option>
		</select></div><br>	 	
	<input class="btn btn-primary" type="submit" value="Valider" />
	</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>