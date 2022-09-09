<?php 

/*La première ligne du fichier permet d'exécuter le script seulement si la constante BASEPATH est définie. En fait, elle est créée au tout début du fichier index.php. En faisant cela, vous serez assurés que le script ne sera pas exécuté depuis l'URL, mais bien en suivant l'ordre normal des choses.*/
if(! defined('BASEPATH')) exit('No direct script access allowed');


// J'ai encadré toutes les fonctions avec une condition pour éviter de redéfinir des fonctions.


if(! function_exists('fileuploadCI'))
{
	function fileuploadCI($imagename,$folder,$tobe_saved_name)
	{
			$image = $_FILES[$imagename]['name'];
			$CI = & get_instance();
			$config = array(
				'upload_path' => $folder,
				'allowed_types' => 'jpg',
				'max_size' => '100000',
				'file_name' => $tobe_saved_name
			);

			$CI->load->library('upload', $config);
			$CI->upload->initialize($config);

			if ($CI->upload->do_upload($imagename)) {
				return $image;
			}
			else
			{
				return 'Image not uploaded';
			}
	}
}
	

?>