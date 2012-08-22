<?php

	include_once 'class/master.inc.php';
	include 'class/Relatorio.php';

	$usuario 	= new Usuario();
	$chamado 	= new Chamado();
	$categoria 	= new Categoria();
	$relatorio	= new Relatorio();
	
	$tplScripts  = '<link rel="stylesheet" href="css/atender.css" media="screen" />';
	$tplScripts .= '<script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>';
	$tplScripts .= '<script language="javascript" type="text/javascript" src="js/relatorio.js"></script>';
	$tplScripts .= '<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->';
	
	#Média de atendimento geral
	$mediaTempoAtendimentoGeral = $relatorio->GetMediaAtendimentoGeral();
	if($mediaTempoAtendimentoGeral):
		foreach($mediaTempoAtendimentoGeral as $m):
			$tplMediaGeral .= "<tr><td>Total Geral de Atendimentos</td><td>".$m['media']."</td></tr>";
		endforeach;
	endif;
	###################################
	
	#Média de atendimento por categoria
	$mediaTempoAtendimentoPorCategoria = $relatorio->GetMediaAtendimentoPorCategoria();
	if($mediaTempoAtendimentoPorCategoria):
		foreach($mediaTempoAtendimentoPorCategoria as $m):
			$tplMediaPorCategoria .= "<tr><td>".$m['descricao']."</td><td>".$m['media']."</td></tr>";
		endforeach;
	endif;
	###################################
	
	
	#Média de abertura de helpdesks por dia
	$tplAberturaGeral .= "<tr><td>Chamados abertos</td><td>".$relatorio->GetMediaAberturaPorDiaGeral('SEMANA')."</td><td>".$relatorio->GetMediaAberturaPorDiaGeral('MES')."</td><td>".$relatorio->GetMediaAberturaPorDiaGeral('ANO')."</td></tr>";
	###################################
	
	#Média de atendimento por categoria
	$categorias = $categoria->RetornarCategorias();
	if($categorias):
		foreach($categorias as $cat):
			$tplAberturaCategoria .= "<tr><td>".$cat['descricao']."</td><td>".$relatorio->GetMediaAberturaPorDiaPorCategoria($cat['id_categoria'], 'SEMANA')."</td><td>".$relatorio->GetMediaAberturaPorDiaPorCategoria($cat['id_categoria'], 'MES')."</td><td>".$relatorio->GetMediaAberturaPorDiaPorCategoria($cat['id_categoria'], 'ANO')."</td></tr>";
		endforeach;
	endif;
	###################################
	
	
	$pagina = new Template('templates/relatorio.tpl');
	$pagina->trocarTags( array(
		'CABECALHO'				=> 	'templates/cabecalho.tpl',
		'RODAPE'				=> 	'templates/rodape.tpl',
		'SCRIPTS'				=> 	$tplScripts,
		'MEDIA_GERAL'			=>	$tplMediaGeral,
		'MEDIA_POR_CATEGORIA'	=>  $tplMediaPorCategoria,
		'ABERTURA_GERAL'		=>	$tplAberturaGeral,
		'ABERTURA_CATEGORIA'	=>	$tplAberturaCategoria, 
		'USUARIO' 				=> 	$usuario->GetNome(),
	));
	
	$pagina->mostrar(); 