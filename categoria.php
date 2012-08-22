<?php

	include_once 'class/master.inc.php';

	$usuario = 		new Usuario();
	$categoria = 	new Categoria();

	$tplScripts = '<script type="text/javascript" src="js/categoria.js"></script>';

	
	if($_GET["action"]=="delcat"):
		$categoria->Deletar($_GET['id']);
		header("location: categoria.php");
	endif;
	
	
	$pagina = new Template('templates/categoria.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'MENU'				=> getMenu(),
		'SCRIPTS'			=>	$tplScripts,
		'USUARIO' 			=> 	$usuario->GetNome($_SESSION['login']),
	));
	
	$pagina->mostrar(); 