<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8"/>	
	
	<title>Developer Test - John Mark A. Dalumpines</title>

	<link rel="stylesheet" type="text/css" href="style.css">

</head>


<?php
$key = 'u9erhvmqkh7g9j4g3f8y2up4';
$searches = array('red', 'green', 'blue', 'yellow');

$search_results_ar = array();
foreach($searches as $search)
{
	$q = urlencode($search); // make sure to url encode an query parameters
	$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey='.$key.'&q='.$q;

	//endpoint call
	$session = curl_init($endpoint);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

	//retrieve data
	$retrieved_data = curl_exec($session);
	curl_close($session);

	$search_results = json_decode($retrieved_data);
	if ($search_results === NULL) die('Parsing Error');

	$search_results_ar[$search] = $search_results->movies;
}?>



<body>


<?php
foreach($searches as $search)
{?>
	<ul>
		<?php
		$retrieved_movies = $search_results_ar[$search];
		foreach ($retrieved_movies as $mov) {?>
			<li class="<?php echo $search; ?>">
		  		<img src="<?php echo $mov->posters->original; ?>" alt="<?php echo $mov->title; ?>" />			
		  		<a href="<?php echo $mov->links->alternate; ?>">
		  			<h3><?php echo $mov->title; ?></h3>
		  		</a>
		  		<div class="divider"></div>
	  			Year: <em><?php echo $mov->year; ?> <br /></em>
	  			Runtime: <em><?php echo $mov->runtime; ?></em>
			</li>
		<?php
		}?>
	</ul>
<?php
}?>


</body>

</html>
