<?php

	include_once 'class/master.inc.php';

	$usuario 	= new Usuario();
	$chamado 	= new Chamado();
	$categoria 	= new Categoria();
	
	$tplScripts = '<link rel="stylesheet" href="css/atender.css" media="screen" />';
	
	if($_GET['action']=='atender'):
		$chamado->AtenderChamado($_GET['id']);
		header("location: atender.php");
	endif;
	
	$helpdesk = $chamado->GetTodosChamados();
	if($helpdesk):
		foreach($helpdesk as $hd):
		
			if($hd['atendimento']==0){
				$atendimento = "<a href='?action=atender&id=".$hd['id_chamado']."' class='tooltip' title='Atender'><img src='images/atender.png' /></a>";
				$atendente = "-";
				$class = "atender";
			}else{
				$atendimento = "<a href='detalhe.php?id=".$hd['id_chamado']."' class='tooltip' title='Em Atendimento'><img  src='images/atendendo.png' /></a>";
				$atendente = $usuario->GetUserById($hd['atendimento']);
				$class = "atendendo";
			}
		
			$tplHelpdesks .= '<tr><td>'.$hd['id_chamado'].'</td><td>'.$hd['data'].'</td><td>'.$hd['usuario'].'</td><td>'.$categoria->GetDescricao($hd['categoria']).'</td><td>'.$hd['os'].'</td><td><a href="#'.$hd['id_chamado'].'" class="toggle id">'.utf8_encode($hd['titulo']).'</a></td><td>'.$atendimento.'</td><td>'.$atendente.'</td></tr>';
			$tplHelpdesks .= '<tr id="'.$hd['id_chamado'].'" class="mensagem '.$class.'"><td colspan="9">'.utf8_encode($hd['mensagem']).'</td></tr>';
		endforeach;
	endif;
						
	
	$pagina = new Template('templates/atender.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'SCRIPTS'			=> 	$tplScripts,
		'USUARIO' 			=> 	$usuario->GetNome(),
		'HELPDESKS'			=> 	$tplHelpdesks,
	));
	
	$pagina->mostrar(); 