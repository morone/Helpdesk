<?php

	include_once 'class/master.inc.php';

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
	
	$usuariosDoChamado = Array(0 => $chamado->GetSolicitante($_GET['id']), 1=> $chamado->GetAtendente($_GET['id']));
	
	$tplFinalizar = '<p>Solicitante: <b>'.$usuariosDoChamado[0].'</b> | Atendente: <b>'.$usuariosDoChamado[1].'</b></p>';
	
	
	if((in_array($usuario->GetNome($_SESSION['login']), $usuariosDoChamado))&&(!$chamado->isFinalizado($idChamado))):
		$tplFinalizar .= '<ul id="nav"><li><a href="?action=finalizar&id='.$idChamado.'">Finalizar</a></li></ul><br/><br/><br/>';
		$tplCaixaResposta = 'templates/caixaResposta.tpl';
	elseif($chamado->isFinalizado($idChamado)):
		$tplFinalizar .= '<p class="success" id="sucesso">Helpdesk Finalizado.</p>';
	else:
		$tplFinalizar .= '<p class="note" id="sucesso">Helpdesk em Atendimento.</p>';
	endif;
	
	
	$pagina = new Template('templates/detalhe.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'MENU'				=> getMenu(),
		'SCRIPTS'			=> 	$tplScripts,
		'USUARIO' 			=> 	$usuario->GetNome($_SESSION['login']),
		'RESPOSTAS'			=> 	$tplRespostas,
		'NUMERO_HELPDESK'	=>	$idChamado,
		'ID_CHAMADO'		=> 	$idChamado,
		'CAIXA_RESPOSTA'	=>	$tplCaixaResposta,
		'FINALIZAR'			=>	$tplFinalizar,
	));
	
	$pagina->mostrar(); 