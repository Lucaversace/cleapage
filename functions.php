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