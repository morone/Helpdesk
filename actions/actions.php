<?php
	include '../class/Usuario.php';
	include '../class/Chamado.php';
	
	$usuario = new Usuario();
	$chamado = new Chamado();
	
	if(isset($_GET)):
		switch ($_GET['action']):
			case 'getRespostas':
				$respostas = $chamado->GetRespostas($_GET['idChamado']);
				foreach($respostas as $resp):
					$tplRespostas .= "<h3>". $resp['data'] ." - " . $usuario->GetUserByID($resp['usuario']) . " <img id='deletar' src='images/delete.png' /></h3>";
					$tplRespostas .= "<p>" . utf8_encode($resp['mensagem']) . "</p>";
				endforeach;
				echo $tplRespostas;
				break;
			case 'setResposta':
				$chamado->CriarResposta($_GET['idChamado'], $usuario->GetId(), $_GET['mensagem']);
				break;
		endswitch;
	endif;