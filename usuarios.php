<?php
	include_once 'class/master.inc.php';

	$usuario 	= new Usuario();

	$tplScripts .= '<script type="text/javascript" src="js/usuarios.js"></script>';
	$tplScripts .= '<link rel="stylesheet" href="css/usuarios.css" media="screen" />';
	$tplScripts .= '<link rel="stylesheet" href="css/impromptu.css" media="screen" />';
	$tplScripts .= '<script type="text/javascript" src="js/jquery-impromptu.4.0.min.js"></script>';
	
	$users = $usuario->GetTodosUsuarios();
	
	
	if($_GET['action']=='cadastrar'):
		if(!$usuario->CadastrarUsuario($_POST['nome'],$_POST['login'],$_POST['ramal'],$_POST['email'],$_POST['grupo'])):
			$tplError = '<p class="error" id="erro">Este login j&aacute; foi usado para outro usu&aacute;rio.</p>';
		else:
			header("location:usuarios.php");
		endif;
	elseif($_GET['action']=='deletar'):
		$usuario->ExcluirUsuario($_GET['id']);
		header("location:usuarios.php");
	elseif($_GET['action']=='resetar'):
		$usuario->ResetarSenha($_GET['id']);
		header("location:usuarios.php");
	endif;
	
	
	
	if($users):
		foreach($users as $u):
			$tplUsers .= '<tr><td class="center">'.$u['id'].'</td><td>'.$u['login']. '</td><td>' . 
							$u['nome'] . '</td><td class="center">' . $u['ramal']. '</td><td>' . $u['email'] . 
							'</td><td class="center">' . $u['grupo'] . 
							"</td><td class='center' colspan='3'><img src='images/edit.mini.png' class='alterar tooltip' title='Alterar'/><img id=".$u['id']." class='deletar tooltip' title='Excluir' src='images/delete.mini.png'/>".
							"<img id=".$u['id']." class='resetar tooltip' title='Resetar Senha' src='images/reset.mini.png'/></td></tr>"; 
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