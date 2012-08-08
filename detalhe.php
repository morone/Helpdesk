<?php

	include_once 'class/template.php';
	include_once 'class/Usuario.php';
	include_once 'class/Chamado.php';

	$usuario = new Usuario();
	$chamado = new Chamado();
	$idChamado = $_GET['id'];
	
	if($_GET["action"]=="finalizar"):
		$chamado->Finalizar($idChamado);
		header("location: detalhe.php?id=".$idChamado);
	elseif($_GET["action"]=="delresp"):
		$chamado->ApagarResposta($_GET['resposta']);
		header("location: detalhe.php?id=".$idChamado);
	endif;
	
	
	$tplScripts = '<script type="text/javascript" src="js/detalhe.js"></script>';
	
	$tplFinalizar = '<p>Solicitante: <b>'.$chamado->GetSolicitante($_GET['id']).'</b> | Atendente: <b>'.$chamado->GetAtendente($_GET['id']).'</b></p>';
	
	if(!$chamado->isFinalizado($idChamado)):
		$tplFinalizar .= '<ul id="nav"><li><a href="?action=finalizar&id='.$idChamado.'">Finalizar</a></li></ul><br/><br/><br/>';
		$tplCaixaResposta = 'templates/caixaResposta.tpl';
	else:
		$tplFinalizar .= '<p class="success" id="sucesso">Helpdesk Finalizado.</p>';
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
		'CAIXA_RESPOSTA'	=>	$tplCaixaResposta,
		'FINALIZAR'			=>	$tplFinalizar,
	));
	
	$pagina->mostrar(); 