<?php

	include_once 'class/master.inc.php';

	$usuario 	= new Usuario();
	$chamado 	= new Chamado();
	$categoria 	= new Categoria();
	
	
	if(isset($_GET)):
		switch ($_GET['action']):
			case 'abrir':
				$chamado->CriarChamado($usuario->GetId($_SESSION['login']), utf8_decode($_POST['titulo']), utf8_decode($_POST['mensagem']), $_POST['os'], $_POST['categoria']);
				$tplMensagem = '<p class="success" id="sucesso">Helpdesk aberto com sucesso.</p>';
				break;
		endswitch;
	endif;
	
	
	$tplCategoria = "<option>(vazio)</option>";
	if($categoria->RetornarCategorias()):
		foreach ($categoria->RetornarCategorias() as $cat):
			$tplCategoria .= "<option value='". $cat['id_categoria'] ."'>". $cat['descricao'] ."</option>";
		endforeach;
	endif;
	
	
	$tplHelpdeskAberto="";
	$todosChamados =  $chamado->GetTodosChamados('',$usuario->GetId($_SESSION['login']),'');
	if($todosChamados !=""):
		foreach($todosChamados as $helpdesk):
			$tplHelpdeskAberto .= '<p><a href="detalhe.php?id='.$helpdesk['id_chamado'].'" class="tooltip" title="'.utf8_encode($helpdesk['titulo']).'">'. $helpdesk['id_chamado'] .'</a> - <strong>'.$categoria->GetDescricao($helpdesk['categoria']).'</strong> - OS '. $helpdesk['os'] .' - '.utf8_encode($helpdesk['titulo']).' </p>';
		endforeach;
	else:
		$tplHelpdeskAberto = "<blockquote>Nenhum helpdesk aberto no momento.</blockquote>";
	endif;
	
	
	$pagina = new Template('templates/principal.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 'templates/cabecalho.tpl',
		'RODAPE'			=> 'templates/rodape.tpl',
		'MENU'				=> getMenu(),
		'USUARIO' 			=> $usuario->GetNome($_SESSION['login']),
		'CATEGORIA'			=> $tplCategoria,
		'HELPDESK_ABERTO'	=> $tplHelpdeskAberto,
		'MENSAGEM'			=> $tplMensagem,
		
	));
	
	$pagina->mostrar(); 