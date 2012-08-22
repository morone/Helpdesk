<?php
	include_once '../class/master.inc.php';
	
	
	$usuario = new Usuario();

	$_SESSION['grupo'] = $usuario->GetGrupo($_SESSION['login']);

	header('location:../principal.php');