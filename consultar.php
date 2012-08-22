<?php

	include_once 'class/master.inc.php';

	$usuario 	= new Usuario();
	$chamado 	= new Chamado();
	$categoria 	= new Categoria();
	
	$tplScripts = '<link rel="stylesheet" href="css/atender.css" media="screen" />';
	$tplScripts .= '<script type="text/javascript" src="js/consultar.js"></script>';
	
	if($_GET['action']=='atender'):
		$chamado->AtenderChamado($_GET['id']);
		header("location: atender.php");
	elseif($_GET['action']=='buscar'):
	
		if($_POST['numeroChamado']		!="")$_SESSION['filtros']['numeroChamado']		=	$_POST['numeroChamado'];
		if($_POST['usuario']			!="")$_SESSION['filtros']['usuario']			=	$_POST['usuario'];
		if($_POST['categoria']			!="")$_SESSION['filtros']['categoria']			= 	$_POST['categoria'];
		if($_POST['os']					!="")$_SESSION['filtros']['os']					= 	$_POST['os'];
		if($_POST['status']				!="")$_SESSION['filtros']['status']				= 	$_POST['status'];
		if($_POST['texto']				!="")$_SESSION['filtros']['texto']				= 	$_POST['texto'];
		if($_POST['dataAberturaDe']		!="")$_SESSION['filtros']['dataAberturaDe']		= 	$_POST['dataAberturaDe'];
		if($_POST['dataAberturaAte']	!="")$_SESSION['filtros']['dataAberturaAte']	= 	$_POST['dataAberturaAte'];
		if($_POST['dataFechamentoDe']	!="")$_SESSION['filtros']['dataFechamentoDe']	= 	$_POST['dataFechamentoDe'];
		if($_POST['dataFechamentoAte']	!="")$_SESSION['filtros']['dataFechamentoAte']	= 	$_POST['dataFechamentoAte'];
		
		header("location: consultar.php");
	elseif($_GET['action']=='limparFiltro'):
		unset($_SESSION['filtros']);
		header("location: consultar.php");
	endif;
	
	$helpdesk = $chamado->GetTodosChamados($_SESSION['filtros']);
	if($helpdesk):
		foreach($helpdesk as $hd):
		
			if($hd['atendimento']==0):
				$atendimento = "<span class='tooltip' title='N&atilde;o Atendido'><img src='images/atender.png' /></span>";
				$class = "atender";
			else:
				if(!$hd['finalizado']):	
					$atendimento = "<span class='tooltip' title='Em Atendimento'><img  src='images/atendendo.png' /></span>";
					$class = "atendendo";
				else:
					$atendimento = "<span class='tooltip' title='Finalizado'><img  src='images/atendido.png' /></span>";
					$class = "atendido";
				endif;
			endif;
		
			$tplHelpdesks .= '<tr><td><a href="detalhe.php?id='.$hd['id_chamado'].'">'.$hd['id_chamado'].'</a></td><td>'.$hd['data_abertura'].'</td><td>'.$hd['ultima_resp'].'</td><td>'.$hd['totalGasto'].'</td><td>'.$hd['usuario'] .'</td><td>'.$categoria->GetDescricao($hd['categoria']).'</td><td>'.$hd['os'].'</td><td><a href="#'.$hd['id_chamado'].'" class="toggle id">'.utf8_encode($hd['titulo']).'</a></td><td>'.$atendimento.'</td><td>'.$hd['atendente'].'</td></tr>';
			$tplHelpdesks .= '<tr id="'.$hd['id_chamado'].'" class="mensagem '.$class.'"><td colspan="11">'.utf8_encode($hd['mensagem']).'</td></tr>';
		endforeach;
	endif;
	
	
	$tplOsSelect = "<option value=''>(vazio)</option>
					<option value='5048'	".($_SESSION['filtros']['os']=='5048'?'selected':'')."	>5048</option>
					<option value='5000'	".($_SESSION['filtros']['os']=='5000'?'selected':'')."	>5000</option>";
	
	$tplStatus = "<option value=''>(vazio)</option>
						<option value='naoAtendido'		".($_SESSION['filtros']['status']=='naoAtendido'?'selected':'')."	>N&atilde;o Atendido</option>
						<option value='emAtendimento'	".($_SESSION['filtros']['status']=='emAtendimento'?'selected':'')."	>Em Atendimento</option>
						<option value='finalizado'		".($_SESSION['filtros']['status']=='finalizado'?'selected':'')."	>Finalizado</option>";
	
	
	$tplCategoria = "<option value=''>(vazio)</option>";
	if($categoria->RetornarCategorias()):
		foreach ($categoria->RetornarCategorias() as $cat):
			$tplCategoria .= "<option value='". $cat['id_categoria'] ."' ". ($_SESSION['filtros']['categoria']==$cat['id_categoria']? 'selected': '') .">". $cat['descricao'] ."</option>";
		endforeach;
	endif;
	
	
	if(isset($_SESSION['filtros'])):
		$tplLimparFiltro = "<a href='?action=limparFiltro' class='tooltip' title='Limpar Filtro'><img id='deletar' src='images/delete.png' /></a>";
	endif;
						
	
	$pagina = new Template('templates/consultar.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'				=> 	'templates/cabecalho.tpl',
		'RODAPE'				=> 	'templates/rodape.tpl',
		'SCRIPTS'				=> 	$tplScripts,
		'CATEGORIA'				=>	$tplCategoria,
		'USUARIO' 				=> 	$usuario->GetNome(),
		'HELPDESKS'				=> 	$tplHelpdesks,
		'OS_SELECT'				=>	$tplOsSelect,
		'STATUS'				=>	$tplStatus,
		'NUMERO_CHAMADO'		=>	$_SESSION['filtros']['numeroChamado'],
		'USUARIO_FILTRO'		=> 	$_SESSION['filtros']['usuario'],
		'TEXTO'					=>	$_SESSION['filtros']['texto'],
		'DATA_ABERTURA_DE'		=>	$_SESSION['filtros']['dataAberturaDe'],
		'DATA_ABERTURA_ATE'		=>	$_SESSION['filtros']['dataAberturaAte'],
		'DATA_FECHAMENTO_DE'	=>	$_SESSION['filtros']['dataFechamentoDe'],
		'DATA_FECHAMENTO_ATE'	=>	$_SESSION['filtros']['dataFechamentoAte'],
		'LIMPAR_FILTRO'			=>	$tplLimparFiltro,
	));
	
	$pagina->mostrar(); 