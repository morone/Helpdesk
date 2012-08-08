<?php

include_once "ChamadoDAO.php";

class Chamado{
	public function CriarChamado($idUsuario, $titulo, $mensagem, $os){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->CriarRespostaDAO($chamadoDAO->CriarChamadoDAO($idUsuario, $titulo, $os), $idUsuario, $mensagem);
	}
	
	public function CriarResposta($idChamado, $idUsuario, $mensagem){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->CriarRespostaDAO($idChamado, $idUsuario, $mensagem);
	}
	public function ApagarResposta($idResposta){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->ApagarRespostaDAO($idResposta);
	}
	
	public function GetTodosChamados($idUsuario="", $todosChamados=""){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetTodosChamadosDAO($idUsuario, $todosChamados);
	}
	
	public function GetRespostas($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetRespostasDAO($idChamado);
	}
	public function isFinalizado($idChamado){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->isFinalizadoDAO($idChamado);
	}
	
	public function Finalizar($idChamado){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->FinalizarDAO($idChamado);
	}
	
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