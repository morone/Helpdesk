<?php
	include_once 'class/master.inc.php';
	$usuario = new Usuario();
	
	//$tplMensagem = '<p class="error" id="erro">Login ou senha inv&aacute;lidos.</p>';
	
	if($_GET['action']=='alterar'):
		if(($_POST['senhaNova1']==$_POST['senhaNova2'])&&(trim($_POST['senhaNova1'])!="")):
			$login = $usuario->ValidaUsuario($_POST['login'], $_POST['senhaAtual']);
			if($login):
				$usuario->AlterarSenha($login, $_POST['senhaNova1']);
				$tplMensagem = '<p class="success" id="erro">Senha alterada com sucesso!</p>';
			else:
				$tplMensagem = '<p class="error" id="erro">Login ou senha inv&aacute;lidos!</p>';
			endif;
		else:
			$tplMensagem = '<p class="error" id="erro">Os campos de "nova senha" devem estar iguais!</p>';
		endif;
	endif;
	
	$pagina = new Template('templates/senha.tpl');

	$pagina->trocarTags( array(
		'MENSAGEM'			=>	$tplMensagem,
	));
	
	$pagina->mostrar(); 