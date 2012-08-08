<?php
	include '../class/Usuario.php';
	include '../class/Chamado.php';
	
	$usuario = new Usuario();
	$chamado = new Chamado();
	
	if(isset($_GET)):
		switch ($_GET['action']):
			case 'getRespostas':
				$respostas = $chamado->GetRespostas($_GET['idChamado']);
				$i=1;
				foreach($respostas as $resp):
					$tplRespostas .= "<div id='resposta".($i%2)."'><h3>". $resp['data'] ." - " . $usuario->GetUserByID($resp['usuario']) . " <a href='?action=delresp&resposta=".$resp['id_resposta']."&id=".$_GET['idChamado']."'>". ($i!=count($respostas)&& !$chamado->isFinalizado($_GET['idChamado'])?"<img id='deletar' name='".$resp['data']."' src='images/delete.png' />":"") . "</a></h3>";
					$tplRespostas .= "" . utf8_encode($resp['mensagem']) . "</div>";
					$i++;
				endforeach;
				echo $tplRespostas;
				break;
			case 'setResposta':
				$chamado->CriarResposta($_GET['idChamado'], $usuario->GetId(), $_GET['mensagem']);
				break;
		endswitch;
	endif;