<?php

include_once "ChamadoDAO.php";
include_once "data.php";

class Chamado{
	public function CriarChamado($idUsuario, $titulo, $mensagem, $os, $categoria){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->CriarRespostaDAO($chamadoDAO->CriarChamadoDAO($idUsuario, $titulo, $os, $categoria), $idUsuario, $mensagem);
	}
	
	public function CriarResposta($idChamado, $idUsuario, $mensagem){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->CriarRespostaDAO($idChamado, $idUsuario, $mensagem);
	}
	public function ApagarResposta($idResposta){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->ApagarRespostaDAO($idResposta);
	}
	
	public function GetTodosChamados($filtros="", $idUsuario="", $todosChamados=""){
		$chamadoDAO = new ChamadoDAO();
		$chamados = $chamadoDAO->GetTodosChamadosDAO($filtros, $idUsuario, $todosChamados);
		
		for($i=0;$i<sizeof($chamados);$i++):
			
			$chamados[$i]['usuario'] = $this->AjustarNome($chamados[$i]['usuario']);
			$chamados[$i]['atendente'] = $this->AjustarNome($chamados[$i]['atendente']);
			
			if($chamados[$i]['finalizado']==1):	
				$chamados[$i]['totalGasto'] = $this->CalcularTempo($chamados[$i]['totalGasto']);
			else:
				$chamados[$i]['totalGasto']="-";
				$chamados[$i]['ultima_resp'] = "-";
			endif;
			
		endfor;
		
		return $chamados;
	}
	
	private function AjustarNome($nome){
		$nome = explode(" ", $nome);
		return $nome[0] . " " . $nome[sizeof($nome)-1];
	}
	
	private function CalcularTempo($minutos){
		$dias = floor($minutos/(60*24));
		$horas = floor($minutos%(60*24)/60);
		$minutos = floor(($minutos%(60*24)%60));
		
		if($dias>0)	$resposta .= $dias . "d";
		if($horas>0)$resposta .= $horas . "h";
		$resposta .= $minutos . "m";
		
		return $resposta;	
	}
	
	public function GetRespostas($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetRespostasDAO($idChamado);
	}
	public function isFinalizado($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->isFinalizadoDAO($idChamado);
	}
	
	####################
	public function Finalizar($idChamado){
		$chamadoDAO = new ChamadoDAO();
		$data = new Data();

		$timeDiff 			= $this->GetTimeDiff($idChamado);//Diferença em minutos entre a data de abertura e finalização.
		$dataInicioFinal 	= $this->GetDataInicioFinalizacao($idChamado);//As datas de inicio e finalização.
		$dias				= $data->getDiasUteis($dataInicioFinal[0], $dataInicioFinal[1],GetFeriados()); //Número de dias úteis entre a abertura e finalização do helpdesk.

		#840 é o número de minutos em 14h referentes ao período não trabalhado, considerando que o dia útil vai das 08:00h às 18:00h.
		if($dias>1):
			for($i=2;$i<=$dias;$i++)
				$timeDiff = $timeDiff-840;
		endif;

		$chamadoDAO->FinalizarDAO($idChamado,$timeDiff);
	}
	
	private function GetTimeDiff($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetTimeDiffDAO($idChamado);
	}
	private function GetDataInicioFinalizacao($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetDataInicioFinalizacaoDAO($idChamado);
	}
	######################
	
	public function AtenderChamado($idChamado){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->AtenderChamadoDAO($idChamado);
	}
	
	public function GetSolicitante($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetSolicitanteDAO($idChamado);
	}
	
	public function GetAtendente($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetAtendenteDAO($idChamado);
	}
	
}