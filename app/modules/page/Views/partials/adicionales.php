<?php


function sin_p($texto){
	$texto = strip_tags($texto,'<br><h3><p><br><table><tr><td><b><strong><ul><li><span><div>');
	$texto = str_replace("<p","<div",$texto);
	$texto = str_replace("p>","div>",$texto);
	return $texto;
}

?>