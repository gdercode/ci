<?php 

/*La première ligne du fichier permet d'exécuter le script seulement si la constante BASEPATH est définie. En fait, elle est créée au tout début du fichier index.php. En faisant cela, vous serez assurés que le script ne sera pas exécuté depuis l'URL, mais bien en suivant l'ordre normal des choses.*/
if(! defined('BASEPATH')) exit('No direct script access allowed');


// J'ai encadré toutes les fonctions avec une condition pour éviter de redéfinir des fonctions.


if(! function_exists('css_url'))
{
	function css_url($nom)
	{
		return base_url().'assets/css/'.$nom.'.css';
	}
}
	
if(! function_exists('js_url'))
{
	function js_url($nom)
	{
		return base_url().'assets/javascript/'.$nom.'.js';
	}
}

if(! function_exists('img_ur'))
{
	function img_url($nom)
	{
		return base_url().'assets/images/'.$nom;
	}
}

if(! function_exists('img'))
{
	function img($nom, $alt='')
	{
		return '<img src="'.img_url($nom).'"alt="'.$alt.'"/>';
	}
}
?>