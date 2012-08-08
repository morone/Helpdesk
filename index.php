<?php

include_once 'class/template.php';
include_once 'class/Usuario.php';
include_once 'class/Chamado.php';

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
			$tplHelpdeskAberto .= '<p><a href="detalhe.php?id='.$helpdesk['id_chamado'].'" class="tooltip" title="'.utf8_encode($helpdesk['titulo']).'">'. $helpdesk['id_chamado'] .'</a> - OS '. $helpdesk['os'] .' - '.utf8_encode($helpdesk['titulo']).' </p>';
		endforeach;
	else:
		$tplHelpdeskAberto = "<blockquote>Nenhum helpdesk aberto no momento.</blockquote>";
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