<?php

	include 'class/template.php';
	include 'class/Usuario.php';
	include 'class/Chamado.php';

	$usuario = new Usuario();
	$chamado = new Chamado();
	$idChamado = $_GET['id'];
	
	//$tplScripts = '<script type="text/javascript" src="js/detalhe.js"></script>';
	
	$pagina = new Template('templates/atender.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'SCRIPTS'			=> 	$tplScripts,
		'USUARIO' 			=> 	$usuario->GetNome(),
		'RESPOSTAS'			=> 	$tplRespostas,
		'NUMERO_HELPDESK'	=>	$idChamado,
		'ID_CHAMADO'		=> 	$idChamado,
	));
	
	$pagina->mostrar(); 