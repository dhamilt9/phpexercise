<?php

$offers = array_map('str_getcsv', file('offers.csv'));
$profiles = array_map('str_getcsv', file('profiles.csv'));

$output=[];
$output2=[];

$personcounter=1;



//PARSES CSV FILES AND FILLS VARIABLE OUTPUT
//Each array in output represents a person.  Each person has a number of arrays structured as [offer_name, price] for every offer that should be shown to them
foreach ($profiles as $row){
	$output[$personcounter]=array();
	
	foreach($offers as $row2){
		if ($row2[0]!="offer_name"){
			if (($row[0]=='F' && $row2[3]=='TRUE') || ($row[0]=='M' && $row2[2]=='TRUE')){
				$age=$row[1];
				if ((18<=$age && $age<=25 && $row2[4]=='TRUE')||(26<=$age && $age<=35 && $row2[5]=='TRUE')||(36<=$age && $age<=45 && $row2[6]=='TRUE')||(46<=$age && $row2[7]=='TRUE')){
					$dealprice=[$row2[0], $row2[1]];
					array_push($output[$personcounter], $dealprice);
				}
			}else{
			}
		}
	}
	$personcounter++;
}


//PARSES THE OUTPUT AND CREATES A NEW SORTED ARRAY OUTPUT2
//output2 has the same structure as output, but the [offer_name, price] arrays are sorted by price in decending order.
$counter=1;
foreach($output as $person){
	foreach($person as $deal){
		if(empty($output2[$counter])){
			$output2[$counter]=array();
			array_push($output2[$counter], $deal);
		}
		else{
			$counter2=0;
			$added=0;
			foreach($output2[$counter] as $deal2){
				if($deal[1]>=$deal2[1]){
					$deal=array($deal);
					array_splice($output2[$counter], $counter2, 0, $deal);
					$added=1;
				}
				$counter2++;
			}
			if ($added==0){
				array_push($output2[$counter], $deal);
			}
		}
	}
	$counter++;
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>title</title>
    <link rel="stylesheet" href="main.css">
  </head>
  <body>
	<?php
	$personcounter2=1;
	foreach($output2 as $i){
	?>
    <div class="offerblock">
		<div class="title">Person <?php echo $personcounter2; ?></div>
		<div class="body">
			<ul>
				<?php 
				foreach($i as $j){
				?>
				<li>Offer <?php echo $j[0];?>, $<?php echo $j[1];?></li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
	
	<?php
	$personcounter2++;
	}
	?>
	
  </body>
</html>