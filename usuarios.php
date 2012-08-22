<?php
	include_once 'class/master.inc.php';

	$usuario 	= new Usuario();

	$tplScripts = '<link rel="stylesheet" href="css/usuarios.css" media="screen" />';
	
	$users = $usuario->GetTodosUsuarios();
	
	
	if($_GET['action']=='cadastrar'):
		if(!$usuario->CadastrarUsuario($_POST['nome'],$_POST['login'],$_POST['ramal'],$_POST['email'],$_POST['grupo'])):
			$tplError = '<p class="error" id="erro">Este login j&aacute; foi usado para outro usu&aacute;rio.</p>';
		else:
			header("location:usuarios.php");
		endif;
	endif;
	
	
	
	if($users):
		foreach($users as $u):
			$tplUsers .= '<tr><td>'.$u['id'].'</td><td>'.$u['login']. '</td><td>' . $u['nome'] . '</td><td>' . $u['ramal']. '</td><td>' . $u['email'] . '</td><td>' . $u['grupo'] . "</td></tr>"; 
		endforeach;
	endif;
	
	
	
	$pagina = new Template('templates/usuario.tpl');

	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'MENU'				=> 	getMenu(),
		'SCRIPTS'			=> 	$tplScripts,
		'MENSAGEM'			=>	$tplError,
		'USERS'				=> 	$tplUsers,
		'USUARIO' 			=> 	$usuario->GetNome($_SESSION['login']),
		'HELPDESKS'			=> 	$tplHelpdesks,
	));
	
	$pagina->mostrar(); 