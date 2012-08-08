<?php

	include_once 'class/template.php';
	include_once 'class/Usuario.php';
	include_once 'class/Chamado.php';

	$usuario = new Usuario();
	$chamado = new Chamado();
	
	$tplScripts = '<link rel="stylesheet" href="css/atender.css" media="screen" />';
	
	if($_GET['action']=='atender'):
		$chamado->AtenderChamado($_GET['id']);
		header("location: atender.php");
	endif;
	
	$helpdesk = $chamado->GetTodosChamados('', "true");
	if($helpdesk):
		foreach($helpdesk as $hd):
		
			if($hd['atendimento']==0){
				$atendimento = "<span class='tooltip' title='N&atilde;o Atendido'><img src='images/atender.png' /></span>";
				$class = "atender";
			}else{
				$atendente = $usuario->GetUserById($hd['atendimento']);	
				if(!$chamado->isFinalizado($hd['id_chamado'])):
					$atendimento = "<span class='tooltip' title='Em Atendimento'><img  src='images/atendendo.png' /></span>";
					$class = "atendendo";
				else:
					$atendimento = "<span class='tooltip' title='Finalizado'><img  src='images/atendido.png' /></span>";
					$class = "atendido";
				endif;
			}
		
			$tplHelpdesks .= '<tr><td><a href="detalhe.php?id='.$hd['id_chamado'].'">'.$hd['id_chamado'].'</a></td><td>'.$hd['data'].'</td><td>'.$hd['usuario'] .'</td><td>'.$hd['os'].'</td><td><a href="#'.$hd['id_chamado'].'" class="toggle id">'.utf8_encode($hd['titulo']).'</a></td><td>'.$atendimento.'</td><td>'.$atendente.'</td></tr>';
			$tplHelpdesks .= '<tr id="'.$hd['id_chamado'].'" class="mensagem '.$class.'"><td colspan="8">'.utf8_encode($hd['mensagem']).'</td></tr>';
		endforeach;
	endif;
						
	
	$pagina = new Template('templates/consultar.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'SCRIPTS'			=> 	$tplScripts,
		'USUARIO' 			=> 	$usuario->GetNome(),
		'HELPDESKS'			=> 	$tplHelpdesks,
	));
	
	$pagina->mostrar(); 