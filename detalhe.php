<?php

	include 'class/template.php';
	include 'class/Usuario.php';
	include 'class/Chamado.php';

	$usuario = new Usuario();
	$chamado = new Chamado();
	$idChamado = $_GET['id'];
	
	if($_GET["action"]=="finalizar"):
		$chamado->Finalizar($idChamado);
		header("location: detalhe.php?id=".$idChamado);
	endif;
	
	
	$tplScripts = '<script type="text/javascript" src="js/detalhe.js"></script>';
	
	if(!$chamado->isFinalizado($idChamado)):
		$tplFinalizar = '<ul id="nav"><li><a href="?action=finalizar&id='.$idChamado.'">Finalizar</a></li></ul><br/><br/><br/>';
	else:
		$tplFinalizar = '<p class="success" id="sucesso">Helpdesk Finalizado.</p>';
	endif;
	
	$pagina = new Template('templates/detalhe.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'SCRIPTS'			=> 	$tplScripts,
		'USUARIO' 			=> 	$usuario->GetNome(),
		'RESPOSTAS'			=> 	$tplRespostas,
		'NUMERO_HELPDESK'	=>	$idChamado,
		'ID_CHAMADO'		=> 	$idChamado,
		'FINALIZAR'			=>	$tplFinalizar,
	));
	
	$pagina->mostrar(); 