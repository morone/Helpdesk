<?php
	include_once '../class/master.inc.php';
	include_once '../class/Relatorio.php';
	
	$usuario 	= new Usuario();
	$chamado 	= new Chamado();
	$categoria 	= new Categoria();
	$relatorio 	= new Relatorio();
	
	if(isset($_GET)):
		switch ($_GET['action']):
			#RETORNA TODAS AS RESPOSTAS DE UM DETERMINADO CHAMADO. 
			case 'getRespostas':
				$respostas = $chamado->GetRespostas($_GET['idChamado']);
				$i=1;
				if($respostas):
					foreach($respostas as $resp):
						$tplRespostas .= "<div id='resposta".($i%2)."'><h3>". $resp['data'] ." - " . $usuario->GetUserByID($resp['usuario']) . ($i!=count($respostas)&& !$chamado->isFinalizado($_GET['idChamado'])?"&nbsp;<a href='?action=delresp&resposta=".$resp['id_resposta']."&id=".$_GET['idChamado']."'><img id='deletar' name='".$resp['data']."' src='images/delete.png' /></a>":"") . "</h3>";
						$tplRespostas .= "" . utf8_encode($resp['mensagem']) . "</div>";
						$i++;
					endforeach;
				endif;
				echo $tplRespostas;
				break;
			#GRAVA UMA NOVA RESPOSTA AO CHAMADO.
			case 'setResposta':
				$chamado->CriarResposta($_GET['idChamado'], $usuario->GetId(), $_GET['mensagem']);
				break;
			#GRAVA UMA NOVA CATEGORIA PARA CHAMADOS.
			case 'setCategorias':
				$categoria->CadastrarCategoria($_GET['categoria']);
				break;
			#RETORNA TODAS AS CATEGORIAS CADASTRADAS.
			case 'getCategorias':
				$categoria = $categoria->RetornarCategorias();
				if($categoria):
					$i=1;
					foreach($categoria as $cat):
						
						$tplCategorias .= "
						<tr>
							<td>".$cat['descricao']."</td>
							<td class='center'>".$cat['total']."</td><td class='center'>";
						
						if($cat['total']==0):
							$tplCategorias .= "<a href='?action=delcat&id=".$cat['id_categoria']."' class='tooltip' title='Excluir'><img src='images/delete.png' /></a>";
						endif;
						
						$tplCategorias .= "</td></tr>";

						$i++;
					endforeach;
					echo $tplCategorias;
				else:
					echo "Nenhuma Categoria Cadastrada";
				endif;
				break;
			#RETORNA TODOS OS PONTOS DO GRÁFICO GERAL
			case 'getPontosGeral':
				$j=0;
				for($i=7;$i<=19;$i++){
					$pontos.=  $j . "@" . $relatorio->GetMediaAberturaPorHoraGeral($i) . "#";
					$j++;
				}
					echo substr($pontos,0,-1);
				break;
			#RETORNA TODOS OS PONTOS DO GRÁFICO CATEGORIA
			/*case 'getPontosCategoria':
				$j=0;
				for($i=7;$i<=19;$i++){
					$pontos.=  $j . "@" . $relatorio->GetMediaAberturaPorHoraCategoria($i) . "#";
					$j++;
				}
					echo substr($pontos,0,-1);
				break;*/
		endswitch;
	endif;