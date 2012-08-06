<?php

include 'class/template.php';
include 'class/Usuario.php';
include 'class/Chamado.php';

	$usuario = new Usuario();
	$chamado = new Chamado();
	
	if(isset($_GET)):
		switch ($_GET['action']):
			case 'abrir':
				$chamado->CriarChamado($usuario->GetId(), utf8_decode($_POST['titulo']), utf8_decode($_POST['mensagem']), $_POST['os']);
				$tplMensagem = '<p class="success" id="sucesso">Helpdesk aberto com sucesso.</p>';
				break;
		endswitch;
	endif;
	
	
	$tplHelpdeskAberto="";
	
	$todosChamados =  $chamado->GetTodosChamados($usuario->GetId());
	if($todosChamados !=""):
		foreach($todosChamados as $helpdesk):
			$tplHelpdeskAberto .= '<p><a href="detalhe.php?id='.$helpdesk[0].'" class="tooltip" title="'.utf8_encode($helpdesk[2]).'">'. $helpdesk[0] .'</a> - OS '. $helpdesk[1] .' - '.utf8_encode($helpdesk[2]).' </p>';
		endforeach;
	endif;
	
	
	$pagina = new Template('templates/index.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 'templates/cabecalho.tpl',
		'RODAPE'			=> 'templates/rodape.tpl',
		'USUARIO' 			=> $usuario->GetNome(),
		'HELPDESK_ABERTO'	=> $tplHelpdeskAberto,
		'MENSAGEM'			=> $tplMensagem,
	));
	
	$pagina->mostrar(); 