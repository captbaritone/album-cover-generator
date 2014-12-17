<?php

//error_reporting(E_ERROR | E_PARSE);

define("SIZE", 500);
define("BAND_LETTERS", 37); // Number of letters before the text wraps
define("TITLE_LETTERS", 24); // Number of letters before the text wraps


require_once('vendor/autoload.php');


$cover = new AlbumCover;

if(isset($_GET['cover'])){
	$hash = $_GET['cover'];
	if(ereg("[0-9a-z]{32}", $hash) && (strlen($hash) == 32)){
		$fileName = "generated/" . $_GET['cover'] . ".jpg";
	}else{
		die("Wrong Cover ID");
	}
}else{
	$cover->generate();
    $fileName = $cover->fileName;
    $hash = $cover->hash;
}

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

echo $twig->render('index.html', array('cover' => $fileName, 'hash' => $hash));
