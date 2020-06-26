<?php 
require_once "../functions.php";

$val = $_POST['Spin'];

for ($i=0; $i < 3; $i++) { 
	$spun = spinNotRandom($val);
	echo $spun.'<br>';
}

?>


<?php
header('Cache-Control: no-cache');
header('Expires: -1');
header('Content-Type: text/html; charset=utf-8');

// Document source

// Document a tester

print 'Spin Source: '.$val.' ';
print 'Spun a controler: '.$spun.' ';

echo "";

// Post Traitement
// Conversion en minuscule
$doc1 = strtolower($val);
$doc2 = strtolower($spun);

// Recherche des phrases.
$sentenceOrg = extractSentence($doc1);
$sentenceDup = extractSentence($doc2);

// On recherche tous les mots des phrases
$sentenceOrgCount = 0;
while (isset($sentenceOrg[$sentenceOrgCount]))
	$wordsOrg[] = array_unique(preg_split("/[\s,]+/", $sentenceOrg[$sentenceOrgCount++]));
$sentenceDupCount = 0;
while (isset($sentenceDup[$sentenceDupCount]))
	$wordsDup[] = array_unique(preg_split("/[\s,]+/", $sentenceDup[$sentenceDupCount++]));

// Comparaison des phrases mot par mot.
while ($wordsDupElement = current($wordsDup))
{
	while ($wordsOrgElement = current($wordsOrg))
	{
		$total = 0;
		foreach($wordsDupElement as $wordDupElement)
			if (in_array($wordDupElement, $wordsOrgElement))
				$total++;
		$percentSimilarity = round($total/count($wordsDupElement) * 100, 2);
		$resultSimilarity[$sentenceDup[key($wordsDup)]][$sentenceOrg[key($wordsOrg)]] = $percentSimilarity;
		$resultSimilarity[$sentenceDup[key($wordsDup)]]['max'] = max($resultSimilarity[$sentenceDup[key($wordsDup)]]);
		$resultSimilarity[$sentenceDup[key($wordsDup)]]['hit'] = 0;
		next($wordsOrg);
	}
	reset($wordsOrg);
    next($wordsDup);
}
reset($wordsDup);

$tolerance = 20;
$score = 0;
while($results = current($resultSimilarity))
{
	if ($results['max'] > $tolerance)
	{
		$score = $score + $results['max'];
		$resultSimilarity[key($resultSimilarity)]['hit'] = 1;
	}
    next($resultSimilarity);
}
reset($resultSimilarity);

// Resultats
echo "Tolerance: ".$tolerance."% ";
echo "Similarité : ".$score/count($resultSimilarity)." %";
while($results = current($resultSimilarity))
{
	if ($results['hit'] == 1)
		echo "=> ".key($resultSimilarity)."";

    next($resultSimilarity);
}
reset($resultSimilarity);