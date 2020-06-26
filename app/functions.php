<?php 

function spin($txt)
{
   $pattern = '#\{([^{}]*)\}#msi';
   $test = preg_match_all($pattern, $txt, $out);
   if (!$test) return $txt;
   $atrouver = array();
   $aremplacer = array();
   foreach($out[0] as $id => $match)
   {
      $choisir = explode("|", $out[1][$id]);
      $atrouver[] = $match;
      $aremplacer[] = $choisir[mt_rand(0, count($choisir)-1)];
   }
   $reponse = str_replace($atrouver, $aremplacer, $txt);
   return Spin($reponse);
}

function spinNotRandom($txt)
{
   $pattern = '#\{([^{}]*)\}#msi';
   $test = preg_match_all($pattern, $txt, $out);
   if (!$test) return $txt;
   $atrouver = array();
   $aremplacer = array();
   foreach($out[0] as $id => $match)
   {
      $choisir = explode("|", $out[1][$id]);
      $atrouver[] = $match;
      $aremplacer[] = $choisir[mt_rand(0, count($choisir)-1)];
   }
   $reponse = str_replace($atrouver, $aremplacer, $txt);
   return spinNotRandom($reponse);
}

function extractSentence(string $string):array
{
	$return_array = Array();
	foreach(preg_split("/[.!\n?;]+/",$string) as $element)
	{
		$element = trim($element);
		if (!empty($element))
			$return_array[] = $element;
	}
	return $return_array;
}

function countFiles(string $directory):int
{
    $nbFichiers = 0;
    $tabNbFile = scandir($directory);
   
    foreach ($tabNbFile as $file) {
      $nbFichiers += 1;
   }
    return $nbFichiers;
}