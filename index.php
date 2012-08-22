<?php
	include_once 'class/master.inc.php';

	$tplScripts = '<link rel="stylesheet" href="css/index.css" media="screen" />';
	
	$usuario = new Usuario();
	
	if($_GET['action']=='entrar'):
		$id = $usuario->ValidaUsuario($_POST['login'], $_POST['senha']);
		if($id):
			$_SESSION['login'] = $id;
			header('location:actions/logar.php');
		endif;
	endif;
	
	
	$pagina = new Template('templates/index.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'		=> 	'templates/indexCabecalho.tpl',
		'RODAPE'		=> 	'templates/rodapeCabecalho.tpl',
		'SCRIPTS'		=> 	$tplScripts,
	));
	
	$pagina->mostrar(); 