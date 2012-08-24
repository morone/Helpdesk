<?php

	include_once 'class/master.inc.php';

	$usuario 	= new Usuario();
	$chamado 	= new Chamado();
	$categoria 	= new Categoria();
	
	$tplScripts = '<link rel="stylesheet" href="css/atender.css" media="screen" />';
	$tplScripts .= '<link rel="stylesheet" href="css/impromptu.css" media="screen" />';
	
	$tplScripts .= '<script type="text/javascript" src="js/atender.js"></script>';
	$tplScripts .= '<script type="text/javascript" src="js/jquery-impromptu.4.0.min.js"></script>';
	
	if($_GET['action']=='atender'):
		$chamado->AtenderChamado($_GET['id']);
		header("location: atender.php");
	elseif($_GET['action']=='alterarCat'):
		$chamado->AlterarCategoria($_GET['id'], $_GET['categoria']);
		header("location: atender.php");
	endif;
	
	$helpdesk = $chamado->GetTodosChamados('','', "0");
	if($helpdesk):
		foreach($helpdesk as $hd):
		
			$tplCategoria = '<select name="categoria" id="categoria" class="select">';
			
			if($categoria->RetornarCategorias()):
				foreach ($categoria->RetornarCategorias() as $cat):
					$tplCategoria .= "<option value='". $cat['id_categoria'] ."' ".($hd['categoria']==$cat['id_categoria']?'selected':'').">". $cat['descricao'] ."</option>";
				endforeach;
			endif;
			
			$tplCategoria .='</select>';
		
			if($hd['atendimento']==0){
				$atendimento = "<a href='?action=atender&id=".$hd['id_chamado']."' class='tooltip' title='Atender'><img src='images/atender.png' /></a>";
				$class = "atender";
			}else{
				$atendimento = "<a href='detalhe.php?id=".$hd['id_chamado']."' class='tooltip' title='Em Atendimento'><img  src='images/atendendo.png' /></a>";
				$class = "atendendo";
			}
		
			$tplHelpdesks .= '<tr><td>'.$hd['id_chamado'].'</td><td>'.$hd['data_abertura'].'</td><td>'.$hd['usuario'].'</td><td>'.$tplCategoria.'</td><td>'.$hd['os'].'</td><td><a href="#'.$hd['id_chamado'].'" class="toggle id">'.utf8_encode($hd['titulo']).'</a></td><td>'.$atendimento.'</td><td>'.$hd['atendente'].'</td></tr>';
			$tplHelpdesks .= '<tr id="'.$hd['id_chamado'].'" class="mensagem '.$class.'"><td colspan="9">'.utf8_encode($hd['mensagem']).'</td></tr>';
			$tplHelpdesks .= '<input type="hidden" id="id" value="'.$hd['id_chamado'].'">';
		endforeach;
	endif;
						
	
	$pagina = new Template('templates/atender.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'			=> 	'templates/cabecalho.tpl',
		'RODAPE'			=> 	'templates/rodape.tpl',
		'MENU'				=> getMenu(),
		'SCRIPTS'			=> 	$tplScripts,
		'USUARIO' 			=> 	$usuario->GetNome($_SESSION['login']),
		'HELPDESKS'			=> 	$tplHelpdesks,
	));
	
	$pagina->mostrar(); 