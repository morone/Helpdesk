<?php
	include_once 'class/master.inc.php';
	
	$usuario = new Usuario();
	
	if($_GET['action']=='entrar'):
		$id = $usuario->ValidaUsuario($_POST['login'], $_POST['senha']);
		if($id):
			$_SESSION['login'] = $id;
			header('location:actions/logar.php');
		else:
			$tplMensagem = '<p class="error" id="erro">Login ou senha inv&aacute;lidos.</p>';
		endif;
	endif;
	
	
	$pagina = new Template('templates/index.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'		=> 	'templates/indexCabecalho.tpl',
		'RODAPE'		=> 	'templates/indexRodape.tpl',
		'MENSAGEM'		=>	$tplMensagem,
	));
	
	$pagina->mostrar(); 