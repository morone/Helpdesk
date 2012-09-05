<?php
	
	session_start();
	
	if (!function_exists('conectaComBanco')): 
		function conectaComBanco($forcarContrato='')
		{
			$conexao = @new mysqli('localhost', 'root', '', 'helpdesk');

			if (!$conexao) {
				die('<br /><br /><strong>Problema com a conexão no Banco de Dados. Favor contatar o Administrador.</strong>');
			}
			return $conexao;
		}
	endif;

	if (!function_exists('desconectaDoBanco')):
		function desconectaDoBanco($conexao)
		{
			mysqli_close($conexao);
		}
	endif;
	
	if(!function_exists('GetFeriados')):
		function GetFeriados(){
			return Array('2012/09/07', '2012/10/12','2012/11/02','2012/11/15','2012/12/25');
		}
	endif;
	
	if (!in_array(preg_replace('/.*\/(.*)$/', '$1', $_SERVER['PHP_SELF']), array('index.php','senha.php',)) && (!isset($_SESSION['login']))) {  //verifica se a sessão com login está aberta
		header('location:index.php'); //se não estiver volta para tela de login
		die();
	}
	
	
	
	require_once 'paths.inc.php';
	
	
	include_once PATH_HELPDESK . '/class/Usuario.php';
	include_once PATH_HELPDESK . '/class/Chamado.php';
	include_once PATH_HELPDESK . '/class/Categoria.php';
	include_once PATH_HELPDESK . '/class/template.php';
	include_once PATH_HELPDESK . '/class/data.php';
	
	if (!function_exists('getMenu')):
		function getMenu(){
			$tplMenu = '';

			
			$tplMenu.= '<li><a href="principal.php">Abrir</a></li>';
			
			if(($_SESSION['grupo']=='TI')||($_SESSION['grupo']=='ADMIN')):
				$tplMenu.= '<li><a href="atender.php">Atender</a></li>';
			endif;
			
			$tplMenu.= '<li><a href="consultar.php">Consultar</a></li>';
			
			if(($_SESSION['grupo']=='TI')||($_SESSION['grupo']=='ADMIN')):
				$tplMenu.= '<li><a href="#">Administra&ccedil;&atilde;o</a>
								<ul>
									<li><a href="categoria.php">Categorias</a></li>';
				$tplMenu.= '		<li><a href="usuarios.php">Usu&aacute;rios</a></li>';
				if($_SESSION['grupo']=='ADMIN'):
					$tplMenu.= '		<li><a href="relatorio.php">Relat&oacute;rios</a></li>';
				endif;
				
				$tplMenu.= 	'	</ul>';	
				$tplMenu.= '</li>';
			endif;
			
			$tplMenu.= '<li><a href="sair.php">Sair</a></li>';

			return $tplMenu;
		}
	endif;

	
	