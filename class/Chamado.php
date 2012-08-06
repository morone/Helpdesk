<?php

include "ChamadoDAO.php";

class Chamado{
	public function CriarChamado($idUsuario, $titulo, $mensagem, $os){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->CriarRespostaDAO($chamadoDAO->CriarChamadoDAO($idUsuario, $titulo, $os), $idUsuario, $mensagem);
	}
	
	public function CriarResposta($idChamado, $idUsuario, $mensagem){
		$chamadoDAO = new ChamadoDAO();
		$chamadoDAO->CriarRespostaDAO($idChamado, $idUsuario, $mensagem);
	}
	
	public function GetTodosChamados($idUsuario=""){
		$chamadoDAO = new ChamadoDAO();
		return $chamadoDAO->GetTodosChamadosDAO($idUsuario);
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
}