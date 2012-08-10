<?php

	session_start();
	
	if (!function_exists('conectaComBanco')): 
		function conectaComBanco($forcarContrato='')
		{
			$conexao = @new mysqli('localhost', 'root', '', 'helpdesk_comos');

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
	
	
	require_once 'paths.inc.php';
	
	
	include_once PATH_HELPDESK . '/class/Usuario.php';
	include_once PATH_HELPDESK . '/class/Chamado.php';
	include_once PATH_HELPDESK . '/class/Categoria.php';
	include_once PATH_HELPDESK . '/class/template.php';
	
	